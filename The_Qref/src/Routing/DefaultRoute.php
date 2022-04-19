<?php

namespace Routing;

use Exception;

class DefaultRoute extends Route {

    private static string $VALID_PARAM_NAME = "[a-zA-Z_$][a-zA-Z_$0-9]*";

    private string $route;
    private array $regexMap;
    private array $params;
    private array $defaults;

    public function __construct (string $route, array $defaults = [], array $regex = []) {
        foreach ($regex as $paramName => $regexEl) {
            //Check if param name is in valid format
            if (!preg_match("/" . "^" . self::$VALID_PARAM_NAME . "$" . "/", $paramName)) {
                throw new Exception("Invalid parameter name: \"" . $paramName . "\"");
            }
            //Check if regex in valid PCRE format
            if (@preg_match("/" . $regexEl . "/", "...") === false) {
                throw new Exception("Invalid regex: \"" . $regexEl . "\"");
            }
        }
        $rootName = "/";
        $this->route = $rootName . $route;
        $this->defaults = $defaults;
        $this->regexMap = $regex;
        $this->params = [];
    }

    public function match (string $url): bool {
        $parsedRegex = preg_replace_callback(
            '/<(' . self::$VALID_PARAM_NAME . ')>/',
            function ($matches) {
                $paramName = $matches[1];
                return "(?<" . $paramName . ">" . $this->regexMap[$paramName] . ")";
            },
            $this->route );
        return preg_match( "#" . "^" . $parsedRegex . "$" . "#", $url, $this->params
        );
    }

    public function generate (array $params = []): string {
        // Pronađi sve nazive parametara unutar zagrada npr. <name>
        return preg_replace_callback(
            '/<(' . self::$VALID_PARAM_NAME . ')>/',
            function ($matches) use ($params) {
                $paramName = $matches[1];
                //Check if parameter exists
                if (!isset($params[$paramName])) {
                    throw new Exception("Missing param \"" . $paramName . "\"");
                }
                //Check if parameter value is matched by appropriate regex
                if (preg_match("/" . "^" . $this->regexMap[$paramName] . "$" . "/", $params[$paramName])){
                    return $params[$paramName];
                }
                throw new Exception("Value of  parameter \"" . $paramName . "\" not valid");

            },
            $this->route);
    }

    public function getParam(string $name, $def = null) {
        $param = findByKey($name, $this->defaults, $def);
        if ($param === $def){
            $param = findByKey($name, $this->params, $def);
        }
        return $param;
    }


}