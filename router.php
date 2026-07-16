<?php

declare(strict_types=1);

if (!headers_sent()) {
    header_remove('X-Powered-By');
}

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$requestPath = is_string($requestPath) ? rawurldecode($requestPath) : '/';
$requestPath = '/' . ltrim(str_replace('\\', '/', $requestPath), '/');
$lowerPath = strtolower($requestPath);
$pathSegments = explode('/', trim($requestPath, '/'));
$containsUnsafeSegment = array_filter(
    $pathSegments,
    static fn (string $segment): bool => $segment === '..' || str_starts_with($segment, '.')
) !== [];
$isInternalPath = preg_match('#^/(?:components|config|data|views)(?:/|$)#i', $requestPath) === 1;
$isPrivateDocument = preg_match('#\.(?:json|md|log|env)$#i', $requestPath) === 1
    || in_array($lowerPath, ['/license', '/router.php', '/.gitignore'], true);
$isDisallowedPhp = str_ends_with($lowerPath, '.php')
    && !in_array($lowerPath, ['/index.php', '/projeto.php'], true);

if (
    str_contains($requestPath, "\0")
    || $containsUnsafeSegment
    || $isInternalPath
    || $isPrivateDocument
    || $isDisallowedPhp
) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Página não encontrada.';

    return true;
}

if ($requestPath === '/') {
    require __DIR__ . '/index.php';

    return true;
}

if (in_array($lowerPath, ['/index.php', '/projeto.php'], true)) {
    return false;
}

$rootPath = realpath(__DIR__);
$assetPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . ltrim($requestPath, '/'));

if (
    is_string($rootPath)
    && is_string($assetPath)
    && str_starts_with(strtolower($assetPath), strtolower($rootPath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR))
    && is_file($assetPath)
) {
    return false;
}

http_response_code(404);
header('Content-Type: text/plain; charset=UTF-8');
echo 'Página não encontrada.';

return true;
