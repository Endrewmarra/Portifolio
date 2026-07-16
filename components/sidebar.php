<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

$isHomePage = ($currentPage ?? '') === 'home';
$homeAnchorPrefix = $isHomePage ? '' : 'index.php';
$profileName = isset($profile['name']) && is_string($profile['name'])
    ? $profile['name']
    : 'Endrew Marra Pedrosa';
$profileTitle = isset($profile['title']) && is_string($profile['title'])
    ? $profile['title']
    : null;
$profileSummary = isset($profile['summary']) && is_string($profile['summary'])
    ? $profile['summary']
    : null;
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
                <?php if ($profileTitle !== null): ?>
                    <p class="profile__title"><?= $escape($profileTitle) ?></p>
                <?php endif; ?>

                <?php if ($profileSummary !== null): ?>
                    <p class="profile__summary"><?= $escape($profileSummary) ?></p>
                <?php endif; ?>
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

            <?php if (!empty($profile['phone']) && !empty($profile['whatsapp'])): ?>
                <li>
                    <a href="<?= $escape($profile['whatsapp']) ?>" target="_blank" rel="noopener noreferrer">
                        Telefone
                    </a>
                </li>
            <?php elseif (!empty($profile['phoneHref'])): ?>
                <li><a href="tel:<?= $escape($profile['phoneHref']) ?>">Telefone</a></li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
