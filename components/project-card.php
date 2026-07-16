<?php

declare(strict_types=1);

if (!isset($project) || !is_array($project)) {
    return;
}

$escape = $escape ?? static fn (mixed $value): string => htmlspecialchars(
    (string) $value,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
?>
<article class="project-card">
    <?php if (!empty($project['image'])): ?>
        <img
            class="project-card__image"
            src="<?= $escape($project['image']) ?>"
            alt="Prévia do projeto <?= $escape($project['name']) ?>"
            loading="lazy"
        >
    <?php endif; ?>

    <div class="project-card__body">
        <h3><?= $escape($project['name']) ?></h3>
        <p><?= $escape($project['shortDescription']) ?></p>

        <?php if (!empty($project['technologies'])): ?>
            <ul class="tag-list" aria-label="Tecnologias utilizadas">
                <?php foreach ($project['technologies'] as $technology): ?>
                    <li><?= $escape($technology) ?></li>
                <?php endforeach; ?>
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
