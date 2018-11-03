<?php

namespace View;

class AddBookView {
  private static $addBook = 'AddBookView::AddBook';
	private static $author = 'AddBookView::Author';
	private static $title = 'AddBookView::Title';
	private static $description = 'AddBookView::Description';
	private $user_title;
	private $user_author;
	private $user_description;
	private $message;

	/**
	 * Render form
	 */
	public function render() : string {
		$response = $this->generateAddBookFormHTML();
		return $response;
	}
	
	// Generate HTML for adding new books
	private function generateAddBookFormHTML() : string {
		return '
		<h3> ' . $this->message . '</h3>
			<form method="post" > 
				<fieldset>
					<legend> Add new book - Enter at least author and title </legend>
					<label for="' . self::$author . '">Author :</label>
					<input type="text" id="' . self::$author . '" name="' . self::$author . '" value="' . $this->user_author . '" />

					<label for="' . self::$title . '">Title :</label>
					<input type="text" id="' . self::$title . '" name="' . self::$title . '" value="' . $this->user_title .'" />

					<label for="' . self::$description . '">Brief description of book:</label>
					<input type="textarea" id="' . self::$description . '" name="' . self::$description . '" value="' . $this->user_description . '" />
					
					<input type="submit" name="' . self::$addBook . '" value="Add book" />
				</fieldset>
			</form>
		';
	}
	// Function to set message for user
  public function NoAuthorOrTitle() {
    $this->message = "Please enter both an author and a title!";
	}
	
		// Get functions for request variables

		public function getAddBookStatus() : bool {
			return (isset($_POST["AddBookView::AddBook"]));
		}
	
		public function getRequestAuthor() : string {
			if (isset($_POST["AddBookView::Author"])) {
				return $_POST["AddBookView::Author"];
			} else {
				return "";
			}
		}
	
		public function getRequestTitle() : string {
			if (isset($_POST["AddBookView::Title"])) {
				return $_POST["AddBookView::Title"];
			} else {
				return "";
			}
		}
	
		public function getRequestDescription() : string {
			if (isset($_POST["AddBookView::Description"])) {
				return $_POST["AddBookView::Description"];
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
