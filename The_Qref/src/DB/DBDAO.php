<?php


namespace DB;


use App\DAO\DAO;
use Model\Question;
use Model\QuizAvgScore;
use Model\QuizQuestionRelation;
use Model\Statistics;
use PDO;

class DBDAO implements DAO {

    public function getStatisticsForUser(int $user_id): array {
        $sql = <<<SQL
            SELECT q.id AS quiz_id,
                   q.name AS quiz_name,
                   AVG(r.score) AS avg_score,
                   COUNT(q.id) as num_attempts
            FROM quiz as q
            INNER JOIN result as r
            ON q.id = r.quiz_id
            WHERE r.user_id = :user_id
            GROUP BY q.id
            SQL;
        $stmt = DBPool::getInstance()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_BOUND);
        $stmt->bindColumn('quiz_id', $quiz_id);
        $stmt->bindColumn('quiz_name', $quiz_name);
        $stmt->bindColumn('avg_score', $avg_score);
        $stmt->bindColumn('num_attempts', $num_attempts);
        $stmt->execute([":user_id" => $user_id]);

        $collection = [];
        foreach ($stmt as $row) {
            $quiz_avg_score = new QuizAvgScore();
            $quiz_avg_score->setQuizId($quiz_id);
            $quiz_avg_score->setQuizName($quiz_name);
            $quiz_avg_score->setAttempts($num_attempts);
            $quiz_avg_score->setAvgScore($avg_score);


            $collection[] = $quiz_avg_score;
        }
        return $collection;
    }

    public function getStatisticsForAll(): array {
        $sql = <<<SQL
            SELECT q.id AS quiz_id,
                   q.name AS quiz_name,
                   MIN(r.score) as min,
                   MAX(r.score) as max,
                   AVG(r.score) AS avg,
                   STDDEV(r.score) as std
            FROM quiz as q
            INNER JOIN result as r
            ON q.id = r.quiz_id
            WHERE author_id IS NOT NULL
            GROUP BY q.id
            SQL;
        $stmt = DBPool::getInstance()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_BOUND);
        $stmt->bindColumn('quiz_id', $quiz_id);
        $stmt->bindColumn('quiz_name', $quiz_name);
        $stmt->bindColumn('min', $min);
        $stmt->bindColumn('max', $max);
        $stmt->bindColumn('avg', $avg);
        $stmt->bindColumn('std', $std);
        $stmt->execute();

        $collection = [];
        foreach ($stmt as $row) {
            $quiz_avg_score = new Statistics();
            $quiz_avg_score->setQuizId($quiz_id);
            $quiz_avg_score->setQuizName($quiz_name);
            $quiz_avg_score->setMin($min);
            $quiz_avg_score->setMax($max);
            $quiz_avg_score->setAvg($avg);
            $quiz_avg_score->setStd($std);
            $quiz_avg_score->setMedian($std);
            $collection[] = $quiz_avg_score;
        }

        return $collection;
    }

    public function getNRandomQuestions(int $n): array {
        $sql = <<<SQL
            SELECT id FROM question
            ORDER BY RAND()
            LIMIT :n
            SQL;
        $stmt = DBPool::getInstance()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_BOUND);
        $stmt->bindParam(':n', $n, PDO::PARAM_INT);
        $stmt->bindColumn('id', $id);
        $stmt->execute();

        $collection = [];
        foreach ($stmt as $row) {
            $collection[] = $id;
        }
        return $collection;
    }
    
    public function getQuestionsByQuizId(string $quiz_id){
        $questions_id = (new QuizQuestionRelation())->loadAll("WHERE quiz_id=\"" . $quiz_id . "\"");
        $questions = [];
        foreach ($questions_id as $q){
            $question = new Question();
            $question->load($q->question_id);
            $questions[] = $question;
        }
        return $questions;
    }
}