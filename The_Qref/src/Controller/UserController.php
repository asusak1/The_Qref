<?php


namespace Controller;


use DateTime;
use Model\User;
use Routing\Route;
use View\User\RegistrationForm;

class UserController {

    public function login() {

        if (!isPost()) {
            redirect(Route::get("error")->generate());
        }
        $errors = [];

        $email = trim(post("email"));
        $password = trim(post("password"));
        if (!paramExists($email)) {
            array_push($errors, "Username is required");
        }
        if (!paramExists($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            //check if user with given email exists
            $users = (new User())->loadAll("WHERE email = '$email'");
            if (count($users) != 0) {
                $user = $users[0];
                //check if hashed passwords match
                if (password_verify($password, $user->password)) {
                    $_SESSION["user"] = $user->id;
                    $_SESSION["first_name"] = $user->first_name;
                    $_SESSION["last_name"] = $user->last_name;
                    $_SESSION["email"] = $user->email;
                    redirect(Route::get("home")->generate());

                } else {
                    array_push($errors, "Wrong username/password combination");
                }
            } else {
                array_push($errors, "User with given e-mail doesn't exist");
            }
        }
        redirectWithErrors(Route::get("index")->generate(), $errors);
    }

    public function logout() {

        session_destroy();

        unset($_SESSION["user"]);
        unset($_SESSION["first_name"]);
        unset($_SESSION["last_name"]);

        redirect(Route::get("index")->generate());
    }

    public function showRegForm() {

        if (isLoggedIn()) {
            redirect(Route::get("home")->generate());
        }

        $template = new RegistrationForm();
        $template->render();
    }

    public function register() {

        if (!isPost()) {
            redirect(Route::get("error")->generate());
        }

        $errors = [];
        $email = trim(post("email"));
        $first_name = trim(post("first_name"));
        $last_name = trim(post("last_name"));
        $date_of_birth = trim(post("date_of_birth"));
        $password = post("password");
        $password2 = post("password2");

        if (!paramExists($email)) { array_push($errors, "Email is required");}
        if (!paramExists($first_name)) {array_push($errors, "First name is required");}
        if (!paramExists($last_name)) {array_push($errors, "Last name is required");}
        if (!paramExists($date_of_birth)) {array_push($errors, "Date of birth is required");}


        if (count($errors) != 0) {
            redirectWithErrors(Route::get("register_show")->generate(), $errors);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "E-mail not valid");
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
            array_push($errors, "First name not valid");
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
            array_push($errors, "Last name not valid");
        }
        if ($password !== $password2) {
            array_push($errors, "Passwords do not match");
        }
        if (strlen($password) < 5) {
            array_push($errors, "Password needs to have at least 5 characters");
        }

        $date = DateTime::createFromFormat('Y-m-d', $date_of_birth);
        if (DateTime::getLastErrors()["warning count"] !== 0 && DateTime::getLastErrors()["error count"]) {
            array_push($errors, "Date not valid");
        }

        if (count($errors) != 0) {
            redirectWithErrors(Route::get("register_show")->generate(), $errors);
        }

        if ((new User())->loadAll("WHERE email = '$email'")) {
            array_push($errors, "E-mail already registered");
            redirectWithErrors(Route::get("register_show")->generate(), $errors);
        }

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->date_of_birth = $date_of_birth;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->save();

        redirectWithInfo(Route::get("index")->generate(), "Registration successful");

    }
}