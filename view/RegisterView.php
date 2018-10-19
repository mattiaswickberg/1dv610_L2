<?php

namespace View;

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
  private static $password = 'RegisterView::Password';
  private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	private $username = "";
	private $message = "";


	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($message) {
			
		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Register new user - choose username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->username . '" />

					<label for="' . self::$password . '">Password :</label>
          <input type="password" id="' . self::$password . '" name="' . self::$password . '" />
          
          <label for="' . self::$passwordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
				
					<input type="submit" name="' . self::$register . '" value="register" />
				</fieldset>
			</form>
		';
	}

	// Functions to set message
	


	// Get request variables

	public function getRegisterStatus() : bool {
		return isset($_GET["register"]);
	}

	public function getRequestRegister() : bool {
		return isset($_POST["RegisterView::Register"]);
	}

	public function getRequestUserName() : string {
		if(isset($_POST["RegisterView::UserName"])) {
			return $_POST["RegisterView::UserName"];
		} else {
			return "";
		}
	}

	public function getRequestPassword() : string {
		if(isset($_POST["RegisterView::Password"])) {
			return $_POST["RegisterView::Password"];
		} else {
			return "";
		}
	}

	public function getRequestPasswordRepeat() : string {
		if(isset($_POST["RegisterView::PasswordRepeat"])) {
			return $_POST["RegisterView::PasswordRepeat"];
		} else {
			return "";
		}
	}

	public function setUserName($username) {
		$this->username = $username;
	}
}