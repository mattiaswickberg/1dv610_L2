<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('controller/Login.php');
require_once('controller/Db.php');
require_once('controller/MainController.php');
require_once('controller/Register.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new \View\LoginView();
$dtv = new \View\DateTimeView();
$lv = new \View\LayoutView();
$rv = new \View\RegisterView();

$db = new \Controller\Database();
$login = new \Controller\Login();
$register = new Controller\Register();

$Main = new \Controller\Main();

$Main->Start($lv, $v, $dtv, $rv, $login,$register, $db);



