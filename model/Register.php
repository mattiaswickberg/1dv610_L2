<?php

namespace Model;

class Register {

  // Register a new user and call database model to save
  public function RegisterNewUser($username, $password, Database $db, \View\RegisterView $RegisterView) 
  {     
      $user = $db->getUser($RegisterView->getRequestUserName());
      if ($user) {
        throw new \Model\UserExists();
      } else {
        $addUser = $db->AddUser($username, $password);      
    }    
  } 

  // Check if user already exists
  private function UserExists($username) :bool {
    $user = $db->getUser($username);
    if($user) {
      return true;
    } else {
      return false;
    }
  }  
}