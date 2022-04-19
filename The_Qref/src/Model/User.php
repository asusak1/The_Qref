<?php


namespace Model;

use App\Model\AbstractDBModel;

class User extends AbstractDBModel {

    public function getColumns(): array {
        return ["id", "first_name", "last_name", "date_of_birth", "email", "password"];
    }

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
        return "user";
    }
}