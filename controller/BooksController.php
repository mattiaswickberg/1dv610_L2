<?php

namespace Controller;

class BooksController {

  public function Books(\Model\Database $db, \View\BooksView $BooksView, \View\AddBookView $AddBookView, \View\EditBookView $EditBookView) {
    if ($AddBookView->getAddBookStatus()) 
    {
      $this->addBookToDatabase($db, $EditBookView, $AddBookView);
    }
    if ($EditBookView->getIsEditActive()) {
      $BooksView->setBookToEdit(($db->getBookById($EditBookView->getUser(), $EditBookView->getQueryBookId()))[0]);
    }
    if ($EditBookView->getEditStatus()) {
      $db->updateBook($EditBookView->getUser(), $EditBookView->getRequestBookId(), $EditBookView->getRequestAuthor(), $EditBookView->getRequestTitle(), $EditBookView->getRequestDescription());
    }
    if ($EditBookView->getDeleteStatus()) {
      $db->deleteBook($EditBookView->getUser(), $EditBookView->getRequestBookId());
    }
    $BooksView->setBooks($this->getBooks($db, $EditBookView));
  }

  public function getBooks($db, $EditBookView) : array {
    return $db->getBooksFromUser($EditBookView->getUser());
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

  private function addBookToDatabase($db, $EditBookView, $AddBookView) {
    // getBookId
    $id = $this->getHighestId($this->getBooks($db, $EditBookView));

    // add book to database
    $db->addBook($EditBookView->getUser(), $AddBookView->getRequestAuthor(), $AddBookView->getRequestTitle(), $AddBookView->getRequestDescription(), $id);
  }  
}