<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

return function ($app, $api) {
    // phpinfo
    $app->get('/phpinfo/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write(phpinfo());
        return $response;
    });

    // request info
    $app->get('/request/', function (Request $request, Response $response, array $args) {
        $html = '';
        foreach ($request->getHeaders() as $name => $values) {
            $html .= '<dt>' . $name . '</dt><dd>' . implode(', ', $values) . '</dd>';
        }
        $response->getBody()->write("<dl>{$html}</dl>");
        return $response;
    });

    // post test
    $app->post('/test/', function (Request $request, Response $response, array $args) {
        $posted = [
            'params' => $request->getParsedBody(),
            'json' => json_decode($request->getBody())
        ];
        $response->getBody()->write(json_encode($posted));
        return $response;
    });

    // api test
    $api('/api_test/', function (Request $request, Response $response, array $args) {
        return ['text' => 'API success'];
    });
};
