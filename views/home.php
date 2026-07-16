<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

$profileName = isset($profile['name']) && is_string($profile['name'])
    ? $profile['name']
    : 'Endrew Marra Pedrosa';
$profileTitle = isset($profile['title']) && is_string($profile['title'])
    ? $profile['title']
    : 'Estudante de Análise e Desenvolvimento de Sistemas';
$profileSummary = isset($profile['summary']) && is_string($profile['summary'])
    ? $profile['summary']
    : 'Experiência em projetos acadêmicos e pessoais.';
?>
<header class="intro" id="inicio">
    <h1>Olá, eu sou <?= $escape($profileName) ?>.</h1>
    <p class="intro__lead">
        <?= $escape($profileTitle) ?>. <?= $escape($profileSummary) ?>
    </p>
</header>

<section class="content-section" id="sobre" aria-labelledby="sobre-titulo">
    <div class="section-heading">
        <p class="eyebrow">Apresentação</p>
        <h2 id="sobre-titulo">Sobre mim</h2>
    </div>

    <div class="prose">
        <p>
            Sou estudante de Análise e Desenvolvimento de Sistemas, apaixonado por tecnologia e por transformar
            ideias em soluções práticas.
        </p>
        <p>
            Minha trajetória profissional começou nas áreas da educação e da música. Essas experiências
            desenvolveram habilidades como comunicação, disciplina, trabalho em equipe e resolução de problemas.
            Hoje, aplico essas competências no desenvolvimento de software, buscando criar aplicações organizadas,
            funcionais e focadas nas necessidades dos usuários.
        </p>
        <p>
            Tenho experiência com projetos acadêmicos e pessoais nas áreas de desenvolvimento web, backend e dados.
            Atualmente, também estou aprofundando meus conhecimentos em PHP por meio do desenvolvimento deste
            portfólio.
        </p>
        <p>
            Acredito que aprender vai muito além da teoria. Gosto de construir projetos práticos, experimentar novas
            tecnologias e compreender como elas funcionam. Sigo estudando continuamente para evoluir como
            desenvolvedor e criar soluções cada vez mais eficientes.
        </p>
    </div>
</section>

<section class="content-section" id="projetos" aria-labelledby="projetos-titulo">
    <div class="section-heading">
        <p class="eyebrow">Trabalhos selecionados</p>
        <h2 id="projetos-titulo">Projetos</h2>
    </div>

    <?php if ($projects !== []): ?>
        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <?php require __DIR__ . '/../components/project-card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="empty-state">Os projetos estarão disponíveis em breve.</p>
    <?php endif; ?>
</section>

<section class="content-section" id="tecnologias" aria-labelledby="tecnologias-titulo">
    <div class="section-heading">
        <p class="eyebrow">Conhecimentos aplicados</p>
        <h2 id="tecnologias-titulo">Tecnologias</h2>
        <p>Tecnologias e práticas presentes nos projetos apresentados.</p>
    </div>

    <?php if ($technologyGroups !== []): ?>
        <div class="technology-groups">
            <?php foreach ($technologyGroups as $group): ?>
                <article class="technology-group">
                    <h3><?= $escape($group['name']) ?></h3>
                    <ul class="technology-list">
                        <?php foreach ($group['items'] as $technology): ?>
                            <li><?= $escape($technology) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<section class="content-section contact-section" id="contato" aria-labelledby="contato-titulo">
    <div class="section-heading">
        <p class="eyebrow">Contato</p>
        <h2 id="contato-titulo">Vamos conversar?</h2>
        <p>Escolha o canal mais conveniente para entrar em contato.</p>
    </div>

    <ul class="contact-list">
        <?php if (!empty($profile['email'])): ?>
            <li>
                <span>E-mail</span>
                <a href="mailto:<?= $escape($profile['email']) ?>"><?= $escape($profile['email']) ?></a>
            </li>
        <?php endif; ?>

        <?php if (!empty($profile['phone']) && !empty($profile['whatsapp'])): ?>
            <li>
                <span>Telefone / WhatsApp</span>
                <a
                    href="<?= $escape($profile['whatsapp']) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <?= $escape($profile['phone']) ?>
                </a>
            </li>
        <?php elseif (!empty($profile['phoneHref']) && !empty($profile['phone'])): ?>
            <li>
                <span>Telefone</span>
                <a href="tel:<?= $escape($profile['phoneHref']) ?>"><?= $escape($profile['phone']) ?></a>
            </li>
        <?php endif; ?>

        <?php if (!empty($profile['linkedin'])): ?>
            <li>
                <span>LinkedIn</span>
                <a href="<?= $escape($profile['linkedin']) ?>" target="_blank" rel="noopener noreferrer">
                    Acessar perfil
                </a>
            </li>
        <?php endif; ?>

        <?php if (!empty($profile['github'])): ?>
            <li>
                <span>GitHub</span>
                <a href="<?= $escape($profile['github']) ?>" target="_blank" rel="noopener noreferrer">
                    Ver repositórios
                </a>
            </li>
        <?php endif; ?>
    </ul>
</section>
