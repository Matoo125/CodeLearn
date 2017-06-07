<?php

use m4\m4mvc\core\App;

require_once('../vendor/autoload.php');

require_once('controllers/api/Home.php');
require_once('controllers/api/User.php');
require_once('controllers/api/Code.php');
require_once('model/User.php');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
/*
header('Access-Control-Allow-Origin: http://localhost:8080'); 
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');
*/
session_start();
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$app = new App;
$app->settings = [
	'namespace'	=>	'codelearn'
];

$app->paths = [
	'controllers'	=>	ROOT . DS . 'controllers'
];


$app->db([
	'DB_HOST'		=>	'localhost',
	'DB_PASSWORD'	=>	'',
	'DB_NAME'		=>	'codelearn',
	'DB_USER'		=>	'root'
]);

$app->run();
