<?php

namespace View\Comment;

use Routing\Route;
use View\Template;

class CommentInput extends Template {

    public function __construct(string $quiz_id, string $result_id) {

        parent::__construct("comment/input");

        $this->assign("comment_val_url", Route::get("comment_save")->generate());
        $this->assign("quiz_id", $quiz_id);
        $this->assign("result_id", $result_id);

    }

}