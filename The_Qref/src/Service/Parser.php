<?php

namespace Service;

use App\Service\ParsingException;
use Model\Question;



class Parser {

    /**
     * Parses questions given in the following format:
     * question{1}:choice1,choice2,choice3,...choiceN=choice1
     *
     * question{2}:choice1,choice2,choice3,...choiceN=choice1,
     * choine2...choiceN
     *
     * question{3}:=choice
     *
     * Number inside brackets defines question type
     *
     * @param string $input string to be parsed
     * @return array of Question objects
     * @throws ParsingException if input string is not in valid format
     */
    public function parseQuestions(string $input): array {
        $rows = explode(PHP_EOL, $input);
        $questions = [];
        foreach ($rows as $row) {

            $first_char = substr($row, 0, 1);
            if ($first_char === "#") {
                continue;
            }
            if (preg_match("/(?<text>^.+){(?<type>[123])}:(?<choices>.*)=(?<correct>.+)$/", trim($row), $matches)) {
                $question = new Question();
                if ($matches["type"] === "1" || $matches["type"] === "2") {
                    $question->choices = $matches["choices"];
                }
                $question->text = $matches["text"];
                $question->type = intval($matches["type"]);
                $question->correct = $matches["correct"];
                $questions[] = $question;
            }
            else{
                throw new ParsingException();
            }
        }
        return $questions;
    }
}