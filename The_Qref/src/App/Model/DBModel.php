<?php

namespace App\Model;

interface DBModel extends Model {

    public function save();

    /**
     * @param mixed $pk
     *
     * @return void
     */
    public function load($pk);

    /**
     * @return void
     */
    public function delete();

}