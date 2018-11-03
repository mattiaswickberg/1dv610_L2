<?php

namespace Model;

class Register {

  private $RegisterView;
  private $Database;

  public function __construct(\View\RegisterView $registerView, \Model\Database $database) {
    $this->RegisterView = $registerView;
    $this->Database = $database;
  }

  // Register a new user and call database model to save
  public function RegisterNewUser(string $username, string $password) 
  {     
      $user = $this->Database->getUser($this->RegisterView->getRequestUserName());
      if ($user) {
        throw new \Model\UserExists();
      } else {
        $addUser = $this->Database->AddUser($username, $password);      
    }    
  } 

  // Check if user already exists
  private function UserExists(string $username) :bool {
    $user = $this->Database->getUser($username);
    if($user) {
      return true;
    } else {
      return false;
    }
  }  
}