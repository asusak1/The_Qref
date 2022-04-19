<?php

namespace View\Alert;

use View\Template;

class ErrorAlert extends Template {

    public function __construct(string $errors) {

        parent::__construct("error");

        $this->assign("errors", $errors);
    }

}