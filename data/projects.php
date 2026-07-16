<?php

declare(strict_types=1);

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
    $asciiValue = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
    $normalizedValue = is_string($asciiValue) ? $asciiValue : $value;
    $slug = strtolower($normalizedValue);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    return trim(is_string($slug) ? $slug : '', '-');
};

$validateHttpsUrl = static function (mixed $value): ?string {
    if (!is_string($value)) {
        return null;
    }

    $url = trim($value);

    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return null;
    }

    return parse_url($url, PHP_URL_SCHEME) === 'https' ? $url : null;
};

$projectImagesRoot = realpath(__DIR__ . '/../assets/images/projects');
$projects = [];
$usedSlugs = [];

foreach ($rawProjects as $index => $rawProject) {
    if (!is_array($rawProject)) {
        continue;
    }

    $name = isset($rawProject['nome']) && is_string($rawProject['nome'])
        ? trim($rawProject['nome'])
        : '';
    $shortDescription = isset($rawProject['descricao']) && is_string($rawProject['descricao'])
        ? trim($rawProject['descricao'])
        : '';

    if ($name === '' || $shortDescription === '') {
        continue;
    }

    $baseSlug = $slugify($name);

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
            if (!is_string($technology)) {
                continue;
            }

            $technology = trim($technology);

            if ($technology !== '' && !in_array($technology, $technologies, true)) {
                $technologies[] = $technology;
            }
        }
    }

    $image = null;
    $rawImage = isset($rawProject['images'][0]) && is_string($rawProject['images'][0])
        ? trim($rawProject['images'][0])
        : '';

    if ($rawImage !== '' && is_string($projectImagesRoot)) {
        $normalizedImage = str_replace('\\', '/', $rawImage);
        $knownPrefixes = [
            'assets/images/projects/',
            './images/projects/',
            '../images/projects/',
            'images/projects/',
        ];

        foreach ($knownPrefixes as $prefix) {
            if (str_starts_with($normalizedImage, $prefix)) {
                $normalizedImage = substr($normalizedImage, strlen($prefix));
                break;
            }
        }

        if ($normalizedImage !== '' && !str_contains($normalizedImage, '..')) {
            $imagePath = realpath(
                $projectImagesRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $normalizedImage)
            );

            if (
                is_string($imagePath)
                && str_starts_with(strtolower($imagePath), strtolower($projectImagesRoot . DIRECTORY_SEPARATOR))
            ) {
                $relativeImage = str_replace(
                    DIRECTORY_SEPARATOR,
                    '/',
                    substr($imagePath, strlen($projectImagesRoot) + 1)
                );
                $encodedImage = implode('/', array_map('rawurlencode', explode('/', $relativeImage)));
                $image = 'assets/images/projects/' . $encodedImage;
            }
        }
    }

    $projects[] = [
        'slug' => $slug,
        'name' => $name,
        'shortDescription' => $shortDescription,
        'technologies' => $technologies,
        'repositoryUrl' => $validateHttpsUrl($rawProject['link'] ?? null),
        'image' => $image,
    ];
}

return $projects;
