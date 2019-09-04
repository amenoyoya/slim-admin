<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

function main(string $html, string $csrfToken) {
    session_start();

    // save csrf token to session
    $_SESSION['csrf_token'] = $csrfToken;

    // slim framework app
    $app = AppFactory::create();

    // index routing
    $app->get('/', function (Request $request, Response $response, array $args) use($html) {
        $response->getBody()->write($html);
        return $response;
    });

    // function for api definition
    $api = function (string $route, $callback) use($app) {
        $app->post($route, function (Request $request, Response $response, array $args) use($callback) {
            // only accept json data post
            $json = json_decode($request->getBody());
            // confirm csrf token & host name
            if (
                !isset($_SESSION['csrf_token']) ||
                !isset($json->csrf) ||
                $_SESSION['csrf_token'] !== $json->csrf ||
                $request->getHost() !== 'slim-admin.localhost'
            ) {
                return $response;
            }
            // callback: return array $json;
            return $response->wthJson($callback($request, $response, $args));
        });
    };

    // load all api
    (require __DIR__ . '/api/all.php')($app, $api);

    $app->run();
}

# render root page
$csrfToken = bin2hex(openssl_random_pseudo_bytes(16));
main(require __DIR__ . '/api/index.php', $csrfToken);
