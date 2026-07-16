<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

$projectImages = isset($project['images']) && is_array($project['images'])
    ? $project['images']
    : [];
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

        <header class="project-detail__header">
            <p class="eyebrow">Projeto</p>
            <h1><?= $escape($project['name']) ?></h1>
            <p class="project-detail__summary"><?= $escape($project['shortDescription']) ?></p>

            <?php if (!empty($project['status'])): ?>
                <p class="project-status"><?= $escape($project['status']) ?></p>
            <?php endif; ?>
        </header>

        <?php if ($projectImages !== []): ?>
            <section class="project-gallery" aria-labelledby="galeria-titulo">
                <div class="project-gallery__heading">
                    <h2 id="galeria-titulo">Capturas de tela</h2>
                    <p><?= count($projectImages) ?> <?= count($projectImages) === 1 ? 'imagem' : 'imagens' ?></p>
                </div>

                <div class="project-gallery__grid">
                    <?php foreach ($projectImages as $imageIndex => $image): ?>
                        <?php
                        $isFeaturedImage = $imageIndex === 0;
                        $itemClass = $isFeaturedImage
                            ? 'project-gallery__item project-gallery__item--featured'
                            : 'project-gallery__item';
                        $galleryLinkLabel = sprintf(
                            'Abrir %s em tamanho original (nova aba)',
                            $image['alt']
                        );
                        ?>
                        <figure class="<?= $itemClass ?>">
                            <a
                                class="project-gallery__link"
                                href="<?= $escape($image['src']) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="<?= $escape($galleryLinkLabel) ?>"
                            >
                                <img
                                    src="<?= $escape($image['src']) ?>"
                                    alt="<?= $escape($image['alt']) ?>"
                                    <?= $imageIndex > 0 ? 'loading="lazy"' : '' ?>
                                    decoding="async"
                                >
                            </a>
                            <figcaption>Captura <?= $imageIndex + 1 ?> de <?= count($projectImages) ?></figcaption>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($project['description'])): ?>
            <section class="project-detail__description" aria-labelledby="descricao-projeto-titulo">
                <h2 id="descricao-projeto-titulo">Sobre o projeto</h2>
                <p><?= $escape($project['description']) ?></p>
            </section>
        <?php endif; ?>

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

        <?php if (!empty($project['repositoryUrl']) || !empty($project['demoUrl'])): ?>
            <div class="project-detail__actions">
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

                <?php if (!empty($project['demoUrl'])): ?>
                    <a
                        class="button-link button-link--secondary"
                        href="<?= $escape($project['demoUrl']) ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Abrir demonstração
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </article>
<?php endif; ?>
