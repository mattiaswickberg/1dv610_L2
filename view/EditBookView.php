<?php

namespace View;

class EditBookView {
  private static $editBook = 'EditBookView::EditBook';
	private static $author = 'EditBookView::Author';
	private static $title = 'EditBookView::Title';
  private static $description = 'EditBookView::Description';
  private static $deleteBook = 'EditBookView::DeleteBook';
  private static $bookId = 'EditBookView::BookId';

  public function render($book) : string {
		$response = $this->generateEditBookFormHTML($book);
		return $response;
	}
	
	private function generateEditBookFormHTML($book) {
		return '
			<form method="post" action="index.php"> 
				<fieldset>
          <legend> Edit book - make your desired changes and press "Save changes" </legend>	
          
          <label for="' . self::$bookId . '">Book Id:</label>
          <input type="text" id="' . self::$bookId . '" name="' . self::$bookId . '" readonly value="' . $book["bookid"] . '" />
          
          <label for="' . self::$author . '">Author:</label>
					<input type="text" id="' . self::$author . '" name="' . self::$author . '" value="'. $book["author"] . '" />

					<label for="' . self::$title . '">Title:</label>
					<input type="text" id="' . self::$title . '" name="' . self::$title . '" value="'. $book["title"] . '" />

					<label for="' . self::$description . '">Brief description of book:</label>
					<input type="textarea" id="' . self::$description . '" name="' . self::$description . '" value="'. $book["description"] . '" />
					
          <input type="submit" name="' . self::$editBook . '" value="Save changes" />
          
          <input type="submit" name="' .self::$deleteBook . '" value="Delete book" />
				</fieldset>
			</form>
		';
	}  
}