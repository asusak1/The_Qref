<?php

namespace View\Quiz;

use Model\Quiz;
use Routing\Route;
use View\Comment\CommentInput;
use View\Comment\CommentsBlock;
use View\Template;

class QuizShow extends Template {
    
    public function __construct(Quiz $quiz) {
        parent::__construct("quiz/show");

        $this->assign("quiz_name", __($quiz->name));
        $this->assign("quiz_description", __($quiz->description));
        $this->assign("quiz_play_url", Route::get("quiz_play")->generate(["id" => $quiz->id]));

        if ($quiz->comments_allowed) {
            
            $comments_block = new CommentsBlock($quiz->id);
            $this->addTemplate("comments_block", $comments_block);
        }

    }

}