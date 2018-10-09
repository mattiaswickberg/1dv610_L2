<?php
namespace Controller;

class CheckCredentialsController 
{
  public function CheckRegister($username, $password, $passwordRepeat) 
  {  
    if (!$this->CheckUsernameLength($username) && !$this->CheckPasswordLength($password))
    {
      throw new \Exception("Username has too few characters, at least 3 characters. <br> Password has too few characters, at least 6 characters. ");
    }
    if (!$this->CheckUsernameLength($username)) 
    {
      throw new \Exception("Username has too few characters, at least 3 characters. ");
    }

    if (!$this->CheckPasswordLength($password))
    {
      throw new \Exception("Password has too few characters, at least 6 characters. ");
    }

    if (!\ctype_alnum($_POST["RegisterView::UserName"])) 
    {
      throw new \Exception("Username contains invalid characters.");
    }

    if (!$this->PasswordsMatch($password, $passwordRepeat)) {
      throw new \Exception("Passwords do not match.");
    }
  }

  public function CheckLogin($username, $password) 
  {
    if(strlen($username) == 0) 
    {
      throw new \Exception("Username is missing");
    } 
    else if (strlen($_POST["LoginView::Password"]) == 0) 
    {
      throw new \Exception("Password is missing");
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
