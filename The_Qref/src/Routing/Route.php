<?php

namespace Routing;

abstract class Route {

    private static array $map = [];

    public abstract function match(string $input): bool;

    public abstract function generate(array $params = []): string;

    public static function register (string $name, Route $route){
        self::$map[$name] = $route;
    }

    public static function get ($name = null) {
        if (null === $name) return self::$map;
        if (isset(self::$map)){
            return self::$map[$name];
        }
        return null;
    }

    public abstract function getParam(string $name, $def = null);
}