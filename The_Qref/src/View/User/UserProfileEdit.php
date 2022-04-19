<?php

namespace View\User;

use Routing\Route;
use View\Template;

class UserProfileEdit extends Template {

    public function __construct() {

        parent::__construct("user/edit_form");

        $this->assign("edit_profile_url", Route::get("profile_edit_save")->generate());
    }

}