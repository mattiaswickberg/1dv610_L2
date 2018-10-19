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

  /* 
   * Main controller function for page, to check login status.
   * 
   */
  public function Start(\View\LayoutView $LayoutView, \View\LoginView $LoginView, \View\DateTimeView $DateTimeView, \View\RegisterView $RegisterView, \View\BooksView $BooksView, \View\AddBookView $AddBookView, \Model\Register $register , \Model\Database $db, \Model\CheckCredentials $CheckCredentials, \Controller\BooksController $BooksController, \View\EditBookView $EditBookView) 
  {
    $LayoutView->NoMessage();
    if ($LoginView->getRequestLogout()) //if user clicks logout, call corresponding function
    {
      $this->Logout($LoginView, $LayoutView);
    }
    if($LoginView->getSessionStatus()) // If user is logged in, set variable to true and call controller for page's main function
    {
      $this->isLoggedIn = true;
      $LayoutView->NoMessage();
      $BooksController->Books($db, $BooksView, $AddBookView, $EditBookView);  
    }
    else //if user is not logged in, call function to handle logins and registrations
    {
      $this->NotLoggedIn($LayoutView, $LoginView, $DateTimeView, $RegisterView, $BooksView, $AddBookView, $register, $db, $CheckCredentials, $BooksController, $EditBookView);
    }
    //Call main View to render page     
    $LayoutView->render($this->isLoggedIn, $this->showRegister, $LoginView, $DateTimeView, $RegisterView, $BooksView, $AddBookView, $EditBookView);   
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
        $this->Login($CheckCredentials, $db, $LoginView, $LayoutView);
        $BooksController->Books($db, $BooksView, $AddBookView, $EditBookView); // If login succeeds, call controller for page's main functionality
      }
      catch (\Model\WrongNameOrPassword $e) {
        $LayoutView->WrongNameOrPassword();
      }
      catch (\Model\UsernameMissing $e) {
        $LayoutView->UsernameMissing();
      }
      catch (\Model\PasswordMissing $e) {
        $LayoutView->PasswordMissing();
      }
      $LoginView->setUserName($LoginView->getRequestUserName()); // If something went wrong, make sure username field is stilled filled out      
    } 
    else if ($RegisterView->getRequestRegister()) // If user sends in registration form, try to register new account
    {
      $this->Register($CheckCredentials, $register, $db, $RegisterView, $LayoutView);
      $RegisterView->setUserName(\strip_tags($RegisterView->getRequestUserName()));
      $LoginView->setUserName($RegisterView->getRequestUserName()); // Fill in user's new username in login form
    }   
    }
  }

  private function Logout($LoginView, $LayoutView) // If user clicks logout, and there is a session active, unset session and set logged in variable
  {
    if(!$LoginView->getSessionStatus()) {
      $this->message = "";
    } 
    else 
    { 
      $this->isLoggedIn = false;
      session_unset();
      $LayoutView->LogoutMessage();
    }    
  }

  /**
   * If user wants login, call function to check credentials, and 
   */
  private function Login($CheckCredentials, $db, $LoginView, $LayoutView)
  {
    $username = $LoginView->getRequestUserName();
    $password = $LoginView->getRequestPassword();

    $CheckCredentials->CheckLogin($username, $password, $LoginView);
    $user = $db->getUser($username);
    if($user) 
    {
      if($password != $user[0]["password"]) 
      {
        throw new \Model\WrongNameOrPassword();  
      } else 
      {
        $this->isLoggedIn = true;
        $LayoutView->SuccessfulLogin();
        $_SESSION["username"] = $username;
      }
    }
  }

/**
 * If user clicks to register account, check credentials, and if they check out send info to register class. 
 * If exception is cast, catch the exception and calöl corresponding function in view to set message for user.
 */  
  private function Register($CheckCredentials, $register, $db, $RegisterView, $LayoutView) 
  {
    try {
      $username = $RegisterView->getRequestUserName();
      $password = $RegisterView->getRequestPassword();
      $passwordRepeat = $RegisterView->getRequestPasswordRepeat();
      $CheckCredentials->Checkregister($username, $password, $passwordRepeat, $RegisterView);
      $register->RegisterNewUser($username, $password,$db, $RegisterView);
      $this->showRegister = false;
      $LayoutView->SuccessfulRegistration();
    }
    catch (\Model\ShortUsernameAndPassword $e) {
      $LayoutView->ShortUsernameAndPassword();
    }
    catch (\Model\ShortUsername $e) {
      $LayoutView->ShortUsername();
    } 
    catch (\Model\ShortPassword $e) {
      $LayoutView->ShortPassword();
    } 
    catch (\Model\UserExists $e) {
      $LayoutView->UserExists();
    } 
    catch (\Model\InvalidCharacters $e) {
      $LayoutView->InvalidCharacters();
    } 
    catch (\Model\PasswordsNotMatch $e) {
      $LayoutView->PasswordsNotMatch();
    }     
  } 
}