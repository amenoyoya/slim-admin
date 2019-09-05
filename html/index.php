<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

function debug(string $message, string $filename = './log.txt')
{
    file_put_contents($filename, $message."\n", FILE_APPEND);
}

function main(string $html)
{
    session_start();

    // slim framework app
    $app = AppFactory::create();

    // index routing
    $app->get('/', function (Request $request, Response $response, array $args) use ($html) {
        // generate csrf token
        $csrfToken = bin2hex(openssl_random_pseudo_bytes(16));
        // save csrf token to session
        $_SESSION['csrf_token'] = $csrfToken;

        $response->getBody()->write(sprintf($html, $csrfToken));
        return $response;
    });

    // function for api definition
    $api = function (string $route, $callback) use ($app) {
        $app->post($route, function (Request $request, Response $response, array $args) use ($app, $callback) {
            // only accept json data post
            $json = json_decode($request->getBody());
            // confirm csrf token & host name
            if (!isset($_SESSION['csrf_token']) ||
                !isset($json->csrf) ||
                $_SESSION['csrf_token'] !== $json->csrf ||
                $request->getHeaders()['Host'][0] !== HOST_NAME
            ) {
                return $response;
            }
            // callback: return array $json;
            $response->getBody()->write(json_encode($callback($request, $response, $args)));
            return $response->withHeader('Content-Type', 'application/json');
        });
    };

    // load all api
    (require __DIR__ . '/api/all.php')($app, $api);

    $app->run();
}

# render root page
main(require __DIR__ . '/api/index.php');
