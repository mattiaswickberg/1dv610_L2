<?php

namespace Controller;

class BooksController {
  private $EditBook = false;

  public function Books(\Model\Database $db, \View\BooksView $BooksView, \View\EditBookView $EditBookView) {
    if (isset($_POST["AddBookView::AddBook"])) 
    {
      $this->addBookToDatabase($db);
    }
    if (isset($_GET["editbookid"])) {
      $BooksView->setBookToEdit(($db->getBookById($_SESSION["username"], $_GET["editbookid"]))[0]);
    }
    if (isset($_POST["EditBookView::EditBook"])) {
      $db->updateBook($_SESSION["username"], $_POST["EditBookView::BookId"], $_POST["EditBookView::Author"], $_POST["EditBookView::Title"], $_POST["EditBookView::Description"] );
    }
    if (isset($_POST["EditBookView::DeleteBook"])) {
      $db->deleteBook($_SESSION["username"], $_POST["EditBookView::BookId"]);
    }
    $BooksView->setBooks($this->getBooks($db));
  }

  public function getBooks($db) : array {
    return $db->getBooksFromUser($_SESSION["username"]);
  }

  private function getHighestId($books) : int {
    $id = 0;
    foreach ($books as $b) {
      if (intval($b["bookid"]) >= $id) {
        $id = (intval($b["bookid"]) + 1);
      } 
    }
    return $id;
  }

  private function addBookToDatabase($db) {
    // getBookId
    $id = $this->getHighestId($this->getBooks($db));

    // add book to database
    $db->addBook($_SESSION["username"], $_POST["AddBookView::Author"], $_POST["AddBookView::Title"], $_POST["AddBookView::Description"], $id);
  }  
}