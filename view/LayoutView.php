<?php

namespace View;
class LayoutView {
  private $message = "";
  
  public function render($isLoggedIn, $showRegister, LoginView $LoginView, DateTimeView $DateTimeView, registerView $RegisterView, \View\BooksView $BooksView, \View\AddBookView $AddBookView, \View\EditBookView $EditBookView) {
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
              ' . $this->registerUser($showRegister, $LoginView, $RegisterView, $isLoggedIn) . '
              ' . $this->showBooks($isLoggedIn, $BooksView, $AddBookView, $EditBookView) . '

              ' . $DateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function registerUser($showRegister, $LoginView , $RegisterView, $isLoggedIn) {
    $response = '';
    if ($showRegister) {
      $response = '<p><a href="index.php">Back to login</a></p>' . $RegisterView->response($this->message);
    } else {
      if (!$showRegister && !$isLoggedIn) {
        $response .= '<p><a href="index.php?register">Register a new user</a></p> ';
      } 
      $response .= $LoginView->response($this->message, $isLoggedIn);
    } 
    return $response;
  }

  private function showBooks($isLoggedIn, $BooksView, $AddBookView, $EditBookView) {
        if($isLoggedIn) {
          return  ' <div> <h3>Add new book: </h3>' 
          . $AddBookView->render() . ' </div>' . 
          '<h1>Registered Books:</h1> '
          . ' <div> '. $BooksView->render($EditBookView) . ' </div> ' ;
        } else {
          return '';
        }
  }

  // Functions to set message

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
