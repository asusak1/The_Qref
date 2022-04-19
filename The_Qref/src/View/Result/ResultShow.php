<?php

namespace View\Result;

use Model\Quiz;
use Model\Result;
use Service\ServiceContainer;
use View\Comment\CommentInput;
use View\Comment\CommentsBlock;
use View\Template;

class ResultShow extends Template {

    public function __construct(Result $result) {
        parent::__construct("result/show");

        $quiz_id = $result->quiz_id;
        $points = $result->getPoints();;

        $quiz = new Quiz();
        $quiz->load($quiz_id);

        $given_answers = $result->getGivenAnswers();
        $corect_answers = $result->getCorrectAnswers();

        $number = 0;
        $result_rows = [];
        foreach ($corect_answers as $correct_answer) {
            $row = new Template("result/row");
            $row->assign("number", $number);
            $row->assign("given_answer", __($given_answers[$number]));
            $row->assign("correct_answer", __($correct_answer));
            $row->assign("points", $points[$number]);
            $result_rows[] = $row;
            $number++;
        }
        $this->addTemplate("answers", $result_rows);

        $this->assign("public", $quiz->public);
        $this->assign("is_late", ServiceContainer::getInstance()->get("EvaluationService")->checkLate($result->start_time, $result->end_time, $quiz->time_limit));
        $this->assign("quiz_name", __($quiz->name));
        $this->assign("quiz_description", __($quiz->description));
        $this->assign("score", $result->score);
        $this->assign("total", $result->max_score);
        $this->assign("accuracy", round(($result->score / $result->max_score) * 100, 2));

        
        if ($quiz->comments_allowed and isLoggedIn()) {
            $comment_input = new CommentInput($quiz_id, $result->id);
            $this->addTemplate("comment_input", $comment_input);

            $comments_block = new CommentsBlock($quiz_id);
            $this->addTemplate("comments_block", $comments_block);
        }
    }
}