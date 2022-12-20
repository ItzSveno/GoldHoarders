<?php

require __DIR__ . '../config/config.php';

$requestUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$requestString = substr($requestUrl, strlen($baseUrl));

$urlParams = explode('/', $requestString);


// might need some further validation here
$controllerName = ucfirst(array_shift($urlParams)).'Controller';

$indexOfQuestionMark = strpos($urlParams[0], '?');
$getParams;

if ( $indexOfQuestionMark !== false) {
    $getParams = substr($urlParams[0], $indexOfQuestionMark + 1); // returns everything after the question mark
    $urlParams[0] = substr($urlParams[0], 0, $indexOfQuestionMark); // returns everything before the question mark
}

$actionName = strtolower(array_shift($urlParams)).'Action';

$controller = new $controllerName;

if(isset($getParams)) {
    foreach(explode('&', $getParams) as $keyValue) {
        $keyValues = explode('=', $keyValue); // 2 element array, first = key, second = value
        try {
            $controller->$actionName($keyValues[0], $keyValues[1]);
        } catch (Exception $e) {
            echo "invalid get parameters";
        }
    }
} else {
    $controller->$actionName();
}