<?php

declare(strict_types=1);

$defaultProfile = [
    'name' => 'Endrew Marra Pedrosa',
    'image' => null,
    'github' => null,
    'linkedin' => null,
    'email' => null,
    'phone' => null,
    'phoneHref' => null,
];

$profileFile = __DIR__ . '/../assets/infos.JSON';

try {
    $json = file_get_contents($profileFile);

    if ($json === false) {
        throw new RuntimeException('Não foi possível ler os dados do perfil.');
    }

    $rawProfile = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
} catch (Throwable $exception) {
    error_log('Não foi possível carregar os dados públicos do perfil.');

    return $defaultProfile;
}

if (!is_array($rawProfile)) {
    return $defaultProfile;
}

$profile = $defaultProfile;

if (isset($rawProfile['name']) && is_string($rawProfile['name'])) {
    $name = trim($rawProfile['name']);

    if ($name !== '') {
        $profile['name'] = $name;
    }
}

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

$profile['github'] = $validateHttpsUrl($rawProfile['github'] ?? null);
$profile['linkedin'] = $validateHttpsUrl($rawProfile['linkedin'] ?? null);

if (isset($rawProfile['email']) && is_string($rawProfile['email'])) {
    $email = trim($rawProfile['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        $profile['email'] = $email;
    }
}

if (isset($rawProfile['tel']) && is_string($rawProfile['tel'])) {
    $phone = trim($rawProfile['tel']);

    if (preg_match('/^\+?[0-9() .-]{7,25}$/', $phone) === 1) {
        $digits = preg_replace('/\D+/', '', $phone);

        if (is_string($digits) && $digits !== '') {
            $profile['phone'] = $phone;
            $profile['phoneHref'] = (str_starts_with($phone, '+') ? '+' : '') . $digits;
        }
    }
}

if (isset($rawProfile['image']) && is_string($rawProfile['image'])) {
    $assetsRoot = realpath(__DIR__ . '/../assets');
    $imagesRoot = realpath(__DIR__ . '/../assets/images');
    $relativeImage = str_replace('\\', '/', trim($rawProfile['image']));
    $relativeImage = preg_replace('#^(?:\./)+#', '', $relativeImage);

    if (
        is_string($assetsRoot)
        && is_string($imagesRoot)
        && is_string($relativeImage)
        && $relativeImage !== ''
        && !str_contains($relativeImage, '..')
    ) {
        $imagePath = realpath($assetsRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativeImage));
        $allowedExtensions = ['avif', 'jpeg', 'jpg', 'png', 'webp'];

        if (
            is_string($imagePath)
            && str_starts_with(strtolower($imagePath), strtolower($imagesRoot . DIRECTORY_SEPARATOR))
            && in_array(strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)), $allowedExtensions, true)
        ) {
            $webPath = str_replace(DIRECTORY_SEPARATOR, '/', substr($imagePath, strlen($assetsRoot) + 1));
            $encodedPath = implode('/', array_map('rawurlencode', explode('/', $webPath)));
            $profile['image'] = 'assets/' . $encodedPath;
        }
    }
}

return $profile;
