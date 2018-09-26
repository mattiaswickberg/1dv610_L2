<?php

namespace Controller;

class Login {

  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = false;

  public function CheckLogin(\View\LayoutView $lv, \View\LoginView $v, \View\DateTimeView $dtv, \View\RegisterView $rv, Database $db) {
      if(strlen($_POST["LoginView::UserName"]) == 0) {
      $this->message = "Username is missing";
    } else if (strlen($_POST["LoginView::Password"]) == 0) {
      $v->setUserName($_POST["LoginView::UserName"]);
      $this->message = "Password is missing";
    } else {
      $user = $db->getUser($_POST["LoginView::UserName"]);
      if($user) {
        if($_POST["LoginView::Password"] != $user[0]["password"]) {
          $this->message = "Wrong name or password";  
        } else {
          $this->isLoggedIn = true;
          $this->message = "Welcome";
        }
      } else {
        $this->message = "Wrong name or password";       
      }
    }
    $lv->render($this->isLoggedIn, $this->showRegister, $this->message, $v, $dtv, $rv);
  }
}
