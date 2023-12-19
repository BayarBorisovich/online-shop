<?php
require_once "../Autoloader.php";
Autoloader::registrate(dirname(__DIR__)); //значение текущей родительской директории

$app = new App();// очему не делаем require_once
$app->run();

