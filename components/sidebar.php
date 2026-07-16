<?php

declare(strict_types=1);

$escape = $escape ?? static fn (mixed $value): string => htmlspecialchars(
    (string) $value,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
$isHomePage = ($currentPage ?? '') === 'home';
$homeAnchorPrefix = $isHomePage ? '' : 'index.php';
$profileName = isset($profile['name']) && is_string($profile['name'])
    ? $profile['name']
    : 'Endrew Marra Pedrosa';
?>
<aside class="sidebar" aria-label="Apresentação e navegação">
    <div class="sidebar__inner">
        <div class="profile">
            <?php if (!empty($profile['image'])): ?>
                <a class="profile__image-link" href="index.php" aria-label="Ir para o início">
                    <img
                        class="profile__image"
                        src="<?= $escape($profile['image']) ?>"
                        alt="Foto de <?= $escape($profileName) ?>"
                        width="460"
                        height="460"
                    >
                </a>
            <?php endif; ?>

            <div class="profile__copy">
                <a class="profile__name" href="index.php"><?= $escape($profileName) ?></a>
                <p class="profile__label">Portfólio</p>
            </div>
        </div>

        <nav class="sidebar__nav" aria-label="Navegação principal">
            <ul>
                <li><a href="<?= $escape($homeAnchorPrefix) ?>#sobre">Sobre</a></li>
                <li><a href="<?= $escape($homeAnchorPrefix) ?>#projetos">Projetos</a></li>
                <li><a href="<?= $escape($homeAnchorPrefix) ?>#tecnologias">Tecnologias</a></li>
                <li><a href="<?= $escape($homeAnchorPrefix) ?>#contato">Contato</a></li>
            </ul>
        </nav>

        <ul class="sidebar__links" aria-label="Links profissionais e contato">
            <?php if (!empty($profile['github'])): ?>
                <li>
                    <a href="<?= $escape($profile['github']) ?>" target="_blank" rel="noopener noreferrer">
                        GitHub
                    </a>
                </li>
            <?php endif; ?>

            <?php if (!empty($profile['linkedin'])): ?>
                <li>
                    <a href="<?= $escape($profile['linkedin']) ?>" target="_blank" rel="noopener noreferrer">
                        LinkedIn
                    </a>
                </li>
            <?php endif; ?>

            <?php if (!empty($profile['email'])): ?>
                <li><a href="mailto:<?= $escape($profile['email']) ?>">E-mail</a></li>
            <?php endif; ?>

            <?php if (!empty($profile['phoneHref'])): ?>
                <li><a href="tel:<?= $escape($profile['phoneHref']) ?>">Telefone</a></li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
