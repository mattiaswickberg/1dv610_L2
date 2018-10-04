<?php
namespace Controller;

class Main {

  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = false;

  public function Start(\View\LayoutView $layoutView, \View\LoginView $LoginView, \View\DateTimeView $dateTimeView, \View\RegisterView $RegisterView, \Model\Login $login, \Model\Register $register , \Model\Database $db, \Model\Logout $logout) {
    if (isset($_POST["LoginView::Logout"])) {
      $logout->Logout($layoutView, $LoginView, $dateTimeView, $RegisterView, $db);
    } else if(isset($_SESSION["username"])) {
      $this->isLoggedIn = true;
      $this->message = "";
      $layoutView->render($this->isLoggedIn, $this->showRegister, $this->message, $LoginView, $dateTimeView, $RegisterView);
    } else {
      if (isset($_GET["register"])) {
      $this->showRegister = true;
    }

    if (!isset($_POST["LoginView::Login"]) && !isset($_POST["LoginView::Register"])) {
      $this->message = "";
    }

    if (isset($_POST["LoginView::Login"])) {
      $login->CheckLogin($layoutView, $LoginView, $dateTimeView, $RegisterView, $db);
    } else if (isset($_POST["RegisterView::Register"])) {
      $register->CheckRegister($layoutView, $LoginView, $dateTimeView, $RegisterView, $db);
    } else {
      $layoutView->render($this->isLoggedIn, $this->showRegister, $this->message, $LoginView, $dateTimeView, $RegisterView);
    }
    }    
  }
}