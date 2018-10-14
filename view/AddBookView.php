<?php

namespace View;

class AddBookView {
  private static $addBook = 'AddBookView::AddBook';
	private static $author = 'AddBookView::Author';
	private static $title = 'AddBookView::Title';
	private static $description = 'AddBookView::Description';
  private static $messageId = 'AddBookView::Message';
  private $message = "";
	/**
	 * 
	 */
	public function render() : string {
		$response = $this->generateAddBookFormHTML();
		return $response;
	}
	
	private function generateAddBookFormHTML() {
		return '
			<form method="post" > 
				<fieldset>
					<legend> Add new book - Enter at least author and title </legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
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
}
