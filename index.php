<?php

declare(strict_types=1);

$profile = require __DIR__ . '/data/profile.php';
$projects = require __DIR__ . '/data/projects.php';

$pageTitle = 'Portfólio | ' . $profile['name'];
$pageDescription = 'Portfólio de ' . $profile['name'] . ' com projetos, tecnologias e formas de contato.';
$currentPage = 'home';
$view = __DIR__ . '/views/home.php';

require __DIR__ . '/components/layout.php';
