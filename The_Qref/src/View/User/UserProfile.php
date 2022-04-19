<?php

namespace View\User;

use Model\User;
use Routing\Route;
use View\Template;
use View\User\Components\AvgScoreTable;

class UserProfile extends Template {
    public function __construct(User $user) {
        parent::__construct("user/profile");

        $this->assign("date_of_birth", $user->date_of_birth);
        $this->assign("email", $user->email);
        $this->assign("password", $user->password);
        $this->assign("edit_profile_url", Route::get("profile_edit_show")->generate());
        
        $this->addTemplate("score_table", new AvgScoreTable($user->id));

    }
}