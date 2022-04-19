<?php

namespace Controller;

use Routing\Route;

use View\Home;
use View\NavPanel;

class HomeController implements Controller {

    public function display() {
        if (!isLoggedIn()) {
            redirect(Route::get("index")->generate());
        }

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", new Home());
        $nav_tmpl->render();
    }

}