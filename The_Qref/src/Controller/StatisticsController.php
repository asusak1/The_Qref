<?php


namespace Controller;


use View\NavPanel;
use View\Statistics\StatisticsShow;

class StatisticsController implements Controller {

    public function display(){

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", new StatisticsShow());
        $nav_tmpl->render();
    }

}