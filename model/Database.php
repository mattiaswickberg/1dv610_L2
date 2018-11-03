<?php

namespace Model;

class Database {

  // Set initial variables needed for database operations. 
  private $servername = "";
  private $dbUsername = "";
  private $dbPassword = "";
  private $dbname = "";
  private $conn;
  private $Session;

  // Constructor that sets variables from config file, and sets up basic connection.
  public function __construct(array $config, \View\Session $session) {
    $this->Session = $session;
    $this->servername = $config["servername"];
    $this->dbUsername = $config["dbUsername"];
    $this->dbPassword = $config["dbPassword"];
    $this->dbname = $config["dbname"];
    $this->conn = new \PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->dbUsername, $this->dbPassword);
    $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  } 

  // Add new user to database
  public function AddUser(string $usernameToRegister, string $passwordToRegister) {
    $stmt = $this->conn->prepare("INSERT INTO 1dv607_users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $usernameToRegister);
    $stmt->bindParam(':password', $passwordToRegister);
    $stmt->execute();
    return true;
  }

  // Fetch a user from database
  public function getUser(string $user) {
    $stmt = $this->conn->prepare("SELECT username, password FROM 1dv607_users WHERE username = :username");
    $stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll();
    return($result);
  }

  // Fetch books for a specific user
  public function getBooksFromUser() : array {
    $user = $this->Session->getUser();
    $stmt = $this->conn->prepare("SELECT user, author, title, description, bookid FROM 1dv607_books WHERE user = :username");
    $stmt->bindParam(':username', $user , \PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll();
    return($result);
  }

  // Add a book for a user
  public function addBook(string $author, string $title, string $description, string $bookid) {
    $user = $this->Session->getUser();
    try {
      $stmt = $this->conn->prepare("INSERT INTO 1dv607_books (user, author, title, description, bookid) VALUES (:user, :author, :title, :description, :bookid)");
      $stmt->bindParam(':user', $user);
      $stmt->bindParam(':author', $author);
      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':bookid', $bookid);
      $stmt->execute();
      return true;
    }
    catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  // Fetch a book by id
  public function getBookById(int $id) {
    $user = $this->Session->getUser();
    $stmt = $this->conn->prepare("SELECT user, author, title, description, bookid FROM 1dv607_books WHERE user = :username AND bookid = :bookid");
    $stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $stmt->bindParam(':bookid', $id, \PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll();
    return($result);
  }

  // Update specific book
  public function updateBook(\Model\Book $book) {
    $user = $this->Session->getUser(); //get current user from session
    $id = $book->getId();
    $author = $book->getAuthor();
    $title = $book->getTitle();
    $description = $book->getDescription();

    $stmt = $this->conn->prepare("UPDATE 1dv607_books SET author = :author, title = :title, description = :description WHERE user = :username AND bookid = :bookid");
    $stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $stmt->bindParam(':bookid', $id, \PDO::PARAM_STR);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
  }

  // Delete a book by id
  public function deleteBook(int $id) {
    $user = $this->Session->getUser();
    $stmt = $this->conn->prepare("DELETE FROM 1dv607_books WHERE user = :username AND bookid = :bookid");
    $stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $stmt->bindParam(':bookid', $id, \PDO::PARAM_STR);
    $stmt->execute();
  }
}