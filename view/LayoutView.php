<?php

namespace View;
class LayoutView {
  
  public function render($isLoggedIn, $showRegister, $message, LoginView $v, DateTimeView $dtv, registerView $rv) {
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
              ' . $this->registerUser($showRegister, $v, $rv, $message) . '
              
              ' . $dtv->show() . '
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

  private function registerUser($showRegister, $v , $rv, $message) {
    if ($showRegister) {
      return '<p><a href="index.php">Back to login</a></p>' . $rv->response($message);
    } else {
      return '<p><a href="index.php?register">Register a new user</a></p> ' . $v->response($message);
    }
  }
}
