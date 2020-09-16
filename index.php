<?php

declare(strict_types=1);

spl_autoload_register(function (string $classNamespace){
    $path = str_replace(['\\', 'App/'], ['/',''], $classNamespace);
    $path = "src/".$path.'.php';
    require_once($path);
});
$config = require_once("config/config.php");

require_once("src/Utils/debug.php");
use App\Request;
use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

$request = new Request($_GET, $_POST, $_SERVER);

try{
    AbstractController::initConfiguration($config);
    (new NoteController($request))->run();
} catch (ConfigurationException $e){
    echo '<h1>We have a problem with App!</h1>';
} catch (\Throwable $e){
    echo '<h1>We have a problem!</h1>';
    dump($e);
} 