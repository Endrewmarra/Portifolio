<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

$footerName = isset($profile['name']) && is_string($profile['name'])
    ? $profile['name']
    : 'Endrew Marra Pedrosa';
?>
<footer class="site-footer">
    <p>&copy; <?= date('Y') ?> <?= $escape($footerName) ?>. Portfólio desenvolvido em PHP.</p>
</footer>
