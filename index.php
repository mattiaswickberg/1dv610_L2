<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('model/Login.php');
require_once('model/Db.php');
require_once('controller/MainController.php');
require_once('model/Register.php');
require_once('model/Logout.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new \View\LoginView();
$dtv = new \View\DateTimeView();
$lv = new \View\LayoutView();
$rv = new \View\RegisterView();

$config = include("config.php");
$db = new \Model\Database($config);
$login = new \Model\Login();
$register = new \Model\Register();
$logout = new \Model\Logout();

$Main = new \Controller\Main();

session_start();

$Main->Start($lv, $v, $dtv, $rv, $login,$register, $db, $logout);



