<?php

// Redirect all requests to the router
$_GET['url'] = $_SERVER['REQUEST_URI'];
// Remove leading slash
$_GET['url'] = ltrim(parse_url($_GET['url'], PHP_URL_PATH), '/');

// Include the router
require_once __DIR__ . '/app/router/router.php';