<?php


namespace Controller;


use App\Model\NotFoundException;
use DateTime;
use Model\Comment;
use Model\Quiz;
use Routing\Route;

class CommentController implements Controller {

    public function create(){
        if (isPost()){
            $comment_text = trim(post("comment_text"));
            $quiz_id = post("quiz_id");
            $result_id = post("result_id");
            $published_on = (new DateTime())->format("Y-m-d H:i:s");

            $quiz = new Quiz();

            try {
                $quiz->load($quiz_id);
            } catch (NotFoundException $e) {
                redirect(Route::get("error")->generate());
            }

            if(!$quiz->comments_allowed){
                redirect(Route::get("error")->generate());
            }

            $comment = new Comment();
            $comment->text = $comment_text;
            $comment->user_id = userID();
            $comment->quiz_id = $quiz_id;
            $comment->published_on = $published_on;
            $comment->save();

            redirect(Route::get("result_show")->generate(["id" => $result_id]));
        }
    }

}