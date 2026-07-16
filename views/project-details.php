<?php

declare(strict_types=1);

$escape = $escape ?? static fn (mixed $value): string => htmlspecialchars(
    (string) $value,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
?>
<?php if ($project === null): ?>
    <section class="project-detail project-detail--missing" aria-labelledby="projeto-titulo">
        <p class="eyebrow">Erro 404</p>
        <h1 id="projeto-titulo">Projeto não encontrado</h1>
        <p>O endereço informado não corresponde a um projeto disponível.</p>
        <a class="button-link" href="index.php#projetos">Voltar aos projetos</a>
    </section>
<?php else: ?>
    <article class="project-detail">
        <a class="back-link" href="index.php#projetos">&larr; Voltar aos projetos</a>

        <?php if (!empty($project['image'])): ?>
            <img
                class="project-detail__image"
                src="<?= $escape($project['image']) ?>"
                alt="Prévia do projeto <?= $escape($project['name']) ?>"
            >
        <?php endif; ?>

        <header class="project-detail__header">
            <p class="eyebrow">Projeto</p>
            <h1><?= $escape($project['name']) ?></h1>
            <p class="project-detail__summary"><?= $escape($project['shortDescription']) ?></p>
        </header>

        <?php if (!empty($project['technologies'])): ?>
            <section aria-labelledby="tecnologias-projeto-titulo">
                <h2 id="tecnologias-projeto-titulo">Tecnologias e práticas</h2>
                <ul class="tag-list" aria-label="Tecnologias utilizadas">
                    <?php foreach ($project['technologies'] as $technology): ?>
                        <li><?= $escape($technology) ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if (!empty($project['repositoryUrl'])): ?>
            <a
                class="button-link"
                href="<?= $escape($project['repositoryUrl']) ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                Acessar repositório
            </a>
        <?php endif; ?>
    </article>
<?php endif; ?>
