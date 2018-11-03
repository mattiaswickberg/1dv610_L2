<?php
namespace Controller;

require_once($_SERVER["DOCUMENT_ROOT"] . '/model/Exceptions.php');

class Main {
  /*
   * Initiate variables
   *  
   */

  private $isLoggedIn = false;
  private $showRegister = false;
  private $LayoutView;
  private $LoginView;
  private $RegisterView;
  private $Register;
  private $Database;
  private $CheckCredentials;
  private $BooksController;
  private $Session;


  public function __construct(\View\LayoutView $layoutView, \View\LoginView $loginView, \View\RegisterView $registerView, \Model\Register $register , \Model\Database $db, \Model\CheckCredentials $checkCredentials, \Controller\BooksController $booksController, \View\Session $session)
  {
    $this->LayoutView = $layoutView;
    $this->LoginView = $loginView;
    $this->RegisterView = $registerView;
    $this->Register = $register;
    $this->Database = $db;
    $this->CheckCredentials = $checkCredentials;
    $this->BooksController = $booksController;
    $this->Session = $session;
  }

  /* 
   * Main controller function for page, to check login status.
   * 
   */
  public function Start() 
  {
    $this->LayoutView->NoMessage();
    if ($this->LoginView->getRequestLogout()) //if user clicks logout, call corresponding function
    {
      $this->Logout();
    }
    if($this->Session->getSessionStatus()) // If user is logged in, set variable to true and call controller for page's main function
    {
      $this->isLoggedIn = true;
      $this->LayoutView->NoMessage();
      $this->BooksController->Books();  
    }
    else //if user is not logged in, call function to handle logins and registrations
    {
      $this->NotLoggedIn();
    }
    //Call main View to render page     
    $this->LayoutView->render($this->isLoggedIn, $this->showRegister);   
  }

  /*
  * Function to handle login attempts and user registrations 
  */
  private function NotLoggedIn() {
    {
      if ($this->RegisterView->getRegisterStatus()) // If user clicks on register new account, show form to register
      {
      $this->showRegister = true;
    }

    if ($this->LoginView->getRequestLogin()) // If user tries to login, call function to check credentials
    {
      try
      {
        $this->Login();
        $this->BooksController->Books(); // If login succeeds, call controller for page's main functionality
      }
      catch (\Model\WrongNameOrPassword $e) {
        $this->LayoutView->WrongNameOrPassword();
      }
      catch (\Model\UsernameMissing $e) {
        $this->LayoutView->UsernameMissing();
      }
      catch (\Model\PasswordMissing $e) {
        $this->LayoutView->PasswordMissing();
      }
      $this->LoginView->setUserName($this->LoginView->getRequestUserName()); // If something went wrong, make sure username field is stilled filled out      
    } 
    else if ($this->RegisterView->getRequestRegister()) // If user sends in registration form, try to register new account
    {
      $this->RegisterUser();
      $this->RegisterView->setUserName(\strip_tags($this->RegisterView->getRequestUserName()));
      $this->LoginView->setUserName($this->RegisterView->getRequestUserName()); // Fill in user's new username in login form
    }   
    }
  }

  private function Logout() // If user clicks logout, and there is a session active, unset session and set logged in variable
  {
    if(!$this->Session->getSessionStatus()) {
      $this->message = "";
    } 
    else 
    { 
      $this->isLoggedIn = false;
      session_unset();
      $this->LayoutView->LogoutMessage();
    }    
  }

  /**
   * If user wants login, call function to check credentials, and 
   */
  private function Login()
  {
    $username = $this->LoginView->getRequestUserName();
    $password = $this->LoginView->getRequestPassword();

    $this->CheckCredentials->CheckLogin($username, $password);
    $user = $this->Database->getUser($username);
    if($user) 
    {
      if($password != $user[0]["password"]) 
      {
        throw new \Model\WrongNameOrPassword();  
      } else 
      {
        $this->isLoggedIn = true;
        $this->LayoutView->SuccessfulLogin();
        $this->Session->setUser($username);
      }
    }
    else 
    {
      throw new \Model\WrongNameOrPassword();
    }
  }

/**
 * If user clicks to register account, check credentials, and if they check out send info to register class. 
 * If exception is cast, catch the exception and calöl corresponding function in view to set message for user.
 */  
  private function RegisterUser() 
  {
    try {
      $username = $this->RegisterView->getRequestUserName();
      $password = $this->RegisterView->getRequestPassword();
      $passwordRepeat = $this->RegisterView->getRequestPasswordRepeat();
      $this->CheckCredentials->Checkregister($username, $password, $passwordRepeat);
      $this->Register->RegisterNewUser($username, $password);
      $this->showRegister = false;
      $this->LayoutView->SuccessfulRegistration();
    }
    catch (\Model\ShortUsernameAndPassword $e) {
      $this->LayoutView->ShortUsernameAndPassword();
    }
    catch (\Model\ShortUsername $e) {
      $this->LayoutView->ShortUsername();
    } 
    catch (\Model\ShortPassword $e) {
      $this->LayoutView->ShortPassword();
    } 
    catch (\Model\UserExists $e) {
      $this->LayoutView->UserExists();
    } 
    catch (\Model\InvalidCharacters $e) {
      $this->LayoutView->InvalidCharacters();
    } 
    catch (\Model\PasswordsNotMatch $e) {
      $this->LayoutView->PasswordsNotMatch();
    }     
  } 
}