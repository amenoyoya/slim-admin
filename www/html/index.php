<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Framework\Application;

require_once __DIR__ . '/app/app.php';
require_once __DIR__ . '/app/config.php';

// use database
if (USE_DATABASE) {
    require_once __DIR__ . '/db/bootstrap.php';
}

session_start();

// create slim framework app
Application::create();

// home routing
Application::get('/', function (Request $request, Response $response, array $args) {
    if (!isset($_SESSION['csrf_token'])) {
        // generate csrf token
        $csrfToken = bin2hex(openssl_random_pseudo_bytes(16));
        // save csrf token to session
        $_SESSION['csrf_token'] = $csrfToken;
    }
    $response->getBody()->write(sprintf(HOME_HTML, $_SESSION['csrf_token']));
    return $response;
});

// load all api
require_once __DIR__ . '/app/api.php';

Application::execute();
