<?php


namespace Form\Quiz;

use Model\Quiz;

/**
 * Class QuizEditForm used to store and validate form data when
 * editing existing quiz
 * @package Form
 */
class QuizEditForm
{
    private array $errors = [];
    private string $name;
    private string $description;
    private string $time_limit;
    private string $public;
    private string $comments_allowed;
    private string $quiz_id;

    /**
     * Loads post parameters
     */
    public function load() {
        $this->errors = [];
        $this->name = trim(post("name"));
        $this->description = trim(post("description"));
        $this->time_limit = post("time_limit");
        $this->public = post("public") ? true : false;
        $this->comments_allowed = post("public") ? true : false;
        $this->quiz_id = post("quiz_id");
    }

    public function getErrors(): array{
        return $this->errors;
    }

    /**
     * Validates parameters given in the form
     * @return bool True if validation is ok,
     * false otherwise
     */
    public function validate(): bool {
        if (!paramExists($this->name)) { array_push($this->errors, "Name is missing"); }
        if (!paramExists($this->description)) { array_push($this->errors, "Description is missing"); }
        if (!paramExists($this->time_limit)) { array_push($this->errors, "Time limit is missing"); }
        if (!paramExists($this->quiz_id)) { array_push($this->errors, "Quiz id is missing"); }

        if (!ctype_digit($this->time_limit) && intval($this->time_limit) <= 0){
            array_push($this->errors, "Time limit is invalid");
        }

        if (count($this->errors) !== 0){
            return false;
        }

        return true;
    }

    /**
     * Creates Quiz object from given form data
     * @return Quiz
     */
    public function createQuizObj(): Quiz{
        $quiz = new Quiz();
        $quiz->id = uniqid();
        $quiz->name = $this->name;
        $quiz->description = $this->description;
        $quiz->time_limit = $this->time_limit;
        $quiz->public = intval($this->public);
        $quiz->comments_allowed = intval($this->comments_allowed);
        return $quiz;
    }
}
