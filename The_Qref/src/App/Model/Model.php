<?php

namespace App\Model;

interface Model extends \Serializable {

    public function equals(Model $model);

}