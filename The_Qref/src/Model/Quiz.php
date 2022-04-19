<?php


namespace Model;


use App\Model\AbstractDBModel;

class Quiz extends AbstractDBModel {

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
        return "quiz";
    }

    /**
     * @inheritDoc
     */
    public function getColumns() {
        return ["id", "name", "description", "time_limit", "author_id", "comments_allowed", "public"];
    }

    public function setDefaults(){
        $this->public = intval(false);
        $this->comments_allowed = intval(false);
    }
}