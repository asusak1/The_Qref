<?php
/**
 * Prints string safe of HTML tags
 * @param string $v
 * @return string
 */
function __(string $v): string {
    return htmlentities ($v, ENT_QUOTES, "utf-8");
}

/**
 * From URL gets param $v.
 * If there is no parameter, return null.
 * @param string $v
 * @param type $d
 * @return type
 */
function get(string $v, $d = null ) {
    if (isset($_GET[$v])){
        $d = $_GET[$v];
    }
    return $d;
}

/**
 * Gets parameter $v from HTTP request body
 * If there is no parameter $v, return null.
 * @param string $v
 * @param type $d
 * @return type
 */
function post($v, $d = null ){
    if (isset($_POST[$v])){
        $d = $_POST[$v];
    }
    return $d;
}

/**
 * Gets all parameters from HTTP request body except
 * the ones given in a list
 * @param array $except
 * @return array
 */
function allPostExcept(array $except) {
    $params = [];
    foreach ($_POST as $k => $v){
        if (!in_array($k, $except)){
            $params[$k] = $v;
        }
    }
    return $params;
}

/**
 * Checks if request is POST
 * If it is, checks if there is a parameter
 * with $key. If not, returns null
 * @param type $key
 * @return bool
 */
function isPost($key = null) {
    if (null === $key) {
        return count($_POST) > 0;
    }
    return null !== post($key);
}

/**
 * Checks if given param is defined
 * and not null
 * @param $param
 * @return bool
 * Checks if
 */
function paramExists ($param) {
    if (null !== $param && ! empty ($param)) return true;
    return false ;
}

/**
 * Redirects to a given URL
 * @param string $url
 */
function redirect(string $url) {
    header("Location: " . $url);
    die(); //
}
/**
 * Redirects to a given URL and appends errors from a given array
 * @param string $url
 * @param array $errors
 */
function redirectWithErrors(string $url, array $errors) {
    header("Location: " . $url . "?error=" . implode(', ', $errors));
    die();
}
/**
 * Redirects to a given URL and information message
 * @param string $url
 * @param string $info
 */
function redirectWithInfo(string $url, string $info) {
    header("Location: " . $url . "?info=" . $info);
    die();
}

/**
 * Check if user is logged in
 * @return bool true if logged in, false otherwise
 */
function isLoggedIn() {
    if (isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

/**
 * Returns ID of logged in user
 * @return string if user logged in, null otherwise
 */
function userID () {
    if (isLoggedIn()) {
        return $_SESSION['user'];
    }
    return null;
}
/**
 * Generates HTML code for errors received in GET request
 */
function displayErrors(){
    echo createElement("p", true, ["contents" => get("error")]);
}

/**
 * Retrieves the value with key in a collection
 * If key doesn't exist in array, return null
 * @param $key
 * @param array $collection
 * @param null $default
 * @return mixed|null
 */
function findByKey($key, array $collection, $default = null){
    if (!isset($collection)){
        return $default;
    }
    if (!isset($collection[$key])){
        return $default;
    }
    return $collection[$key];

}

/**
 * Given some time and  time limit in minutes, compute the deadline time
 * @param DateTime $current
 * @param int $timeLimit represents time limit in minutes
 * @return string representation of deadline time
 */
function deadlineTime(DateTime $current, int $timeLimit){
    $deadlineTime = $current;
    $deadlineTime->modify("+{$timeLimit} minutes");
    return $deadlineTime->format('H:i:s');
}

/**
 * Searches for *text* pattern in input string
 * and replaces it with <b>test<b>
 * @param string $input
 * @return string
 */
function bold(string $input): string{
    $bold_replace = function ($matches) {
        return "<b>" . $matches[1] . "</b>";
    };
    return preg_replace_callback('/\*(.+)\*/', $bold_replace, $input);
}

/**
 * Searches for _text_ pattern in input string
 * and replaces it with <i>test</i>
 * @param string $input
 * @return string
 */
function italic(string $input): string{
    $italic_replace = function ($matches) {
        return "<i>" . $matches[1] . "</i>";
    };
    return preg_replace_callback('/_(.+)_/', $italic_replace, $input);
}

/**
 * Checks if string contains a specific substring
 * @param string $string
 * @param string $substring
 * @return bool
 */
function hasSubstr(string $string, string $substring): bool{
    return strpos($string, $substring) !== false;
}
