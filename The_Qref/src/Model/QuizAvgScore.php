<?php


namespace Model;


class QuizAvgScore {

    private string $quiz_id;
    private string $quiz_name;
    private int $attempts;
    private float $avg_score;

    /**
     * @return string
     */
    public function getQuizId(): string {
        return $this->quiz_id;
    }

    /**
     * @param string $quiz_id
     */
    public function setQuizId(string $quiz_id): void {
        $this->quiz_id = $quiz_id;
    }

    /**
     * @return string
     */
    public function getQuizName(): string {
        return $this->quiz_name;
    }

    /**
     * @param string $quiz_name
     */
    public function setQuizName(string $quiz_name): void {
        $this->quiz_name = $quiz_name;
    }

    /**
     * @return int
     */
    public function getAttempts(): int {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     */
    public function setAttempts(int $attempts): void {
        $this->attempts = $attempts;
    }

    /**
     * @return float
     */
    public function getAvgScore(): float {
        return $this->avg_score;
    }

    /**
     * @param float $avg_score
     */
    public function setAvgScore(float $avg_score): void {
        $this->avg_score = $avg_score;
    }

    

}