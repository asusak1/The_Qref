<?php

namespace View\Quiz\Components;

use Model\Question;
use View\Template;

/**
 * Used to display single quiz question with
 * options to choose from if available
 * Class SingleQuestion
 * @package View\Quiz\Components
 */
class SingleQuestion extends Template {
    /**
     * SingleQuestion constructor.
     * If $show_answer is true,
     * correct answer will be checked or written
     * in the form
     * @param Question $question
     * @param bool $show_answer
     */
    public function __construct(Question $question, $show_answer=false) {

        switch ($question->type) {
            case 1:
                $this->getType1($question, $show_answer);
                break;
            case 2:
                $this->getType2($question, $show_answer);
                break;
            case 3:
                $this->getType3($question, $show_answer);
                break;
        }
    }

    private function getType1(Question $question, bool $show_answer) {

        parent::__construct("quiz/components/question_type_1_2");

        $this->assign("text", __($question->text));
        $choice_tmpls = [];
        foreach (explode(",", $question->choices) as $choice) {
            $choice_tmpl = new Template("quiz/components/option_radio");
            $choice_tmpl->assign("question_id", $question->id);
            $choice_tmpl->assign("choice", __($choice));

            if ($show_answer and $choice === $question->correct) {
                $choice_tmpl->assign("checked", "checked");
            } else {
                $choice_tmpl->assign("checked", "");
            }
            $choice_tmpls[] = $choice_tmpl;
        }
        $this->addTemplate("choices", $choice_tmpls);
    }

    private function getType2(Question $question, bool $show_answer) {

        parent::__construct("quiz/components/question_type_1_2");

        $this->assign("text", __($question->text));
        $choice_tmpls = [];
        foreach (explode(",", $question->choices) as $choice) {
            $choice_tmpl = new Template("quiz/components/option_checkbox");
            $choice_tmpl->assign("question_id", $question->id);
            $choice_tmpl->assign("choice", __($choice));

            if ($show_answer and hasSubstr($question->correct, $choice)) {
                $choice_tmpl->assign("checked", "checked");
            } else {
                $choice_tmpl->assign("checked", "");
            }
            $choice_tmpls[] = $choice_tmpl;
        }
        $this->addTemplate("choices", $choice_tmpls);
    }

    private function getType3(Question $question, bool $show_answer) {

        parent::__construct("quiz/components/question_type_3");

        $this->assign("text", __($question->text));
        $input_text = new Template("quiz/components/input_text");
        $input_text->assign("question_id", $question->id);

        if ($show_answer) {
            $input_text->assign("value", $question->correct);
        } else {
            $input_text->assign("value", "");
        }
        $this->addTemplate("input_text", $input_text);
    }


}