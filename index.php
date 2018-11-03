<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/BooksView.php');
require_once('view/AddBookView.php');
require_once('view/EditBookView.php');
require_once('controller/MainController.php');
require_once('controller/BooksController.php');
require_once('model/CheckCredentials.php');
require_once('model/Database.php');
require_once('model/Register.php');
require_once('model/Book.php');
require_once('model/Library.php');
require_once('view/Session.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$Session = new \View\Session();
$LoginView = new \View\LoginView();
$DateTimeView = new \View\DateTimeView();
$RegisterView = new \View\RegisterView();
$AddBookView = new \View\AddBookView();
$EditBookView = new \View\EditBookView();
$BooksView = new \View\BooksView($AddBookView, $EditBookView);
$LayoutView = new \View\LayoutView($LoginView, $DateTimeView, $RegisterView, $BooksView);

$config = include("config.php");
$Database = new \Model\Database($config, $Session);
$register = new \Model\Register($RegisterView, $Database);
$CheckCredentials = new \Model\CheckCredentials();
$Library = new \Model\Library($Database);

$BooksController = new \Controller\BooksController($Library, $Database, $BooksView, $AddBookView, $EditBookView);
$Main = new \Controller\Main($LayoutView, $LoginView, $RegisterView, $register, $Database, $CheckCredentials, $BooksController, $Session);

// Start session
session_start();

// Call main controller and inject needed classes
$Main->Start();



