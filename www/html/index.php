<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Framework\Application;

require __DIR__ . '/app/app.php';
require __DIR__ . '/app/config.php';

session_start();

// create slim framework app
Application::create();

// home routing
Application::get('/', function (Request $request, Response $response, array $args) {
    // generate csrf token
    $csrfToken = bin2hex(openssl_random_pseudo_bytes(16));
    // save csrf token to session
    $_SESSION['csrf_token'] = $csrfToken;

    $response->getBody()->write(sprintf(HOME_HTML, $csrfToken));
    return $response;
});

// load all api
require __DIR__ . '/app/api.php';

Application::execute();
