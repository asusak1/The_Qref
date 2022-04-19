<?php


namespace Model;


use App\Model\AbstractDBModel;

class Question extends AbstractDBModel {

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
        return "question";
    }

    /**
     * @inheritDoc
     */
    public function getColumns() {
        return ["id", "text" , "type", "choices", "correct"];
    }

//    public function getCorrect(){
//        return $this->correct
//    }
}