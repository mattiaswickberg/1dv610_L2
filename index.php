<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/Login.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new \View\LoginView();
$dtv = new \View\DateTimeView();
$lv = new \View\LayoutView();

$login = new \Controller\Login();

$isLoggedIn = $login->CheckLogin();
$message = $login->getMessage();

$lv->render($isLoggedIn, $message, $v, $dtv);

