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

// function for api definition
/*$api = function (string $route, $callback) use ($app) {
    $app->post($route, function (Request $request, Response $response, array $args) use ($app, $callback) {
        // only accept json data post
        $json = json_decode($request->getBody(), true);
        // confirm csrf token & host name
        if (!isset($_SESSION['csrf_token']) ||
            !isset($json['csrf']) ||
            $_SESSION['csrf_token'] !== $json['csrf'] ||
            $request->getHeaders()['Host'][0] !== HOST_NAME
        ) {
            return $response;
        }
        // callback: return array $json;
        $response->getBody()->write(json_encode($callback($request, $response, $args, $json)));
        return $response->withHeader('Content-Type', 'application/json');
    });
};*/

// load all api
require __DIR__ . '/app/api.php';

Application::execute();
