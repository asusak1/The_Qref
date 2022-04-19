<?php

namespace View\User;

use Routing\Route;
use View\Alert\ErrorAlert;
use View\Template;

class RegistrationForm extends Template {

    public function __construct() {

        parent::__construct('base');

        $reg_templ = new Template("user/register");
        $reg_templ->assign("reg_valid_url", Route::get("register_validate")->generate());
        $reg_templ->assign("index_url", Route::get("index")->generate());

        if (get("error")){
            $this->addTemplate("alerts", new ErrorAlert(get("error")));
        }

        $this->addTemplate("header", (new Template("navpanel/navpanel_register"))
            ->assign("index_url", Route::get("index")->generate()));
        $this->addTemplate("content", $reg_templ);
    }

}