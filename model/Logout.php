<?php

namespace Model;

class Logout {

  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = false;

  public function Logout(\View\LayoutView $lv, \View\LoginView $v, \View\DateTimeView $dtv, \View\RegisterView $rv, Database $db) {
    if(!isset($_SESSION["username"])) {
      $this->message = "";
    } else { 
      $this->isLoggedIn = false;
      session_unset();
      $this->message = "Bye bye!";
    }
    $lv->render($this->isLoggedIn, $this->showRegister, $this->message, $v, $dtv, $rv);
  }
}