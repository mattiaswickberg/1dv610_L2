<?php

namespace View;

class Session {

  public function getUser() : string {
    if($this->getSessionStatus()) {
      return $_SESSION["username"];
    } else {
      return "";
    }
  }

  public function setUser(string $username) {
    $_SESSION["username"] = $username;
  }

  public function getSessionStatus() : bool {
		return isset($_SESSION["username"]);
	}
}