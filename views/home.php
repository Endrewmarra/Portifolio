<?php

declare(strict_types=1);

$escape = $escape ?? static fn (mixed $value): string => htmlspecialchars(
    (string) $value,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
$profileName = isset($profile['name']) && is_string($profile['name'])
    ? $profile['name']
    : 'Endrew Marra Pedrosa';
$technologies = [];

foreach ($projects as $listedProject) {
    foreach ($listedProject['technologies'] as $technology) {
        if (!in_array($technology, $technologies, true)) {
            $technologies[] = $technology;
        }
    }
}
?>
<header class="intro" id="inicio">
    <p class="eyebrow">Portfólio</p>
    <h1>Olá, eu sou <?= $escape($profileName) ?>.</h1>
    <p class="intro__lead">
        Estudante de Análise e Desenvolvimento de Sistemas, com experiência em projetos acadêmicos e pessoais.
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
            Tenho experiência com projetos acadêmicos e pessoais utilizando Python, HTML, CSS, JavaScript, React,
            FastAPI, SQL, MySQL, MongoDB e Git. Atualmente, também estou aprofundando meus conhecimentos em PHP por
            meio do desenvolvimento deste portfólio.
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
        <p>Projetos práticos e acadêmicos carregados diretamente do arquivo JSON do portfólio.</p>
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

    <?php if ($technologies !== []): ?>
        <ul class="technology-list">
            <?php foreach ($technologies as $technology): ?>
                <li><?= $escape($technology) ?></li>
            <?php endforeach; ?>
        </ul>
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

        <?php if (!empty($profile['phoneHref']) && !empty($profile['phone'])): ?>
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
