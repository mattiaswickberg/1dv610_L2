<?php

namespace Model;

class Register {
  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = true;

  public function RegisterNewUser($username, $password, Database $db, \View\RegisterView $RegisterView) 
  {  
   
      $user = $db->getUser($RegisterView->getRequestUserName());
      if ($user) {
        throw new \Model\UserExists();
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