<?php

namespace View\Statistics;

use App\Dao\DAOProvider;
use View\Template;

class StatisticsShow extends Template {

    public function __construct() {
        parent::__construct("statistics/show");

        $stat_collection = DAOProvider::get()->getStatisticsForAll();

        $rows = [];
        foreach ($stat_collection as $stat){
            $row = new Template("statistics/row");
            $row->assign("quiz_name", __($stat->getQuizName()));
            $row->assign("min", $stat->getMin());
            $row->assign("max", $stat->getMax());
            $row->assign("average", $stat->getAvg());
            $row->assign("std", $stat->getStd());
            $row->assign("median", $stat->getMedian());
            
            $rows[] = $row;
        }
        $this->addTemplate("rows", $rows);
    }

}