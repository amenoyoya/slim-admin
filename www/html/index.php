<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Symfony\Component\Yaml\Yaml;
use Slim\Framework\Application;

// load composer libraries
require_once __DIR__ . '/vendor/autoload.php';

// configure from yaml
define('CONFIG', Yaml::parse(file_get_contents(__DIR__ . '/config.yml')));

// load slim framework wrapper library
require_once __DIR__ . '/app/app.php';

// use database
if (CONFIG['db']['use']) {
    define('DB', Yaml::parse(file_get_contents(CONFIG['db']['config_file'])));
    require_once __DIR__ . '/db/bootstrap.php';
}

// use session for authentication
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
    $response->getBody()->write(sprintf(CONFIG['web']['home_html'], $_SESSION['csrf_token']));
    return $response;
});

// load all api
require_once __DIR__ . '/app/api.php';

Application::execute();
