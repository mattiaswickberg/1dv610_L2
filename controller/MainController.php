<?php
namespace Controller;

class Main {

  private $message = '';
  private $isLoggedIn = false;
  private $showRegister = false;

  public function Start(\View\LayoutView $layoutView, \View\LoginView $LoginView, \View\DateTimeView $dateTimeView, \View\RegisterView $RegisterView, \Model\Register $register , \Model\Database $db, \Controller\CheckCredentialsController $CheckCredentials) 
  {
    $this->message = '';
    if (isset($_POST["LoginView::Logout"])) 
    {
      $this->Logout();
    }
    if(isset($_SESSION["username"]))
    {
      $this->isLoggedIn = true;
      $this->message = "";      
    }
    else
    {
      if (isset($_GET["register"])) {
      $this->showRegister = true;
    }

    if (isset($_POST["LoginView::Login"])) 
    {
      try
      {
        $this->Login($CheckCredentials, $db);
      }
      catch (\Exception $e)
      {
        $this->message = $e->getMessage();
        $LoginView->setUserName($_POST["LoginView::UserName"]);
      }      
    } 
    else if (isset($_POST["RegisterView::Register"])) 
    {
      $this->Register($CheckCredentials, $register, $db);
      $RegisterView->setUserName(\strip_tags( $_POST["RegisterView::UserName"]));
      $LoginView->setUserName($_POST["RegisterView::UserName"]);
    }   
    }      
    $layoutView->render($this->isLoggedIn, $this->showRegister, $this->message, $LoginView, $dateTimeView, $RegisterView);   
  }

  private function Logout() 
  {
    if(!isset($_SESSION["username"])) 
    {
      $this->message = "";
    } 
    else 
    { 
      $this->isLoggedIn = false;
      session_unset();
      $this->message = "Bye bye!";
    }    
  }

  private function Login($CheckCredentials, $db)
  {
    $CheckCredentials->CheckLogin($_POST["LoginView::UserName"], $_POST["LoginView::Password"]);
    $user = $db->getUser($_POST["LoginView::UserName"]);
    if($user) 
    {
      if($_POST["LoginView::Password"] != $user[0]["password"]) 
      {
        throw new \Exception("Wrong name or password");  
      } else 
      {
        $this->isLoggedIn = true;
        $this->message = "Welcome";
        $_SESSION["username"] = $_POST["LoginView::UserName"];
      }
    }
  }

  private function Register($CheckCredentials, $register, $db) 
  {
    try {
      $CheckCredentials->Checkregister($_POST["RegisterView::UserName"], $_POST["RegisterView::Password"], $_POST["RegisterView::PasswordRepeat"]);
      $register->RegisterNewUser($_POST["RegisterView::UserName"], $_POST["RegisterView::Password"],$db);
      $this->showRegister = false;
      $this->message = "Registered new user.";
    }
    catch (\Exception $e)
    {
      $this->message = $e->getMessage();
    }
  } 
}