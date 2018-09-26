<?php

namespace Controller;

class Register {
  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = true;

  public function CheckRegister(\View\LayoutView $lv, \View\LoginView $v, \View\DateTimeView $dtv, \View\RegisterView $rv, Database $db) 
  {  
    if (strlen($_POST["RegisterView::UserName"]) <3 || strlen($_POST["RegisterView::Password"]) <6) {
      if (strlen($_POST["RegisterView::UserName"]) <3) {
        $this->message .= "Username has too few characters, at least 3 characters. <br>";
      } 
      if (strlen($_POST["RegisterView::Password"]) <6) {
        $this->message .= "Password has too few characters, at least 6 characters. ";
      }
    } else if ($_POST["RegisterView::Password"] !== $_POST["RegisterView::PasswordRepeat"]) {
      $this->message = "Passwords do not match.";
    } else {
      $user = $db->getUser($_POST["RegisterView::UserName"]);
      if ($user) {
        $this->message = "User exists, pick another username.";
      } else {
        $addUser = $db->AddUser($_POST["RegisterView::UserName"], $_POST["RegisterView::Password"]);
        if($addUser) {
          $v->setUserName($_POST["RegisterView::UserName"]);
          $this->message = "Registered new user.";
          $this->showRegister = false;
        } else {
          $this->message = "Registration failed for unknown reasons, try again!";
        }
      }
      
    }
    $rv->setUserName($_POST["RegisterView::UserName"]);
    $lv->render($this->isLoggedIn, $this->showRegister, $this->message, $v, $dtv, $rv);
  }
}