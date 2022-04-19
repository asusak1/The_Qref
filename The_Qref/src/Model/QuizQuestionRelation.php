<?php


namespace Model;


use App\Model\AbstractDBModel;

class QuizQuestionRelation extends AbstractDBModel {

    /**
     * @inheritDoc
     */
    public function getPrimaryKeyColumn() {
        return "id";
    }

    /**
     * @inheritDoc
     */
    public function getTable() {
        return "quiz_question";
    }

    /**
     * @inheritDoc
     */
    public function getColumns() {
        return ["id", "quiz_id", "question_id"];
    }
}