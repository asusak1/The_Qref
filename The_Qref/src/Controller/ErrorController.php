<?php


namespace Controller;


use Routing\Route;
use View\ErrorTemplate;
use View\NavPanel;

class ErrorController implements Controller {

    public function display(){

        if (isLoggedIn()){
            $nav_tmpl = (new NavPanel())->getFullNavPanel();
            $nav_tmpl->addTemplate("content", new ErrorTemplate());
            $nav_tmpl->render();
        }
        else{
            redirect(Route::get("index")->generate());
        }

    }

}