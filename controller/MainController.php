<?php
namespace Controller;

class Main {

  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = false;

  public function Start(\View\LayoutView $lv, \View\LoginView $v, \View\DateTimeView $dtv, \View\RegisterView $rv, \Model\Login $login, \Model\Register $register , \Model\Database $db, \Model\Logout $logout) {
    if (isset($_POST["LoginView::Logout"])) {
      $logout->Logout($lv, $v, $dtv, $rv, $db);
    } else if(isset($_SESSION["username"])) {
      $this->isLoggedIn = true;
      $this->message = "";
      $lv->render($this->isLoggedIn, $this->showRegister, $this->message, $v, $dtv, $rv);
    } else {
      if (isset($_GET["register"])) {
      $this->showRegister = true;
    }

    if (!isset($_POST["LoginView::Login"]) && !isset($_POST["LoginView::Register"])) {
      $this->message = "";
    }

    if (isset($_POST["LoginView::Login"])) {
      $login->CheckLogin($lv, $v, $dtv, $rv, $db);
    } else if (isset($_POST["RegisterView::Register"])) {
      $register->CheckRegister($lv, $v, $dtv, $rv, $db);
    } else {
      $lv->render($this->isLoggedIn, $this->showRegister, $this->message, $v, $dtv, $rv);
    }
    }    
  }
}