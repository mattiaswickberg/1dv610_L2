<?php

namespace View;

class BooksView{
  private $Books = array();
  private $bookToEdit;

  public function setBookToEdit($book) {
    $this->bookToEdit = $book;
  }

  public function setBooks($books) {
    $this->Books = $books;
  }

  public function render($EditBookView) : string {
    $response = '';

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

}