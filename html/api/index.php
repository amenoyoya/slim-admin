<?php

namespace Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$root = '/api';
$app = AppFactory::create();

$app->get("$root/", function (Request $request, Response $response, $args) {
    $response->getBody()->write(phpinfo());
    return $response;
});

$app->run();
