<?php


namespace View;


use Routing\Route;

class Index extends Template {

    public function __construct() {

        parent::__construct("index");

        $this->assign("register_show_url", Route::get("register_show")->generate());

    }
}