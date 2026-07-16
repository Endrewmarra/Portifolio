<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

return [
    [
        'name' => 'Desenvolvimento web',
        'items' => ['HTML', 'CSS', 'JavaScript', 'TypeScript', 'React', 'Next.js', 'PHP', 'Material UI'],
    ],
    [
        'name' => 'Backend e dados',
        'items' => ['Python', 'FastAPI', 'SQL', 'MySQL', 'MongoDB', 'PyMongo', 'APIs REST', 'ETL'],
    ],
    [
        'name' => 'Ferramentas e práticas',
        'items' => [
            'Git',
            'GitHub',
            'Figma',
            'Programação orientada a objetos',
            'Engenharia de software',
            'Documentação de requisitos',
            'Algoritmos',
        ],
    ],
];
