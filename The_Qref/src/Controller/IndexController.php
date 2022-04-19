<?php

namespace Controller;

use Routing\Route;
use View\Index;
use View\NavPanel;

class IndexController implements Controller {

    public function display() {

        if (isLoggedIn()) {
            redirect(Route::get("home")->generate());
        }

        $nav_tmpl = (new NavPanel())->getIndexNavPanel();
        $nav_tmpl->addTemplate("content", new Index());
        $nav_tmpl->render();
    }
}