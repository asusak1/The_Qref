<?php

namespace View\Quiz;

use Model\Quiz;
use Model\Result;
use Routing\Route;
use View\Template;

class Overview extends Template {

    public function __construct() {
        parent::__construct("quiz/overview/overview");
        
        $quizzes_by_me = (new Quiz())->loadAll("WHERE author_id =" . userID());
        $quizzes_by_other = (new Quiz())->loadAll("WHERE author_id !=" . userID());

        if ($quizzes_by_me){
            $this->addTemplate("owned_by_me", $this->getOwnedByMe($quizzes_by_me));
        }
        if ($quizzes_by_other){
            $this->addTemplate("owned_by_other", $this->getOwnedByOther($quizzes_by_other));
        }
    }

    private function getOwnedByMe(array $quizzes): array{
        $rows = [];
        foreach ($quizzes as $quiz){
            $row = new Template("quiz/overview/row_by_me");
            $row->assign("quiz_name", __($quiz->name));
            $row->assign("edit_url", Route::get("quiz_edit")->generate(["id" => $quiz->id]));
            $row->assign("delete_url", Route::get("quiz_delete")->generate(["id" => $quiz->id]));
            $row->assign("quiz_show_url", Route::get("quiz_show")->generate(["id" => $quiz->id]));
            $rows[] = $row;
        }

        return $rows;
    }

    private function getOwnedByOther(array $quizzes): array{
        $rows = [];
        foreach ($quizzes as $quiz){
            $row = new Template("quiz/overview/row_by_other");
            $row->assign("quiz_name", __($quiz->name));
            $row->assign("quiz_show_url", Route::get("quiz_show")->generate(["id" => $quiz->id]));
            $results = (new Result())->loadAll("WHERE quiz_id=\"$quiz->id\" AND user_id=" . userID());
            $row->assign("solved", boolval($results));
            $rows[] = $row;
        }

        return $rows;
    }

}