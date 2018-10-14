<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/BooksView.php');
require_once('view/AddBookView.php');
require_once('view/EditBookView.php');
require_once('controller/CheckCredentialsController.php');
require_once('controller/MainController.php');
require_once('controller/BooksController.php');
require_once('model/Db.php');
require_once('model/Register.php');


//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$LoginView = new \View\LoginView();
$DayTimeView = new \View\DateTimeView();
$RegisterView = new \View\RegisterView();
$BooksView = new \View\BooksView();
$AddBookView = new \View\AddBookView();
$EditBookView = new \View\EditBookView();
$LayoutView = new \View\LayoutView();

$config = include("config.php");
$db = new \Model\Database($config);
$register = new \Model\Register();

$BooksController = new \Controller\BooksController();
$Main = new \Controller\Main();
$CheckCredentials = new \Controller\CheckCredentialsController();

session_start();

$Main->Start($LayoutView, $LoginView, $DayTimeView, $RegisterView, $BooksView, $AddBookView, $register, $db, $CheckCredentials, $BooksController, $EditBookView);



