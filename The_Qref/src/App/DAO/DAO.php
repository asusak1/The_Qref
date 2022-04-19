<?php


namespace App\DAO;


interface DAO {

    public function getStatisticsForUser(int $user_id): array;
    
    public function  getStatisticsForAll(): array;
    
    public function getNRandomQuestions(int $n): array;
}