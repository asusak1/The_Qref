<?php

namespace View\Comment;

use Model\Comment;
use Model\User;
use View\Template;

class CommentsBlock extends Template {

    public function __construct(string $quiz_id) {

        parent::__construct("comment/block");

        $comments = (new Comment())->loadAll("WHERE quiz_id=\"$quiz_id\"");

        $comments_tmpl = [];
        if ($comments) {
            foreach ($comments as $comment) {
                $user = new User();
                $user->load($comment->user_id);
                $comment_tmpl = new Template("comment/show");
                $comment_tmpl->assign("full_name", $user->first_name . " " . $user->last_name);
                $comment_tmpl->assign("published_on", $comment->published_on);
                $comment_tmpl->assign("comment", __(bold(italic($comment->text))));
                $comments_tmpl[] = $comment_tmpl;
            }
        }

        $this->addTemplate("comments", $comments_tmpl);
    }
}