<?php

namespace Model;

class Register {
  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = true;

  public function RegisterNewUser($username, $password, Database $db) 
  {  
   
      $user = $db->getUser($_POST["RegisterView::UserName"]);
      if ($user) {
        throw new \Exception("User exists, pick another username.");
      } else {
        $addUser = $db->AddUser($username, $password);      
    }    
  } 

  private function UserExists($username) :bool {
    $user = $db->getUser($username);
    if($user) {
      return true;
    } else {
      return false;
    }
  }  
}