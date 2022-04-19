<?php
declare(strict_types=1);

require_once './src/App/Inc/global.php';

use Dispatch\DefaultDispatcher;
use Routing\Route;

try {
    DefaultDispatcher::instance()->dispatch();
} catch (\Routing\RoutingException $e) {
    redirect(Route::get("error")->generate());
}

