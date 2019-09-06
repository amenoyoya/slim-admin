<?php

use Slim\Framework\Application;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// phpinfo
Application::get('/phpinfo/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write(phpinfo());
    return $response;
});

// request info
Application::get('/request/', function (Request $request, Response $response, array $args) {
    $html = '';
    foreach ($request->getHeaders() as $name => $values) {
        $html .= '<dt>' . $name . '</dt><dd>' . implode(', ', $values) . '</dd>';
    }
    $response->getBody()->write("<dl>{$html}</dl>");
    return $response;
});

// post test
Application::post('/test/', function (Request $request, Response $response, array $args) {
    $posted = [
        'params' => $request->getParsedBody(),
        'json' => json_decode($request->getBody())
    ];
    $response->getBody()->write(json_encode($posted));
    return $response;
});

// login api
Application::api('post', '/api/login/', function (Request $request, Response $response, array $args, array $json) {
    if (!isset($json['username']) || !isset($json['password'])) {
        return ['login' => false, 'message' => 'Invalid parameters'];
    }
    if ($json['username'] === 'admin' && $json['password'] === 'pa$$wd') {
        // tokenを発行してログインさせる
        $authToken = bin2hex(openssl_random_pseudo_bytes(16));
        $_SESSION['auth_token'] = $authToken;
        return ['login' => true, 'token' => $authToken, 'message' => 'Login as admin'];
    }
    return ['login' => false, 'message' => 'Invalid username or password'];
});
