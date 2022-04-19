<?php

namespace View\Quiz;

use App\Dao\DAOProvider;
use Model\Question;
use Model\Quiz;
use Model\QuizQuestionRelation;
use Routing\Route;
use View\Quiz\Components\SingleQuestion;
use View\Template;

class QuizEdit extends Template {
    public function __construct(Quiz $quiz) {
        parent::__construct("quiz/edit_form");

        $questions = DAOProvider::get()->getQuestionsByQuizId($quiz->id);

        $questions_tmpls = [];
        foreach ($questions as $question){
            $single_question = new SingleQuestion($question, true);
            $questions_tmpls[] = $single_question;
        }

        $this->assign("quiz_id", $quiz->id);
        $this->assign("quiz_update_url", Route::get("quiz_update")->generate(["id" => $quiz->id]));
        $this->assign("quiz_name", __($quiz->name));
        $this->assign("quiz_description", __($quiz->description));
        $this->assign("time_limit", $quiz->time_limit);
        $this->assign("comments_allowed", $quiz->comments_allowed);
        $this->assign("public", $quiz->public);
        $this->addTemplate("questions", $questions_tmpls);
    }
}