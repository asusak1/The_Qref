<?php


namespace Model;


class Statistics {

    private string $quiz_id;
    private string $quiz_name;
    private float $min;
    private float $max;
    private float $avg;
    private float $std;
    private float $median;

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
     * @return float
     */
    public function getMin(): float {
        return $this->min;
    }

    /**
     * @param float $min
     */
    public function setMin(float $min): void {
        $this->min = $min;
    }

    /**
     * @return float
     */
    public function getMax(): float {
        return $this->max;
    }

    /**
     * @param float $max
     */
    public function setMax(float $max): void {
        $this->max = $max;
    }

    /**
     * @return float
     */
    public function getAvg(): float {
        return $this->avg;
    }

    /**
     * @param float $avg
     */
    public function setAvg(float $avg): void {
        $this->avg = $avg;
    }

    /**
     * @return float
     */
    public function getStd(): float {
        return $this->std;
    }

    /**
     * @param float $std
     */
    public function setStd(float $std): void {
        $this->std = $std;
    }

    /**
     * @return float
     */
    public function getMedian(): float {
        return $this->median;
    }

    /**
     * @param float $median
     */
    public function setMedian(float $median): void {
        $this->median = $median;
    }



}