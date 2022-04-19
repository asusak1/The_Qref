<?php

namespace View\User\Components;

use App\Dao\DAOProvider;
use View\Template;

/**
 * Table with average scores and attempts by quiz
 * for given user
 * Class AvgScoreTable
 * @package View\User\Components
 */
class AvgScoreTable extends Template {

    public function __construct(int $user_id) {
        parent::__construct("user/quiz_avg_score_table");

        $quiz_avg_scores = DAOProvider::get()->getStatisticsForUser($user_id);

        $collection = [];
        foreach ($quiz_avg_scores as $quiz_avg_score){
            $row = new Template("user/quiz_avg_score_row");
            $row->assign("quiz_name", $quiz_avg_score->getQuizName());
            $row->assign("attempts", $quiz_avg_score->getAttempts());
            $row->assign("avg_score", $quiz_avg_score->getAvgScore());
            $collection[] = $row;
        }
        $this->addTemplate("rows", $collection);
    }

}