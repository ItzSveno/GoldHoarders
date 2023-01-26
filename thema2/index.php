<?php

require __DIR__ . '../config/config.php';
header('Content-Type: application/json');

$urlParams = explode('/', $_SERVER['REQUEST_URI']);

// might need some further validation here
$controllerName = ucfirst(array_shift($urlParams)).'Controller';

$indexOfQuestionMark = strpos($urlParams[0], '?');

if ( $indexOfQuestionMark !== false) {
    $urlParams[0] = substr($urlParams[0], 0, $indexOfQuestionMark); // returns everything before the question mark
}

$actionName = strtolower(array_shift($urlParams)).'Action';

$controller = new $controllerName;

$controller->$actionName();

