<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

$projectsFile = __DIR__ . '/../assets/projects/projects.JSON';

try {
    $json = file_get_contents($projectsFile);

    if ($json === false) {
        throw new RuntimeException('Não foi possível ler os projetos.');
    }

    $rawProjects = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
} catch (Throwable $exception) {
    error_log('Não foi possível carregar os dados públicos dos projetos.');

    return [];
}

if (!is_array($rawProjects)) {
    return [];
}

$slugify = static function (string $value): string {
    $value = strtr($value, [
        'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c',
        'Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
        'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
        'Ç' => 'C',
    ]);
    $asciiValue = function_exists('iconv')
        ? iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value)
        : false;
    $normalizedValue = is_string($asciiValue) ? $asciiValue : $value;
    $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($normalizedValue));

    return trim(is_string($slug) ? $slug : '', '-');
};

$readOptionalText = static function (mixed $value, int $maximumLength): ?string {
    if (!is_string($value)) {
        return null;
    }

    $value = trim($value);

    return $value !== '' && strlen($value) <= $maximumLength ? $value : null;
};

$projectImagesRoot = realpath(__DIR__ . '/../assets/images/projects');
$normalizeImage = static function (
    mixed $rawImage,
    string $projectName
) use ($projectImagesRoot, $readOptionalText): ?array {
    if (!is_string($projectImagesRoot)) {
        return null;
    }

    $source = null;
    $alternativeText = null;

    if (is_string($rawImage)) {
        $source = trim($rawImage);
    } elseif (is_array($rawImage)) {
        $source = isset($rawImage['src']) && is_string($rawImage['src'])
            ? trim($rawImage['src'])
            : null;
        $alternativeText = $readOptionalText($rawImage['alt'] ?? null, 240);
    }

    if ($source === null || $source === '' || str_contains($source, '\\')) {
        return null;
    }

    $normalizedSource = str_replace('\\', '/', $source);
    $knownPrefixes = [
        'assets/images/projects/',
        './assets/images/projects/',
        './images/projects/',
        '../images/projects/',
        'images/projects/',
    ];

    foreach ($knownPrefixes as $prefix) {
        if (str_starts_with($normalizedSource, $prefix)) {
            $normalizedSource = substr($normalizedSource, strlen($prefix));
            break;
        }
    }

    $pathSegments = explode('/', $normalizedSource);

    if (
        $normalizedSource === ''
        || str_starts_with($normalizedSource, '/')
        || preg_match('/^[a-z][a-z0-9+.-]*:/i', $normalizedSource) === 1
        || array_filter(
            $pathSegments,
            static fn (string $segment): bool => $segment === '' || $segment === '.' || $segment === '..'
        ) !== []
    ) {
        return null;
    }

    $imagePath = realpath(
        $projectImagesRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $normalizedSource)
    );
    $allowedExtensions = ['avif', 'jpeg', 'jpg', 'png', 'webp'];

    if (
        !is_string($imagePath)
        || !str_starts_with(strtolower($imagePath), strtolower($projectImagesRoot . DIRECTORY_SEPARATOR))
        || !in_array(strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)), $allowedExtensions, true)
    ) {
        return null;
    }

    $relativeImage = str_replace(
        DIRECTORY_SEPARATOR,
        '/',
        substr($imagePath, strlen($projectImagesRoot) + 1)
    );
    $encodedImage = implode('/', array_map('rawurlencode', explode('/', $relativeImage)));

    return [
        'src' => 'assets/images/projects/' . $encodedImage,
        'alt' => $alternativeText ?? sprintf('Captura de tela do projeto %s', $projectName),
    ];
};

$projects = [];
$usedSlugs = [];

foreach ($rawProjects as $index => $rawProject) {
    if (!is_array($rawProject)) {
        continue;
    }

    $name = $readOptionalText($rawProject['nome'] ?? null, 160) ?? '';
    $shortDescription = $readOptionalText($rawProject['descricao'] ?? null, 600) ?? '';

    if ($name === '' || $shortDescription === '') {
        continue;
    }

    $providedSlug = $readOptionalText($rawProject['slug'] ?? null, 120);
    $baseSlug = $providedSlug !== null
        && preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $providedSlug) === 1
            ? $providedSlug
            : $slugify($name);

    if ($baseSlug === '') {
        $baseSlug = 'projeto-' . ($index + 1);
    }

    $slug = $baseSlug;
    $suffix = 2;

    while (isset($usedSlugs[$slug])) {
        $slug = $baseSlug . '-' . $suffix;
        $suffix++;
    }

    $usedSlugs[$slug] = true;
    $technologies = [];

    if (isset($rawProject['tecnologias']) && is_array($rawProject['tecnologias'])) {
        foreach ($rawProject['tecnologias'] as $technology) {
            $technology = $readOptionalText($technology, 80);

            if ($technology !== null && !in_array($technology, $technologies, true)) {
                $technologies[] = $technology;
            }
        }
    }

    $images = [];
    $seenImages = [];

    if (isset($rawProject['images']) && is_array($rawProject['images'])) {
        foreach ($rawProject['images'] as $rawImage) {
            $image = $normalizeImage($rawImage, $name);

            if ($image === null || isset($seenImages[$image['src']])) {
                continue;
            }

            $seenImages[$image['src']] = true;
            $images[] = $image;

            if (count($images) === 6) {
                break;
            }
        }
    }

    $demoValue = $rawProject['demo'] ?? $rawProject['demoUrl'] ?? null;

    $projects[] = [
        'slug' => $slug,
        'name' => $name,
        'shortDescription' => $shortDescription,
        'description' => $readOptionalText($rawProject['descricaoCompleta'] ?? null, 5000),
        'technologies' => $technologies,
        'repositoryUrl' => portfolio_validate_https_url($rawProject['link'] ?? null),
        'demoUrl' => portfolio_validate_https_url($demoValue),
        'status' => $readOptionalText($rawProject['status'] ?? null, 80),
        'featured' => isset($rawProject['destaque']) && is_bool($rawProject['destaque'])
            ? $rawProject['destaque']
            : null,
        'images' => $images,
    ];
}

return $projects;
