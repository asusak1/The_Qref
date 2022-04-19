<?php


namespace Model;


use App\Model\AbstractDBModel;

class Result extends AbstractDBModel {

    /**
     * @inheritDoc
     */
    public function getPrimaryKeyColumn() {
        return "id";
    }

    /**
     * @inheritDoc
     */
    public function getTable() {
        return "result";
    }

    /**
     * @inheritDoc
     */
    public function getColumns() {
        return ["id", "quiz_id", "user_id", "score", "max_score", "points", "start_time", "end_time", "is_late", "given_answers", "correct_answers"];
    }

    public function setPoints(array $points) {
        $this->points = implode(",", $points);
    }

    public function getPoints(): array {
        return explode(",", $this->points);
    }

    /**
     * Stores given answers in a format
     * answer1-answer2-answer3.1-answer3.2...
     * answerN
     * @param array $answers
     */
    public function setGivenAnswers(array $answers) {
        $answers_to_save = [];
        foreach ($answers as $answer) {
            if (is_array($answer)) {
                $answers_to_save[] = implode(",", $answer);
            } else {
                $answers_to_save[] = $answer;
            }
        }
        $this->given_answers = implode("-", $answers_to_save);
    }

    /**
     * Retrieves given answers as an array
     * @return array
     */
    public function getGivenAnswers(): array {
        $answers = [];
        foreach (explode("-", $this->given_answers) as $answer) {
            if (is_array($answer)) {
                $answers[] = explode(",", $answer);
            } else {
                $answers[] = $answer;
            }
        }
        return $answers;
    }

    /**
     * Stores correct answers  in a format
     * answer1-answer2-answer3.1-answer3.2...
     * answerN
     * @param array $answers
     */
    public function setCorrectAnswers(array $answers) {
        $this->correct_answers = implode("-", $answers);
    }

    /**
     * Retrieves correct answers as an array
     * @return array
     */
    public function getCorrectAnswers(): array {
        return explode("-", $this->correct_answers);
    }
}