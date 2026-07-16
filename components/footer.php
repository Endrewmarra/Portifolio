<?php

declare(strict_types=1);

$escape = $escape ?? static fn (mixed $value): string => htmlspecialchars(
    (string) $value,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
$footerName = isset($profile['name']) && is_string($profile['name'])
    ? $profile['name']
    : 'Endrew Marra Pedrosa';
?>
<footer class="site-footer">
    <p>&copy; <?= date('Y') ?> <?= $escape($footerName) ?>. Portfólio desenvolvido em PHP.</p>
</footer>
