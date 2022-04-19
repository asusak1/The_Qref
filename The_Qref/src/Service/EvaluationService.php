<?php


namespace Service;


use DateTime;
use DB\Question\QuestionDAOProvider;
use Model\Result;

class EvaluationService {

    /**
     * Evaluates the given answers by comparing them to the correct ones.
     * Computes the score which is the number of correct answers,
     * and max_score which is maximum number of points
     * @param array $given_answers answers given by the user
     * @param array $questions array of Questions objects, which contain
     * correct answer to the question
     * @param bool $is_late true if quiz submission is late, false
     * otherwise
     * @return Result
     */
    public function evaluateQuiz(array $given_answers, array $questions, bool $is_late=false): Result{

        //used to store score for each question
        $points = [];
        $count_correct = 0;
        $given_answers_full = [];
        $correct_answers = [];
        foreach ($questions as $question){
            //this is in case there is no given answer for specific question
            $given_answers_full [] = findByKey($question->id, $given_answers, "");
            $correct_answers [] = $question->correct;
            if ($this->evaluateAnswer(findByKey($question->id, $given_answers), $question->correct)) {
                $points[$question->id] = 1;
                $count_correct++;
            }
            else{
                $points[$question->id] = 0;
            }
        }
        // if submission is late, penalize total score by 50%
        if ($is_late) {
            $count_correct = $count_correct / 2;
            $points = array_map( function($val) { return $val * 0.5; }, $points);
        }
        $result = new Result();
        $result->score = $count_correct;
        $result->max_score = count($questions);
        $result->setPoints($points);
        $result->setGivenAnswers($given_answers_full);
        $result->setCorrectAnswers($correct_answers);
        return $result;
    }


    /**
     * Checks if a given answer is a correct one by comparing it to correct one
     * Works for both strings and arrays and is case-insensitive
     * @param string|array $given_answer
     * @param string|array $correct_answer
     * @return bool true if correct, false if not
     */
    private function evaluateAnswer($given_answer, $correct_answer): bool{
        if ($given_answer === null){
            return false;
        }
        if (is_array($given_answer)){
            $correct_array = explode(",", $correct_answer);
            sort($given_answer);
            sort($correct_array);
            return $given_answer ===  $correct_array;
        }
        else{
            return !strcasecmp(trim($given_answer), trim($correct_answer));  //case-insensitive string comparison
        }
    }

    /**
     * Checks if submission is late
     * @param string $start_time
     * @param string $end_time
     * @param int $time_limit in minutes
     * @return bool true if is late, false otherwise
     * @throws \Exception
     */
    public function checkLate(string $start_time, string $end_time, int $time_limit): bool{
        $start_time = new DateTime($start_time);
        $end_time = new DateTime($end_time);
        if (($end_time->getTimestamp() - $start_time->getTimestamp()) / 60 <= floatval($time_limit)){
            return false;
        }
        return true;
    }
}