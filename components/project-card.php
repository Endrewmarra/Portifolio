<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

if (!isset($project) || !is_array($project)) {
    return;
}

$images = isset($project['images']) && is_array($project['images'])
    ? $project['images']
    : [];
$coverImage = $images[0] ?? null;
$technologies = isset($project['technologies']) && is_array($project['technologies'])
    ? $project['technologies']
    : [];
$visibleTechnologies = array_slice($technologies, 0, 4);
$hiddenTechnologyCount = max(0, count($technologies) - count($visibleTechnologies));
?>
<article class="project-card">
    <div class="project-card__media">
        <?php if (is_array($coverImage)): ?>
            <img
                class="project-card__image"
                src="<?= $escape($coverImage['src']) ?>"
                alt="<?= $escape($coverImage['alt']) ?>"
                loading="lazy"
                decoding="async"
            >

            <?php if (count($images) > 1): ?>
                <span class="project-card__image-count">
                    <?= count($images) ?> imagens
                </span>
            <?php endif; ?>
        <?php else: ?>
            <div class="project-card__placeholder" aria-hidden="true">
                <span>Imagem em breve</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="project-card__body">
        <h3><?= $escape($project['name']) ?></h3>

        <?php if (!empty($project['status'])): ?>
            <p class="project-status"><?= $escape($project['status']) ?></p>
        <?php endif; ?>

        <p class="project-card__description"><?= $escape($project['shortDescription']) ?></p>

        <?php if ($visibleTechnologies !== []): ?>
            <ul class="tag-list" aria-label="Tecnologias utilizadas">
                <?php foreach ($visibleTechnologies as $technology): ?>
                    <li><?= $escape($technology) ?></li>
                <?php endforeach; ?>

                <?php if ($hiddenTechnologyCount > 0): ?>
                    <li class="tag-list__more" aria-label="Mais <?= $hiddenTechnologyCount ?> tecnologias">
                        +<?= $hiddenTechnologyCount ?>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

        <div class="project-card__actions">
            <a class="text-link" href="projeto.php?slug=<?= rawurlencode($project['slug']) ?>">
                Ver detalhes
            </a>

            <?php if (!empty($project['repositoryUrl'])): ?>
                <a
                    class="text-link text-link--secondary"
                    href="<?= $escape($project['repositoryUrl']) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Repositório
                </a>
            <?php endif; ?>
        </div>
    </div>
</article>
