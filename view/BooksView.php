<?php

namespace View;

class BooksView{
  private $Books;
  private $bookToEdit;
  private $message = '';
  private $EditBookView;
  private $AddBookView;

  public function __construct(\View\AddBookView $addBookView, \View\EditBookView $editBookView) {
    $this->AddBookView = $addBookView;
    $this->EditBookView = $editBookView;
  }

  // public function for controller to call to set which book should edited
  public function setBookToEdit(\Model\Book $book) {
    $this->bookToEdit = $book;
  }

  // Public function for controller to set book array so that this view can render the books already in the user's database
  public function setBooks(array $books) {
    $this->Books = $books;
  }

  // Render view with books added, or call EditBookView
  public function render() : string {
    $response = '<h3> ' . $this->message . '</h3> 
    <h1>Registered Books:</h1>';

    if (isset($this->bookToEdit)) {
      $response = $this->EditBookView->render($this->bookToEdit);
    } else {
      foreach ($this->Books as $book) {
        $response .= '<div> 
        <h2> ' . $book->getTitle() . ' </h2>
        <h3> By ' . $book->getAuthor() . ' </h3>
        <p> ' . $book->getDescription() . ' </p>
        <p> <a href="index.php?editbookid=' .$book->getId() . '">Edit book</a>  </p>
        </div>';
      }
    }
    return $response
    . ' <div> <h3>Add new book: </h3>' 
    . $this->AddBookView->render() . ' </div>';
  }

  // Functions to set message for user
  public function NoAuthorOrTitle() {
    $this->message = "You are not allowed to completely remove the author or title of a book!";
  }

  public function BookNotFound() {
    $this->message = "The book could not be found";
  }

  public function BookAdded() {
    $this->message = "Book added successfully.";
  }

  public function BookEdited() {
    $this->message = "Your changes have been saved.";
  }
}