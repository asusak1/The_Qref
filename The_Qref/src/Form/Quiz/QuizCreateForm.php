<?php


namespace Form\Quiz;

use Model\Quiz;

/**
 * Class QuizCreate used to store and validate form data for new Quiz
 * @package Form
 */
class QuizCreateForm
{
    private array $errors = [];
    private string $name;
    private string $description;
    private string $time_limit;
    private string $public;
    private string $comments_allowed;
    private string $author_id;
    private array $quiz_file;
    private string $quiz_text;

    private string $questions_raw;

    /**
     * Loads post parameters and uploaded file
     */
    public function load() {
        $this->errors = [];
        $this->name = trim(post("name"));
        $this->description = trim(post("description"));
        $this->time_limit = post("time_limit");
        $this->public = post("public") ? true : false;
        $this->comments_allowed = post("public") ? true : false;
        $this->author_id = $_SESSION["user"];
        $this->quiz_text = trim(post("quiz_text"));
        $this->quiz_file = $_FILES["quiz_file"];
    }

    public function getErrors(): array{
        return $this->errors;
    }

    /**
     * Validates parameters given in the form.
     * If validation fails, errors get stored 
     * to $this->errors.
     * @return bool True if validation is ok,
     * false otherwise. 
     */
    public function validate(): bool {
        if (!paramExists($this->name)) { array_push($this->errors, "Name is missing"); }
        if (!paramExists($this->description)) { array_push($this->errors, "Description is missing"); }
        if (!paramExists($this->time_limit)) { array_push($this->errors, "Time limit is missing"); }

        if (!ctype_digit($this->time_limit) && intval($this->time_limit) <= 0){
            array_push($this->errors, "Time limit is invalid");
        }

        if (count($this->errors) !== 0){
            return false;
        }

        //If .qref file is not uploaded, try to load questions from the text input
        if (!is_uploaded_file($this->quiz_file["tmp_name"])){
            if(!paramExists($this->quiz_text)){
                array_push($this->errors, "No questions submitted");
                return false;
            }
            else{
                $this->questions_raw = $this->quiz_text;
            }
        }
        else{
            if ($this->fileUploadValidate()){
                $this->questions_raw = file_get_contents($this->quiz_file["tmp_name"]);
            }
        }
        if (count($this->errors) !== 0){
            return false;
        }

        return true;
    }

    /**
     * Validates .qref file given in the form
     * @return bool True if validation is ok,
     * false otherwise
     */
    private function fileUploadValidate(){

        $filename = $this->quiz_file['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext !== 'qref') {
            array_push($this->errors, "File is not in .qref format");
            return false;
        }

        if (!is_uploaded_file($this->quiz_file["tmp_name"])){
            array_push($this->errors, "No file submitted");
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
        $quiz->author_id = $this->author_id;
        return $quiz;
    }

    /**
     * Returns raw questions loaded from the either .qref
     * file or text input
     * @return string
     */
    public function getQuestionsRaw(): string {
        return $this->questions_raw;
    }

}
