<?php

namespace Model;

class Book {
  private $Author;
  private $Title;
  private $Description;
  private $Id;

  public function __construct(string $author, string $title, string $description = "", int $id) {
    $this->setAuthor($author);
    $this->setTitle($title);
    $this->setDescription($description);
    $this->Id = $id;
  }

  //getters
  public function getTitle() : string {
    return $this->Title;
  }

  public function getAuthor() : string {
    return $this->Author;
  }

  public function getDescription() : string {
    return $this->Description;
  }

  public function getId() : int {
    return $this->Id;
  }

  //setters
  public function setTitle(string $newTitle) {
    if(strlen($newTitle) == 0) {
      throw new NoTitleOrAuthor();
    }
    $this->Title = $newTitle;
  }

  public function setAuthor(string $newAuthor) {
    if(strlen($newAuthor) == 0) {
      throw new NoTitleOrAuthor();
    }
    $this->Author = $newAuthor;
  }

  public function setDescription(string $newDescription) {
    $this->Description = $newDescription;
  }

}