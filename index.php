<?php

declare(strict_types=1);

namespace App;

//on in production
//error_reporting(0);
//ini_set('display_errors', '0');

require_once("src/Utils/debug.php");  //off in production
require_once("src/View.php");

const DEFAULT_ACTION = 'list';

// if (!empty($_GET['action'])){
//     $action = $_GET['action'];
// } else{
//     $action = DEFAULT_ACTION;  |
// } beter is bottom              \/
$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$viewParams = [];
if ($action === 'create'){
    $page = 'createNote';
    $viewParams['resultCreate'] = "success";
} else{
    $page = 'listNotes';
    $viewParams['resultList'] = "display notes";
}

$view->render($page, $viewParams);