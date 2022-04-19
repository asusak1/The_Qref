<?php


namespace Controller;


use App\Model\NotFoundException;
use Dispatch\DefaultDispatcher;
use Model\Result;
use Routing\Route;
use View\NavPanel;
use View\Result\ResultShow;

class ResultController implements Controller {

    public function display(){

        $result_id = DefaultDispatcher::instance()->getMatched()->getParam("id");

        $result = new Result();
        try {
            $result->load($result_id);
        }
        catch (NotFoundException $e){
            redirect(Route::get("error")->generate());
        }

        //check if a registered user tries to see other people's result
        if (isLoggedIn() and $result->user_id != $_SESSION["user"]){
            redirect(Route::get("error")->generate());
        }
        //check if an anonymous user tries to see other people's result
        if (!isLoggedIn() and $result->user_id !== null) {
            redirect(Route::get("error")->generate());
        }

        $result_tmpl = new ResultShow($result);

        $nav_tmpl = (new NavPanel())->getQuizPanel((new \DateTime($result->start_time))
            ->format("H:i:s"), (new \DateTime($result->end_time))->format("H:i:s"));
        $nav_tmpl->addTemplate("content", $result_tmpl);
        $nav_tmpl->render();

        //delete result after anonymous users sees it
        if (!isLoggedIn()){
            $result->delete();
        }
    }
}