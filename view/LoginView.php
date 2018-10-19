<?php

namespace View;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $messageId = 'LoginView::Message';
	private $username = "";


	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($message, $isLoggedIn) {
		$response = '<p id="' . self::$messageId . '">' . $message . '</p>';
		if (!$isLoggedIn) {
			$response .= $this->generateLoginFormHTML($message);
		}
		$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->username . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}	

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() : string {
		if (isset($_POST["LoginView::UserName"]))
		{
			return $_POST["LoginView::UserName"];
		} else {
			return "";
		}				
	}

	public function getRequestPassword() {
		if (isset($_POST["LoginView::Password"]))
		{
			return $_POST["LoginView::Password"];
		} else {
			return "";
		}		
	}

	public function getRequestLogout() : bool {
		return isset($_POST["LoginView::Logout"]);
	}

	public function getRequestLogin() : bool {
		return isset($_POST["LoginView::Login"]);
	}

	public function getSessionStatus() : bool {
		return isset($_SESSION["username"]);
	}

	public function setUserName($username) {
		$this->username = $username;
	}
}
