<?php

namespace View;

class ErrorTemplate extends Template {

    public function __construct() {

        parent::__construct("error/show");

        $message = "Page not found";

        $this->assign("message", $message);
    }

}