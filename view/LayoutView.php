<?php

namespace View;
class LayoutView {
  private $message = "";
  private $LoginView;
  private $DateTimeView;
  private $RegisterView;
  private $BooksView;
  
  public function __construct(LoginView $loginView, DateTimeView $dateTimeView, RegisterView $registerView, \View\BooksView $booksView) {
    $this->LoginView = $loginView;
    $this->DateTimeView = $dateTimeView;
    $this->RegisterView = $registerView;
    $this->BooksView = $booksView;
  }
  // Render basic layout for page
  public function render(bool $isLoggedIn, bool $showRegister) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $this->registerUser($showRegister, $isLoggedIn) . '
              ' . $this->showBooks($isLoggedIn) . '

              ' . $this->DateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  // return string based on user's login status
  private function renderIsLoggedIn(bool $isLoggedIn) : string {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  // return html link for either register user or back to main page
  private function registerUser(bool $showRegister, bool $isLoggedIn) : string {
    $response = '';
    if ($showRegister) {
      $response = '<p><a href="index.php">Back to login</a></p>' . $this->RegisterView->response($this->message);
    } else {
      if (!$showRegister && !$isLoggedIn) {
        $response .= '<p><a href="index.php?register">Register a new user</a></p> ';
      } 
      $response .= $this->LoginView->response($this->message, $isLoggedIn);
    } 
    return $response;
  }

  // If user is logged in, render views for books
  private function showBooks(bool $isLoggedIn) : string {
        if($isLoggedIn) {
          return 
          ' <div> '. $this->BooksView->render() . ' </div> ';
        } else {
          return '';
        }
  }

  // Function to remove message
	public function NoMessage() {
		$this->message = "";
  }
  
  // Functions to set success messages
  public function LogoutMessage() {
    $this->message = "Bye bye!";
  }

  public function SuccessfulLogin() {
    $this->message = "Welcome";
  }

  public function SuccessfulRegistration() {
    $this->message = "Registered new user.";
  }

  // Error messages
	public function WrongNameOrPassword() {
		$this->message = "Wrong name or password";
  }

  public function ShortUsernameAndPassword() {
    $this->message = "Username has too few characters, at least 3 characters. <br> Password has too few characters, at least 6 characters. ";
  }

  public function ShortUsername() {
    $this->message = "Username has too few characters, at least 3 characters. ";
  }

  public function ShortPassword() {
    $this->message = "Password has too few characters, at least 6 characters. ";
  }

  public function UserExists() {
    $this->message = "User exists, pick another username.";
  }

  public function InvalidCharacters() {
    $this->message = "Username contains invalid characters.";
  }

  public function PasswordsNotMatch() {
    $this->message = "Passwords do not match.";
  }

  public function UsernameMissing() {
    $this->message = "Username is missing";
  }

  public function PasswordMissing() {
    $this->message = "Password is missing";
  }  
}
