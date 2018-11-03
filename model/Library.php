<?php

namespace Model;

class Library {
  private $Books = array();
  private $Database;

  public function __construct(\Model\Database $database) {
    $this->Database = $database;
  }
  
  public function getBook(int $id) {
    foreach($this->Books as $book) {
      if ($book->getId() == $id) {
        return $book;
      }
    }
  }

  public function getBooks() {
    return $this->Books;
  }

  public function AddNewBook(string $author, string $title, string $description) {
    $id = $this->GetNewId();
    array_push($this->Books, new \Model\Book($author, $title, $description, $id));
    $this->Database->addBook($author, $title, $description, $id);
  }

  public function UpdateBook(int $bookid, string $author, string $title, string $description) {
    foreach ($this->Books as $book) {
      if($book->getId() == $bookid) {
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $this->Database->updateBook($book);
      }
    }
  }

  public function GetNewId() : int {
    $id = 0;
    foreach ($this->Books as $book) { // Go through current array of books, set $id to highest of current ids
      $bookId = $book->getId();
      if ($bookId >= $id) {
        $id = $bookId;
      }
    }

    return $id + 1; // return value one higher than highest current id
  }

  public function DeleteBook(int $id)  {
    $this->Database->deleteBook($id); // Delete book from database
    $this->getBooksFromDatabase(); // Update Books array
  }

  public function getBooksFromDatabase() {
    $books = $this->Database->getBooksFromUser();
    unset($this->Books);
    $this->Books = array();

    foreach ($books as $b) {
      $book = new \Model\Book($b["author"], $b["title"], $b["description"], $b["bookid"]);
      array_push($this->Books, $book);
    }
  }  
}