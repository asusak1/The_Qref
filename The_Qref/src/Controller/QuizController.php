<?php


namespace Controller;


use App\Dao\DAOProvider;
use App\Model\NotFoundException;
use App\Service\ParsingException;
use DateTime;
use Dispatch\DefaultDispatcher;
use Form\Quiz\QuizEditForm;
use Form\Quiz\QuizCreateForm;
use Model\Quiz;
use Model\QuizQuestionRelation;
use Routing\Route;
use Service\ServiceContainer;
use View\NavPanel;
use View\Quiz\ChallengeShow;
use View\Quiz\Overview;
use View\Quiz\QuizEdit;
use View\Quiz\QuizAdd;
use View\Quiz\QuizPlay;
use View\Quiz\QuizShow;

class QuizController implements Controller {


    public function display() {
        $quiz_id = DefaultDispatcher::instance()->getMatched()->getParam("id");

        $quiz = new Quiz();
        try {
            $quiz->load($quiz_id);
        } catch (NotFoundException $e) {
            redirect(Route::get("error")->generate());
        }

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", new QuizShow($quiz));

        $nav_tmpl->render();
    }

    public function create() {
        if (!isPost()) {
            redirect(Route::get("error")->generate());
        }

        $qf = new QuizCreateForm();
        $qf->load();

        if (!$qf->validate()) {
            redirectWithErrors(Route::get("quiz_add")->generate(), $qf->getErrors());
        }

        try {
            $questions = ServiceContainer::getInstance()->get("Parser")->
            parseQuestions($qf->getQuestionsRaw());
        } catch (ParsingException $e) {
            redirectWithErrors(Route::get("quiz_add")->generate(), ["Error while parsing given questions"]);
        }

        $quiz = $qf->createQuizObj();

        $quiz->save();

        foreach ($questions as $question) {
            $question->quiz_id = $quiz->id;
            $question->id = uniqid();
            $question->save();

            $quiz_question = new QuizQuestionRelation();
            $quiz_question->quiz_id = $quiz->id;
            $quiz_question->question_id = $question->id;
            $quiz_question->save();
        }

        redirectWithInfo(Route::get("profile")->generate(), "New quiz successfully added");
    }

    public function showAddForm() {

        $new_quiz_tmpl = new QuizAdd();

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", $new_quiz_tmpl);
        $nav_tmpl->render();
    }

    public function play() {

        $quiz_id = DefaultDispatcher::instance()->getMatched()->getParam("id");
        $quiz = new Quiz();
        try {
            $quiz->load($quiz_id);
        } catch (NotFoundException $e) {
            redirect(Route::get("error")->generate());
        }

        if (!$quiz->public and !isLoggedIn()) {
            redirect(Route::get("error")->generate());
        }

        $show_quiz_tmpl = new QuizPlay($quiz);

        $current_time = new DateTime();

        $nav_tmpl = (new NavPanel())->getQuizPanel($current_time->format("H:i:s"), deadlineTime($current_time, $quiz->time_limit));
        $nav_tmpl->addTemplate("content", $show_quiz_tmpl);
        $nav_tmpl->render();
    }

    public function playChallenge() {
        $type = DefaultDispatcher::instance()->getMatched()->getParam("type");
        $quiz = (ServiceContainer::getInstance()->get("DynamicQuizService")->create($type));

        redirect(Route::get("quiz_play")->generate(["id" => $quiz->id]));
    }

    public function evaluate() {

        if (!isPost()) {
            redirect(Route::get("error")->generate());
        }

        $quiz_id = post("quiz_id");
        $start_time = post("start_time");
        $end_time = (new DateTime())->format("Y-m-d H:i:s");
        $given_answers = allPostExcept(["start_time", "end_time"]);

        $quiz = new Quiz();
        $quiz->load($quiz_id);

        $questions = DAOProvider::get()->getQuestionsByQuizId($quiz->id);

        $is_late = ServiceContainer::getInstance()->get("EvaluationService")->checkLate($start_time, $end_time, $quiz->time_limit);
        $result = ServiceContainer::getInstance()->get("EvaluationService")->evaluateQuiz($given_answers, $questions, $is_late);

        $result->quiz_id = $quiz->id;
        $result->id = uniqid();
        $result->start_time = $start_time;
        $result->end_time = $end_time;
        $result->is_late = intval($is_late);

        //if anonymous user solved the quiz, $result->user_id should stay null
        if (isLoggedIn()) {
            $result->user_id = $_SESSION["user"];
        }
        $result->save();

        redirect(Route::get("result_show")->generate(["id" => $result->id]));
    }

    public function displayOverview() {

        $overview_tmpl = new Overview();

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", $overview_tmpl);
        $nav_tmpl->render();
    }

    public function showEditForm() {

        $quiz_id = DefaultDispatcher::instance()->getMatched()->getParam("id");
        $quiz = new Quiz();
        try {
            $quiz->load($quiz_id);
        } catch (NotFoundException $e) {
            redirect(Route::get("error")->generate());
        }
        $quiz_edit_tmpl = new QuizEdit($quiz);

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", $quiz_edit_tmpl);
        $nav_tmpl->render();
    }

    public function update() {

        if (!isPost()) {
            redirect(Route::get("error")->generate());
        }

        $quiz_id = DefaultDispatcher::instance()->getMatched()->getParam("id");

        $qef = new QuizEditForm();
        $qef->load();

        if (!$qef->validate()) {
            redirectWithErrors(Route::get("quiz_edit")->generate(["id" => post("quiz_id")]), $qef->getErrors());
        }

        $quiz = new Quiz();
        try {
            $quiz->load($quiz_id);
        } catch (NotFoundException $e) {
            redirect(Route::get("error")->generate());
        }

        //check if user is updating his own quiz
        if ($quiz->author_id !== userID()) {
            redirect(Route::get("error")->generate());
        }

        $qo = $qef->createQuizObj();

        $quiz->name = $qo->name;
        $quiz->description = $qo->description;
        $quiz->time_limit = $qo->time_limit;
        $quiz->public = $qo->public;
        $quiz->comments_allowed = $qo->comments_allowed;

        $quiz->save();

        $questions = DAOProvider::get()->getQuestionsByQuizId($quiz->id);
        foreach ($questions as $question) {
            if ($new_correct = post($question->id)) {
                if (is_array($new_correct)) {
                    $question->correct = implode(",", $new_correct);
                } else {
                    $question->correct = $new_correct;
                }
                $question->save();
            }
        }
        redirectWithInfo(Route::get("quiz_show")->generate(["id" => $quiz->id]), "Quiz successfully updated");
    }

    public function delete() {

        $quiz_id = DefaultDispatcher::instance()->getMatched()->getParam("id");

        $quiz = new Quiz();
        try {
            $quiz->load($quiz_id);
        } catch (NotFoundException $e) {
            redirect(Route::get("error")->generate());
        }
        //check if user is deleting his own quiz
        if ($quiz->author_id !== userID()) {
            redirect(Route::get("error")->generate());
        }
        $quiz->delete();

        redirectWithInfo(Route::get("quiz_overview")->generate(), "Quiz successfully deleted");
    }

    public function showChallenge() {
        $challenge_tmpl = new ChallengeShow();

        $nav_tmpl = (new NavPanel())->getFullNavPanel();
        $nav_tmpl->addTemplate("content", $challenge_tmpl);

        $nav_tmpl->render();
    }
}