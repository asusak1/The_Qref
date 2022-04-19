<?php

namespace View\Quiz;

use App\Dao\DAOProvider;
use DateTime;
use Model\Question;
use Model\Quiz;
use Model\QuizQuestionRelation;
use Routing\Route;
use View\Quiz\Components\SingleQuestion;
use View\Template;

class QuizPlay extends Template {

    public function __construct(Quiz $quiz) {
        parent::__construct("quiz/play");

        $questions = DAOProvider::get()->getQuestionsByQuizId($quiz->id);

        $questions_tmpls = [];
        foreach ($questions as $question){
            $single_question = new SingleQuestion($question);
            $questions_tmpls[] = $single_question;
        }

        $this->assign("quiz_id", $quiz->id);
        $this->assign("quiz_eval_url", Route::get("quiz_eval")->generate());
        $this->assign("start_time", (new DateTime())->format("Y-m-d H:i:s"));
        $this->assign("quiz_name", __($quiz->name));
        $this->assign("quiz_description", __($quiz->description));
        $this->addTemplate("questions", $questions_tmpls);
        $this->assign("public", $quiz->public);
    }



}