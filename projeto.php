<?php

declare(strict_types=1);

$profile = require __DIR__ . '/data/profile.php';
$projects = require __DIR__ . '/data/projects.php';

$requestedSlug = isset($_GET['slug']) && is_string($_GET['slug'])
    ? trim($_GET['slug'])
    : '';

$project = null;

if (preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $requestedSlug) === 1) {
    foreach ($projects as $availableProject) {
        if ($availableProject['slug'] === $requestedSlug) {
            $project = $availableProject;
            break;
        }
    }
}

if ($project === null) {
    http_response_code(404);
}

$pageTitle = $project === null
    ? 'Projeto não encontrado | ' . $profile['name']
    : $project['name'] . ' | ' . $profile['name'];
$pageDescription = $project['shortDescription'] ?? 'O projeto solicitado não foi encontrado.';
$currentPage = 'project';
$view = __DIR__ . '/views/project-details.php';

require __DIR__ . '/components/layout.php';
