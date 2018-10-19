<?php
namespace Model;

/** 
 * Model class to check credentials for registration and login, before checking against database
 * If credentials don't check out, throw corresponding custom exception
 */
class CheckCredentials
{
  // Variables for username and password rules. 
  private $minUserLength = 3;
  private $minPasswordLength = 5;

  // Function for Registration check
  public function CheckRegister($username, $password, $passwordRepeat,$RegisterView) 
  {
    if (!$this->CheckUsernameLength($username) && !$this->CheckPasswordLength($password))
    {
      throw new \Model\ShortUsernameAndPassword;
    }
    if (!$this->CheckUsernameLength($username)) 
    {
      throw new \Model\ShortUsername;
    }

    if (!$this->CheckPasswordLength($password))
    {
      throw new \Model\ShortPassword;
    }
    // Check if username contains something other than alphanumeric characters
    if (!\ctype_alnum($RegisterView->getRequestUserName())) 
    {
      throw new \Model\InvalidCharacters;
    }

    if (!$this->PasswordsMatch($password, $passwordRepeat)) {
      throw new \Model\PasswordsNotMatch;
    }
  }

  // Function for Login check
  public function CheckLogin($username, $password, $LoginView) 
  {
    if(strlen($username) == 0) 
    {
      throw new \Model\UsernameMissing;
    } 
    else if (strlen($LoginView->getRequestPassword()) == 0) 
    {
      throw new \Model\PasswordMissing;
    }
  }

  private function CheckUsernameLength($username):bool {
    return (strlen($username) >= $this->minUserLength);
  }

  private function CheckPasswordLength($password) : bool {
    return (strlen($password) >= $this->minPasswordLength);
  }

  private function PasswordsMatch($password, $passwordRepeat) {
    return ($password == $passwordRepeat);
  }  
}
