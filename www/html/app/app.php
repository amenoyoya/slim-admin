<?php

namespace Slim\Framework;

require __DIR__ . '/../vendor/autoload.php';

/**
 * slim framework app
 */
class Application {
    private static $app;

    public static function create()
    {
        self::$app = new \Slim\App;
    }

    public static function get(string $route, callable $callback)
    {
        return self::$app->get($route, $callback);
    }

    public static function post(string $route, callable $callback)
    {
        return self::$app->post($route, $callback);
    }

    public static function put(string $route, callable $callback)
    {
        return self::$app->put($route, $callback);
    }

    public static function delete(string $route, callable $callback)
    {
        return self::$app->delete($route, $callback);
    }

    public static function execute()
    {
        return self::$app->run();
    }
}
