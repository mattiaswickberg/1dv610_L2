<?php
namespace Model;

require_once($_SERVER["DOCUMENT_ROOT"] . '/model/Exceptions.php');

class CheckCredentials
{
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

    if (!\ctype_alnum($RegisterView->getRequestUserName())) 
    {
      throw new \Model\InvalidCharacters;
    }

    if (!$this->PasswordsMatch($password, $passwordRepeat)) {
      throw new \Model\PasswordsNotMatch;
    }
  }

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
    return (strlen($username) > 2);
  }

  private function CheckPasswordLength($password) : bool {
    return (strlen($password) > 5);
  }

  private function HasInvalidCharacters($username):  bool {
    return !\ctype_alnum($username);
  }

  private function PasswordsMatch($password, $passwordRepeat) {
    return ($password == $passwordRepeat);
  }  
}
