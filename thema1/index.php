<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

$urlParams = explode('/', $_SERVER['REQUEST_URI']);

array_shift($urlParams); // remove first element, which is empty

$controllerNamespace = 'Controller\\API\\';

// might need some further validation here
$controllerName = $controllerNamespace . ucfirst(array_shift($urlParams)).'Controller';

$indexOfQuestionMark = strpos($urlParams[0], '?');

if ( $indexOfQuestionMark !== false) {
    $urlParams[0] = substr($urlParams[0], 0, $indexOfQuestionMark); // returns everything before the question mark
}

$actionName = strtolower(array_shift($urlParams));

$controller = new $controllerName;

$controller->$actionName();