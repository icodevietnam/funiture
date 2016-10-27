<?php

$public_path = 'public/';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = urldecode($uri);

$requested = $public_path .$uri;

if (($uri !== '/') && file_exists($requested)) {
    return false;
}

require_once $public_path .'index.php';
