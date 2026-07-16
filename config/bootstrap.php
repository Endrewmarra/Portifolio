<?php

declare(strict_types=1);

if (!defined('PORTFOLIO_APP')) {
    http_response_code(404);
    exit;
}

$isDevelopment = PHP_SAPI === 'cli-server' || getenv('APP_ENV') === 'development';

error_reporting(E_ALL);
ini_set('display_errors', $isDevelopment ? '1' : '0');
ini_set('display_startup_errors', $isDevelopment ? '1' : '0');
ini_set('log_errors', '1');

if (!headers_sent()) {
    header('Content-Security-Policy: default-src \'self\'; img-src \'self\' data:; style-src \'self\'; script-src \'self\'; base-uri \'self\'; form-action \'self\'; frame-ancestors \'none\'');
    header('Permissions-Policy: camera=(), geolocation=(), microphone=()');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
}
