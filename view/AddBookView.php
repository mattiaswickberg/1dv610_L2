<?php

namespace View;

class AddBookView {
  private static $addBook = 'AddBookView::AddBook';
	private static $author = 'AddBookView::Author';
	private static $title = 'AddBookView::Title';
	private static $description = 'AddBookView::Description';

	/**
	 * Render form
	 */
	public function render() : string {
		$response = $this->generateAddBookFormHTML();
		return $response;
	}
	
	// Generate HTML for adding new books
	private function generateAddBookFormHTML() {
		return '
			<form method="post" > 
				<fieldset>
					<legend> Add new book - Enter at least author and title </legend>
					<label for="' . self::$author . '">Author :</label>
					<input type="text" id="' . self::$author . '" name="' . self::$author . '" value="' . '" />

					<label for="' . self::$title . '">Title :</label>
					<input type="text" id="' . self::$title . '" name="' . self::$title . '" />

					<label for="' . self::$description . '">Brief description of book:</label>
					<input type="textarea" id="' . self::$description . '" name="' . self::$description . '" />
					
					<input type="submit" name="' . self::$addBook . '" value="Add book" />
				</fieldset>
			</form>
		';
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
}
