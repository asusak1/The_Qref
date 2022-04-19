<?php


use Routing\DefaultRoute;
use Routing\Route;

Route::register("index", new DefaultRoute("index", [
    "controller" => "IndexController",
    "action" => "display",
    "require_auth" => false]));

Route::register("login", new DefaultRoute("login", [
    "controller" => "UserController",
    "action" => "login",
    "require_auth" => false]));

Route::register("logout", new DefaultRoute("logout", [
    "controller" => "UserController",
    "action" => "logout",
    "require_auth" => true]));

Route::register("register_validate", new DefaultRoute("register/validate", [
    "controller" => "UserController",
    "action" => "register",
    "require_auth" => false]));


Route::register("register_show", new DefaultRoute("register", [
    "controller" => "UserController",
    "action" => "showRegForm",
    "require_auth" => false]));

Route::register("home", new DefaultRoute("home", [
    "controller" => "HomeController",
    "action" => "display",
    "require_auth" => true]));

Route::register("profile", new DefaultRoute("profile", [
    "controller" => "UserProfileController",
    "action" => "display",
    "require_auth" => true]));

Route::register("profile_edit_show", new DefaultRoute("profile/edit", [
    "controller" => "UserProfileController",
    "action" => "showForm",
    "require_auth" => true]));

    Route::register("profile_edit_save", new DefaultRoute("profile/edit/save", [
    "controller" => "UserProfileController",
    "action" => "edit",
    "require_auth" => true]));

Route::register("quiz_add", new DefaultRoute("quiz/add", [
    "controller" => "QuizController",
    "action" => "showAddForm",
    "require_auth" => true]));

Route::register("quiz_save", new DefaultRoute("quiz/save", [
    "controller" => "QuizController",
    "action" => "create",
    "require_auth" => true]));

Route::register("quiz_eval", new DefaultRoute("quiz/eval", [
    "controller" => "QuizController",
    "action" => "evaluate",
    "require_auth" => false]));

Route::register("quiz_show", new DefaultRoute("quiz/show/<id>", [
    "controller" => "QuizController",
    "action" => "display",
    "require_auth" => true],
    ["id" => "[[:xdigit:]]+"]));

Route::register("quiz_play", new DefaultRoute("quiz/play/<id>", [
    "controller" => "QuizController",
    "action" => "play",
    "require_auth" => false],
    ["id" => "[[:xdigit:]]+"]));

Route::register("quiz_challenge", new DefaultRoute("quiz/challenge/<type>", [
    "controller" => "QuizController",
    "action" => "playChallenge",
    "require_auth" => false],
    ["type" => "[1|2|3]"]));

Route::register("quiz_edit", new DefaultRoute("quiz/edit/<id>", [
    "controller" => "QuizController",
    "action" => "showEditForm",
    "require_auth" => true],
    ["id" => "[[:xdigit:]]+"]));

Route::register("quiz_delete", new DefaultRoute("quiz/delete/<id>", [
    "controller" => "QuizController",
    "action" => "delete",
    "require_auth" => true],
    ["id" => "[[:xdigit:]]+"]));

Route::register("quiz_update", new DefaultRoute("quiz/update/<id>", [
    "controller" => "QuizController",
    "action" => "update",
    "require_auth" => true],
    ["id" => "[[:xdigit:]]+"]));

Route::register("result_show", new DefaultRoute("result/show/<id>", [
    "controller" => "ResultController",
    "action" => "display",
    "require_auth" => false],
    ["id" => "[[:xdigit:]]+"]));

Route::register("comment_save", new DefaultRoute("comment/save", [
    "controller" => "CommentController",
    "action" => "create",
    "require_auth" => true]));

Route::register("quiz_overview", new DefaultRoute("quiz/overview", [
    "controller" => "QuizController",
    "action" => "displayOverview",
    "require_auth" => true]));

Route::register("statistics_show", new DefaultRoute("statistics", [
    "controller" => "StatisticsController",
    "action" => "display",
    "require_auth" => true]));

Route::register("challenge_show", new DefaultRoute("challenge", [
    "controller" => "QuizController",
    "action" => "showChallenge",
    "require_auth" => true]));

Route::register("error", new DefaultRoute("error", [
    "controller" => "ErrorController",
    "action" => "display",
    "require_auth" => false]));