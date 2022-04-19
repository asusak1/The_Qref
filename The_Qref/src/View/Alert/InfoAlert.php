<?php

namespace View\Alert;

use View\Template;

class InfoAlert extends Template {

    public function __construct(string $info) {

        parent::__construct("info");

        $this->assign("info", $info);
    }

}