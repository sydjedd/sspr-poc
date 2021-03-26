<?php
$URI = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

if (preg_match('/favicon.ico$/', $URI)) {
    header_remove();
    header('Content-Type: image/x-icon');
    require(__DIR__ . '/img/favicon.ico');
} elseif (preg_match('/\.png$/', $URI)) {
    header_remove();
    header('Content-Type: image/png');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.jpg$/', $URI)) {
    header_remove();
    header('Content-Type: image/jpeg');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.ico$/', $URI)) {
    header_remove();
    header('Content-Type: image/x-icon');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.css$/', $URI)) {
    header_remove();
    header('Content-Type: text/css; charset=UTF-8');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.js$/', $URI)) {
    header_remove();
    header('Content-Type: application/javascript; charset=UTF-8');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.eot$/', $URI)) {
    header_remove();
    header('Content-Type: application/vnd.ms-fontobject; charset=UTF-8');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.svg$/', $URI)) {
    header_remove();
    header('Content-Type: image/svg+xml; charset=UTF-8');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.ttf$/', $URI)) {
    header_remove();
    header('Content-Type: font/tt; charset=UTF-8');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.woff$/', $URI)) {
    header_remove();
    header('Content-Type: font/woff; charset=UTF-8');
    require(__DIR__ . $URI);
} elseif (preg_match('/\.woff2$/', $URI)) {
    header_remove();
    header('Content-Type: font/woff2; charset=UTF-8');
    require(__DIR__ . $URI);
} else {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    require(__DIR__ . '/index.php');
}
