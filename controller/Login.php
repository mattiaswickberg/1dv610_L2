<?php

namespace Controller;

class Login {

  private $message = '';

  public function getMessage() {
    return $this->message;
  }

  public function CheckLogin() {
    if(!isset($_POST["LoginView::Login"])) {
      $this->message = "";
      return false;
    } else {
      $this->CheckPostData();
    }
  }

  public function CheckPostData() {
    if(strlen($_POST["LoginView::UserName"]) == 0) {
      $this->message = "Username is missing";
    return false;
    } else if (strlen($_POST["LoginView::Password"]) == 0) {
      $this->message = "Password is missing";
    } else {
      return false;
    }
  }
}
