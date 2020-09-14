<?php

declare(strict_types=1);

namespace App;

use App\Request;
use App\Exception\AppException;
use Throwable;

require_once("src/Utils/debug.php");
require_once("src/NoteController.php");
require_once("src/Exeption/AppException.php");
require_once("src/Utils/Request.php");

$config = require_once("config/config.php");

$request = new Request($_GET, $_POST);

try{
    AbstractController::initConfiguration($config);
    (new NoteController($request))->run();
} catch (AppException $e){
    echo '<h1>We have a problem with App!</h1>';
} catch (Throwable $e){
    echo '<h1>We have a problem!</h1>';
} 