<?php

namespace View\Quiz;

use Routing\Route;
use View\Template;

class QuizAdd extends Template {

    public function __construct() {

        parent::__construct("quiz/create_form");
        $this->assign("quiz_save_url", Route::get("quiz_save")->generate());
    }

}