<?php

require_once dirname(__FILE__) . '/../../Util/functions.php';

session_start();

spl_autoload_register(function ($classname) {

    $fileName = "./src/" . str_replace("\\", "/", $classname) . ".php";
    if (!is_readable($fileName)) {
        return false;
    }

    require_once $fileName;

    return true;
}
);

require_once 'route.php';
