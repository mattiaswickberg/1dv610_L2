<?php

namespace Model;

class Database {
  private $servername = "";
  private $dbUsername = "";
  private $dbPassword = "";
  private $dbname = "";
  private $conn;
  private $stmt;

  public function __construct($config) {
    $this->servername = $config["servername"];
    $this->dbUsername = $config["dbUsername"];
    $this->dbPassword = $config["dbPassword"];
    $this->dbname = $config["dbname"];
    $this->conn = new \PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->dbUsername, $this->dbPassword);
    $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  } 

  public function AddUser($usernameToRegister, $passwordToRegister) {
    $stmt = $this->conn->prepare("INSERT INTO 1dv607_users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $usernameToRegister);
    $stmt->bindParam(':password', $passwordToRegister);
    $stmt->execute();
    return true;
  }

  public function getUser($user) {
    $this->stmt = $this->conn->prepare("SELECT username, password FROM 1dv607_users WHERE username = :username");
    $this->stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $this->stmt->execute();

    $result = $this->stmt->fetchAll();
    return($result);
  }

  public function getBooksFromUser($user) {
    $this->stmt = $this->conn->prepare("SELECT user, author, title, description, bookid FROM 1dv607_books WHERE user = :username");
    $this->stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $this->stmt->execute();

    $result = $this->stmt->fetchAll();
    return($result);
  }

  public function addBook($user, $author, $title, $description, $bookid) {
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

  public function getBookById($user, $id) {
    $this->stmt = $this->conn->prepare("SELECT user, author, title, description, bookid FROM 1dv607_books WHERE user = :username AND bookid = :bookid");
    $this->stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $this->stmt->bindParam(':bookid', $id, \PDO::PARAM_STR);
    $this->stmt->execute();

    $result = $this->stmt->fetchAll();
    return($result);
  }

  public function updateBook($user, $id, $author, $title, $description) {
    $stmt = $this->conn->prepare("UPDATE 1dv607_books SET author = :author, title = :title, description = :description WHERE user = :username AND bookid = :bookid");
    $stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $stmt->bindParam(':bookid', $id, \PDO::PARAM_STR);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
  }

  public function deleteBook($user, $id) {
    $stmt = $this->conn->prepare("DELETE FROM 1dv607_books WHERE user = :username AND bookid = :bookid");
    $stmt->bindParam(':username', $user, \PDO::PARAM_STR);
    $stmt->bindParam(':bookid', $id, \PDO::PARAM_STR);
    $stmt->execute();
  }
}