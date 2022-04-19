<?php


namespace View;

use Routing\Route;
use View\Alert\ErrorAlert;
use View\Alert\InfoAlert;

class NavPanel extends Template {

    public function __construct() {

        parent::__construct("base");

        if (get("error")) {
            $this->addTemplate("alerts", new ErrorAlert(get("error")));
        }
        if (get("info")) {
            $this->addTemplate("alerts", new InfoAlert(get("info")));
        }
    }

    /**
     * Returns navpanel for index page
     * @return NavPanel
     */
    public function getIndexNavPanel(): NavPanel {
        $nav_tmpl = new Template("navpanel/navpanel_index");
        $nav_tmpl->assign("login_url", Route::get("login")->generate());
        $nav_tmpl->assign("register_show_url", Route::get("register_show")->generate());

        $this->addTemplate("header", $nav_tmpl);

        return $this;
    }

    /**
     * Returns full navpanel for various pages
     * @return NavPanel
     */
    public function getFullNavPanel(): NavPanel {
        $nav_tmpl = new Template("navpanel/navpanel_full");
        $nav_tmpl->assign("home_url", Route::get("home")->generate());
        $nav_tmpl->assign("logout_url", Route::get("logout")->generate());
        $nav_tmpl->assign("profile_url", Route::get("profile")->generate());
        $nav_tmpl->assign("new_quiz_url", Route::get("quiz_add")->generate());
        $nav_tmpl->assign("quiz_overview_url", Route::get("quiz_overview")->generate());
        $nav_tmpl->assign("challenge_url", Route::get("challenge_show")->generate());
        $nav_tmpl->assign("statistics_url", Route::get("statistics_show")->generate());
        $nav_tmpl->assign("full_name", __($_SESSION["first_name"] . " " . $_SESSION["last_name"]));

        $this->addTemplate("header", $nav_tmpl);

        return $this;
    }

    /**
     * Returns navpanel displayed when playing quiz
     * @param string $start_time
     * @param string $end_time
     * @return NavPanel
     */
    public function getQuizPanel(string $start_time, string $end_time): NavPanel {
        $nav_tmpl = new Template("navpanel/navpanel_quiz");
        $nav_tmpl->assign("home_url", Route::get("home")->generate());

        if (isLoggedIn()) {
            $nav_tmpl->assign("full_name", __($_SESSION["first_name"] . " " . $_SESSION["last_name"]));
        } else {
            $nav_tmpl->assign("full_name", "Anonymous");
        }
        $nav_tmpl->assign("start_time", $start_time);
        $nav_tmpl->assign("end_time", $end_time);


        $this->addTemplate("header", $nav_tmpl);

        return $this;
    }
}