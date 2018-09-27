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
}