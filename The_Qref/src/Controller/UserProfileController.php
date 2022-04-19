<?php


namespace Controller;


use Model\User;
use Routing\Route;
use View\NavPanel;
use View\User\UserProfileEdit;
use View\User\UserProfile;

class UserProfileController implements Controller {

    public function display() {

        $email = $_SESSION["email"];
        $user = (new User())->loadAll("WHERE email = '$email'")[0];

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", new UserProfile($user));
        $nav_tmpl->render();
    }

    public function showForm() {

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", new UserProfileEdit());
        $nav_tmpl->render();
    }

    public function edit() {

        if (!isPost()) {
            redirect(Route::get("error")->generate());
        }

        $errors = [];
        $new_password = post("new_password");
        $new_password2 = post("new_password2");
        $old_password = post("old_password");

        if (!paramExists($new_password)) {
            array_push($errors, "New password is required");
        }
        if (!paramExists($old_password)) {
            array_push($errors, "Old password is required");
        }

        if (count($errors) != 0) {
            redirectWithErrors(Route::get("profile_edit_show")->generate(), $errors);
        }
        if ($new_password !== $new_password2) {
            array_push($errors, "Passwords do not match");
        }
        if (strlen($new_password) < 5) {
            array_push($errors, "New password needs to have at least 5 characters");
        }

        $email = $_SESSION["email"];
        $user = (new User())->loadAll("WHERE email = '$email'")[0];

        if (!password_verify($old_password, $user->password)) {
            array_push($errors, "Old password not correct");
            redirectWithErrors(Route::get("profile_edit_show")->generate(), $errors);
        }

        $user->password = password_hash($new_password, PASSWORD_DEFAULT);
        $user->save();

        redirectWithInfo(Route::get("profile")->generate(), "Password changed successfully");


    }
}