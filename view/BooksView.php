<?php

namespace View;

class BooksView{
  private $Books = array();
  private $bookToEdit;
  private $message = '';

  // public function for controller to call to set which book should edited
  public function setBookToEdit($book) {
    $this->bookToEdit = $book;
  }

  // Public function for controller to set book array so that this view can render the books already in the user's database
  public function setBooks($books) {
    $this->Books = $books;
  }

  // Render view with books added, or call EditBookView
  public function render($EditBookView) : string {
    $response = '<h3> ' . $this->message . '</h3>';

    if (isset($this->bookToEdit)) {
      $response = $EditBookView->render($this->bookToEdit);
    } else {
      foreach ($this->Books as $book) {
        $response .= '<div> 
        <h2> ' . $book["title"] . ' </h2>
        <h3> By ' . $book["author"] . ' </h3>
        <p> ' . $book["description"] . ' </p>
        <p> <a href="index.php?editbookid=' .$book["bookid"] . '">Edit book</a>  </p>
        </div>';
      }
    }
    return $response;
  }

  // Function to set message for user
  public function NoAuthorOrTitle() {
    $this->message = "Please enter at least an author and a title!";
  }
}