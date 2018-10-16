<?php
namespace Controller;

class Main {

  /*
   * Initiate variables
   *  
   */
  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = false;

  /* 
   * Main controller function for page, to check login status.
   * 
   */
  public function Start(\View\LayoutView $LayoutView, \View\LoginView $LoginView, \View\DateTimeView $DateTimeView, \View\RegisterView $RegisterView, \View\BooksView $BooksView, \View\AddBookView $AddBookView, \Model\Register $register , \Model\Database $db, \Controller\CheckCredentialsController $CheckCredentials, \Controller\BooksController $BooksController, \View\EditBookView $EditBookView) 
  {
    $this->message = '';
    if ($LoginView->getRequestLogout()) //if user clicks logout, call corresponding function
    {
      $this->Logout($LoginView);
    }
    if($LoginView->getSessionStatus()) // If user is logged in, set variable to true and call controller for page's main function
    {
      $this->isLoggedIn = true;
      $this->message = "";
      $BooksController->Books($db, $BooksView, $AddBookView, $EditBookView);  
    }
    else //if user is not logged in, call function to handle logins and registrations
    {
      $this->NotLoggedIn($LayoutView, $LoginView, $DateTimeView, $RegisterView, $BooksView, $AddBookView, $register, $db, $CheckCredentials, $BooksController, $EditBookView);
    }
    //Call main View to render page     
    $LayoutView->render($this->isLoggedIn, $this->showRegister, $this->message, $LoginView, $DateTimeView, $RegisterView, $BooksView, $AddBookView, $EditBookView);   
  }

  /*
  * Function to handle login attempts and user registrations 
  */
  private function NotLoggedIn($LayoutView, $LoginView, $DateTimeView, $RegisterView, $BooksView, $AddBookView, $register, $db, $CheckCredentials, $BooksController, $EditBookView) {
    {
      if ($RegisterView->getRegisterStatus()) // If user clicks on register new account, show form to register
      {
      $this->showRegister = true;
    }

    if ($LoginView->getRequestLogin()) // If user tries to login, call function to check credentials
    {
      try
      {
        $this->Login($CheckCredentials, $db, $LoginView);
        $BooksController->Books($db, $BooksView, $AddBookView, $EditBookView); // If login succeeds, call controller for page's main functionality
      }
      catch (\Exception $e)
      {
        $this->message = $e->getMessage();
        $LoginView->setUserName($LoginView->getRequestUserName()); // If something went wrong, make sure username field is stilled filled out
      }      
    } 
    else if ($RegisterView->getRequestRegister()) // If user sends in registration form, try to register new account
    {
      $this->Register($CheckCredentials, $register, $db, $RegisterView);
      $RegisterView->setUserName(\strip_tags($RegisterView->getRequestUserName()));
      $LoginView->setUserName($RegisterView->getRequestUserName()); // Fill in user's new username in login form
    }   
    }
  }

  private function Logout($LoginView) // If user clicks logout, and there is a session active, unset session and set logged in variable
  {
    if(!$LoginView->getSessionStatus()) {
      $this->message = "";
    } 
    else 
    { 
      $this->isLoggedIn = false;
      session_unset();
      $this->message = "Bye bye!";
    }    
  }

  /**
   * If user wants login, call function to check credentials, and 
   */
  private function Login($CheckCredentials, $db, $LoginView)
  {
    $username = $LoginView->getRequestUserName();
    $password = $LoginView->getRequestPassword();
    echo $username . $password;

    $CheckCredentials->CheckLogin($username, $password);
    $user = $db->getUser($username);
    if($user) 
    {
      if($password != $user[0]["password"]) 
      {
        throw new \Exception("Wrong name or password");  
      } else 
      {
        $this->isLoggedIn = true;
        $this->message = "Welcome";
        $_SESSION["username"] = $username;
      }
    }
  }

/**
 * If user clicks to register account, check credentials, and if they check out send info to register class
 */  
  private function Register($CheckCredentials, $register, $db, $RegisterView) 
  {
    try {
      $username = $RegisterView->getRequestUserName();
      $password = $RegisterView->getRequestPassword();
      $passwordRepeat = $RegisterView->getRequestPasswordRepeat();
      $CheckCredentials->Checkregister($username, $password, $passwordRepeat);
      $register->RegisterNewUser($username, $password,$db);
      $this->showRegister = false;
      $this->message = "Registered new user.";
    }
    catch (\Exception $e)
    {
      $this->message = $e->getMessage();
    }
  } 
}