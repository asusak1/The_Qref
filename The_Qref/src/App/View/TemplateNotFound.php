<?php

namespace App\View;

use Exception;
use Throwable;

class TemplateNotFound extends Exception {

    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct("Template: " . $message . " " . "not found", $code, $previous);
    }

}