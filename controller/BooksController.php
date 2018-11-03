<?php

namespace Controller;
/**
 * Controller class for user interactions that has to do with adding, editing and deleting books
 */
class BooksController {
  private $Library;
  private $Database;
  private $BooksView;
  private $AddBookView;
  private $EditBookView;

  public function __construct(\Model\Library $library, \Model\Database $db, \View\BooksView $booksView, \View\AddBookView $addBookView, \View\EditBookView $editBookView) {
    $this->Library = $library;
    $this->Database = $db;
    $this->BooksView = $booksView;
    $this->AddBookView = $addBookView;
    $this->EditBookView = $editBookView;
  }

  public function Books() {
    $this->Library->getBooksFromDatabase(); // Fetch current books from library

    if ($this->AddBookView->getAddBookStatus()) // Check if user has clicked Add book
    {
      try {
        $this->CheckBookData($this->AddBookView->getRequestAuthor(), $this->AddBookView->getRequestTitle());
        $this->Library->AddNewBook($this->AddBookView->getRequestAuthor(), $this->AddBookView->getRequestTitle(), $this->AddBookView->getRequestDescription());
        $this->BooksView->BookAdded();
      }
      catch (\Model\NoTitleOrAuthor $e) { // If exception was cast, make sure user input is still available
        $this->AddBookView->NoAuthorOrTitle();
        $this->AddBookView->setAuthor($this->AddBookView->getRequestAuthor());
        $this->AddBookView->setTitle($this->AddBookView->getRequestTitle());
        $this->AddBookView->setDescription($this->AddBookView->getRequestDescription());
      }
    }
    if ($this->EditBookView->getIsEditActive()) {
      try {
        $this->BooksView->setBookToEdit($this->Library->getBook($this->EditBookView->getQueryBookId()));
      }
      catch (\Model\BookNotFound $e) {
        $this->BooksView->BookNotFound();
      }
    }
    if ($this->EditBookView->getEditStatus()) {
      try {
        $this->CheckBookData($this->EditBookView->getRequestAuthor(), $this->EditBookView->getRequestTitle());
        $this->Library->UpdateBook($this->EditBookView->getRequestBookId(), $this->EditBookView->getRequestAuthor(), $this->EditBookView->getRequestTitle(), $this->EditBookView->getRequestDescription());
        $this->BooksView->BookEdited();
      }
      catch (\Model\NoTitleOrAuthor $e) {
        $this->BooksView->NoAuthorOrTitle();
      }
    }
    if ($this->EditBookView->getDeleteStatus()) {
      $this->Library->DeleteBook($this->EditBookView->getRequestBookId());
    }
    $this->BooksView->setBooks($this->Library->getBooks());
  }

  // Retrieving books from database
  public function getBooks() : array {
    return $this->Database->getBooksFromUser();
  }

  // Add new book to library
  private function addBookToDatabase() {
    $this->Library->AddNewBook($this->AddBookView->getRequestAuthor(), $this->AddBookView->getRequestTitle(), $this->AddBookView->getRequestDescription());
  }  

  private function CheckBookData(string $author, string $title) {
    if (strlen($author) == 0 || strlen($title) == 0) {
      throw new \Model\NoTitleOrAuthor();
    }
  }
}