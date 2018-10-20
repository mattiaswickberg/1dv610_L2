<?php

namespace Model;

// Create custom exceptions for common errors in user input
class ShortUsernameAndPassword extends \Exception {

}

class ShortUsername extends \Exception {

}

class ShortPassword extends \Exception {

}

class WrongNameOrPassword extends \Exception {

}

class UserExists extends \Exception {

}

class InvalidCharacters extends \Exception {

}

class PasswordsNotMatch extends \Exception {

}

class UsernameMissing extends \Exception {

}

class PasswordMissing extends \Exception {

}

class NoTitleOrAuthor extends \Exception {
  
}