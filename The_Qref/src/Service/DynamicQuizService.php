<?php


namespace Service;


use App\Dao\DAOProvider;
use Model\Quiz;
use Model\QuizQuestionRelation;


class DynamicQuizService {

    /**
     * Creates new quiz dynamically by retrieving
     * n random previously saved  questions based on given type
     * Type defines difficulty (number of questions)
     * and there are 3 of them:
     * easy = 10, normal = 15, hard = 20
     * @param int $type
     * @return Quiz
     */
    public function create(int $type): Quiz {

        $quiz = new Quiz();
        $quiz->id = uniqid();

        switch ($type) {
            case 1:
                $n = 10;
                $name = "Easy";
                break;
            case 2:
                $n = 15;
                $name = "Normal";
                break;
            case 3:
                $n = 20;
                $name = "Hard";
                break;
        }

        $quiz->name = $name . " Quiz";

        $quiz->description = "Dynamic quiz";
        $quiz->time_limit = 60;
        $quiz->author_id = null;
        $quiz->setDefaults();
        $quiz->save();

        $question_ids = DAOProvider::get()->getNRandomQuestions($n);

        foreach ($question_ids as $question_id) {

            $quiz_question = new QuizQuestionRelation();
            $quiz_question->quiz_id = $quiz->id;
            $quiz_question->question_id = $question_id;
            $quiz_question->save();
        }

        return $quiz;
    }
}