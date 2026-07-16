<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

if (!isset($view) || !is_string($view) || !is_file($view)) {
    throw new RuntimeException('A view solicitada não está disponível.');
}

$escape = static fn (mixed $value): string => htmlspecialchars(
    (string) $value,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);

$siteName = isset($profile['name']) && is_string($profile['name'])
    ? $profile['name']
    : 'Portfólio';
$documentTitle = isset($pageTitle) && is_string($pageTitle)
    ? $pageTitle
    : $siteName;
$documentDescription = isset($pageDescription) && is_string($pageDescription)
    ? $pageDescription
    : 'Portfólio profissional.';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $escape($documentDescription) ?>">
    <meta name="color-scheme" content="light">
    <title><?= $escape($documentTitle) ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/images/profile/favicon.svg">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/variables.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/main.js" defer></script>
</head>
<body>
    <a class="skip-link" href="#conteudo-principal">Pular para o conteúdo</a>

    <div class="site-shell">
        <?php require __DIR__ . '/sidebar.php'; ?>

        <div class="site-content">
            <main class="main-content" id="conteudo-principal" tabindex="-1">
                <?php require $view; ?>
            </main>

            <?php require __DIR__ . '/footer.php'; ?>
        </div>
    </div>
</body>
</html>
