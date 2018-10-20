<?php

namespace Controller;
/**
 * Controller class for user interactions that has to do with adding, editing and deleting books
 */
class BooksController {

  public function Books(\Model\Database $db, \View\BooksView $BooksView, \View\AddBookView $AddBookView, \View\EditBookView $EditBookView) {
    if ($AddBookView->getAddBookStatus()) 
    {
      try {
        $this->CheckBookData($AddBookView->getRequestAuthor(), $AddBookView->getRequestTitle());
        $this->addBookToDatabase($db, $EditBookView, $AddBookView);
      }
      catch (\Model\NoTitleOrAuthor $e) {
        $BooksView->NoAuthorOrTitle();
      }
    }
    if ($EditBookView->getIsEditActive()) {
      $BooksView->setBookToEdit(($db->getBookById($EditBookView->getUser(), $EditBookView->getQueryBookId()))[0]);
    }
    if ($EditBookView->getEditStatus()) {
      try {
        $this->CheckBookData($AddBookView->getRequestAuthor(), $AddBookView->getRequestTitle());
        $db->updateBook($EditBookView->getUser(), $EditBookView->getRequestBookId(), $EditBookView->getRequestAuthor(), $EditBookView->getRequestTitle(), $EditBookView->getRequestDescription());
      }
      catch (\Model\NoTitleOrAuthor $e) {
        $BooksView->NoAuthorOrTitle();
      }
    }
    if ($EditBookView->getDeleteStatus()) {
      $db->deleteBook($EditBookView->getUser(), $EditBookView->getRequestBookId());
    }
    $BooksView->setBooks($this->getBooks($db, $EditBookView));
  }

  // Retrieving books from database
  public function getBooks($db, $EditBookView) : array {
    return $db->getBooksFromUser($EditBookView->getUser());
  }

  // Identify the book with the highest id in the database,then increase that id one point to provide a unique id for a new book. 
  private function getHighestId($books) : int {
    $id = 0;
    foreach ($books as $b) {
      if (intval($b["bookid"]) >= $id) {
        $id = (intval($b["bookid"]) + 1);
      } 
    }
    return $id;
  }

  // Get id for new book and send it to the database for storage
  private function addBookToDatabase($db, $EditBookView, $AddBookView) {
    // getBookId
    $id = $this->getHighestId($this->getBooks($db, $EditBookView));

    // add book to database
    $db->addBook($EditBookView->getUser(), $AddBookView->getRequestAuthor(), $AddBookView->getRequestTitle(), $AddBookView->getRequestDescription(), $id);
  }  

  private function CheckBookData($author, $title) {
    if (strlen($author) == 0 || strlen($title) == 0) {
      throw new \Model\NoTitleOrAuthor();
    }
  }
}