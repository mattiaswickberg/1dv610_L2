<?php

namespace View;

class EditBookView {
  private static $editBook = 'EditBookView::EditBook';
	private static $author = 'EditBookView::Author';
	private static $title = 'EditBookView::Title';
  private static $description = 'EditBookView::Description';
  private static $deleteBook = 'EditBookView::DeleteBook';
	private static $bookId = 'EditBookView::BookId';
	private $user_title;
	private $user_author;
	private $user_description;
	private $message;

  public function render(\Model\Book $book) : string {
		$response = $this->generateEditBookFormHTML($book);
		return $response;
	}
	
	// Generate html for form to edit existing book
	private function generateEditBookFormHTML(\Model\Book $book) : string {
		return '
		<h3> ' . $this->message . '</h3>
			<form method="post" action="index.php"> 
				<fieldset>
          <legend> Edit book - make your desired changes and press "Save changes" </legend>	
          <label for="' . self::$bookId . '">Book Id:</label>
          <input type="text" id="' . self::$bookId . '" name="' . self::$bookId . '" hidden value="' . $book->getId() . '" />
          
          <label for="' . self::$author . '">Author:</label>
					<input type="text" id="' . self::$author . '" name="' . self::$author . '" value="'. $book->getAuthor() . '" />

					<label for="' . self::$title . '">Title:</label>
					<input type="text" id="' . self::$title . '" name="' . self::$title . '" value="'. $book->getTitle() . '" />

					<label for="' . self::$description . '">Brief description of book:</label>
					<input type="textarea" id="' . self::$description . '" name="' . self::$description . '" value="'. $book->getDescription() . '" />
					
          <input type="submit" name="' . self::$editBook . '" value="Save changes" />
          
          <input type="submit" name="' .self::$deleteBook . '" value="Delete book" />
				</fieldset>
			</form>
		';
	}  

	// Function to set message for user
  public function NoAuthorOrTitle() {
    $this->message = "Please enter both an author and a title!";
  }

	// Get functions for request variables

	public function getEditStatus() : bool {
		return (isset($_POST["EditBookView::EditBook"]));
	}

	public function getDeleteStatus() : bool {
		return (isset($_POST["EditBookView::DeleteBook"]));
	}

	public function getIsEditActive() : bool {
		return isset($_GET["editbookid"]);
	}

	public function getRequestAuthor() : string {
		if (isset($_POST["EditBookView::Author"])) {
			return $_POST["EditBookView::Author"];
		} else {
			return "";
		}
	}

	public function getRequestTitle() : string {
		if (isset($_POST["EditBookView::Title"])) {
			return $_POST["EditBookView::Title"];
		} else {
			return "";
		}
	}

	public function getRequestDescription() : string {
		if (isset($_POST["EditBookView::Description"])) {
			return $_POST["EditBookView::Description"];
		} else {
			return "";
		}
	}

	public function getRequestBookId() : string {
		if (isset($_POST["EditBookView::BookId"])) {
			return $_POST["EditBookView::BookId"];
		} else {
			return "";
		}
	}

	public function getQueryBookId() : string {
		if (isset($_GET["editbookid"])) {
			return $_GET["editbookid"];
		} else  {
		return "";
		}
	} 

	public function getUser() : string {
		if (isset($_SESSION["username"])) {
			return $_SESSION["username"];
		} else {
			return "";
		}
	}

	// Set functions
	public function setTitle(string $title) {
		$this->user_title = $title;

	}

	public function setAuthor(string $author) {
		$this->user_author = $author;
	}

	public function setDescription(string $description) {
		$this->user_description = $description;
	}
}