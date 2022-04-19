<?php

namespace View\Quiz;

use Routing\Route;
use View\Template;

class ChallengeShow extends Template {

    public function __construct() {
        parent::__construct("quiz/challenge_show");

        $this->assign("easy_url", Route::get("quiz_challenge")->generate(["type" => "1"]));
        $this->assign("medium_url", Route::get("quiz_challenge")->generate(["type" => "2"]));
        $this->assign("hard_url", Route::get("quiz_challenge")->generate(["type" => "3"]));
    }

}