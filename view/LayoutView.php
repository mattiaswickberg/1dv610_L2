<?php

namespace View;
class LayoutView {
  
  public function render($isLoggedIn, $showRegister, $message, LoginView $LoginView, DateTimeView $DateTimeView, registerView $RegisterView, \View\BooksView $BooksView, \View\AddBookView $AddBookView, \View\EditBookView $EditBookView) {
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
              ' . $this->registerUser($showRegister, $LoginView, $RegisterView, $message, $isLoggedIn) . '
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

  private function registerUser($showRegister, $LoginView , $RegisterView, $message, $isLoggedIn) {
    $response = '';
    if ($showRegister) {
      $response = '<p><a href="index.php">Back to login</a></p>' . $RegisterView->response($message);
    } else {
      if (!$showRegister && !$isLoggedIn) {
        $response .= '<p><a href="index.php?register">Register a new user</a></p> ';
      } 
      $response .= $LoginView->response($message, $isLoggedIn);
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
}
