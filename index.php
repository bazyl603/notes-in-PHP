<?php

declare(strict_types=1);

namespace App;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");

$config = require_once("config/config.php");

$request = [
  'get' => $_GET,
  'post' => $_POST
];

//$controller = new Controller($request);
//$controller->run();

Controller::initConfiguration($config);

(new Controller($request))->run();