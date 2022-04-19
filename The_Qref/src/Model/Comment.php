<?php


namespace Model;


use App\Model\AbstractDBModel;

class Comment extends AbstractDBModel {

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
        return "comment";
    }

    /**
     * @inheritDoc
     */
    public function getColumns() {
        return ["id", "text", "user_id", "quiz_id", "published_on"];
    }
}