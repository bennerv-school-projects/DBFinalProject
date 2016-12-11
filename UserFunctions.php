<?php
# Config for the database sign in
require_once("config.php");

# List of public functions for checking if people are logged in etc.
class UserFunctions {
	
	# Checks if a user is already logged in and returns either true or false if they are based on the session 
	public function loggedIn() {
		try {
			$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			if(!empty($_SESSION)) {
				$statement = $dbh->prepare('SELECT COUNT(*) FROM student WHERE s_id = ? AND session = ?');
					
				$result = $statement->execute([
					$_SESSION['userid'],
					$_SESSION['session']
				]);
					
				return ($statement->rowCount() == 1);
			}
			return false;
		} catch(PDOException $e) {
			return false;
		}
	}	
	
	# Logs in a user with the specified username and password, or returns 0 and an error message if unsuccessful 
	public function login($username, $password) {
		$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$username = strtolower($username);
		
		$statement = $dbh->prepare('SELECT password FROM student WHERE s_id = ?');
		$result = $statement->execute([
			$username
		]);
		
		$numOfRows = $statement->rowCount();
		
		// No user exists by this student id
		if( $numOfRows == 0) {
			return array("status" => 0, "message" => "Invalid student id");
		}
		
		# The number of rows returned is not correct
		if( $numOfRows != 1 ) {
			return array("status" => 0, "message" => "Multiple users with the same id.  Please contact the administrator");
		}
		$correctPassword = $statement->fetch();
		
		# Wrong password 
		if( crypt($password, $correctPassword['password']) != $correctPassword['password']) {
			return array("status" => 0, "message" => "Invalid password");
		}
		
		# Set the session id in the sql database to check it's the correct person
		$updateStatement = $dbh->prepare('UPDATE student SET session = ? WHERE s_id = ?');
		$updateStatement->execute([
			md5($username),
			$username
		]);
		
		# Set the session and user ids in the $_SESSION variable
		$_SESSION['userid'] = $username;
		$_SESSION['session'] = md5($username);

		// Successful login
		return array("status" => 1, "message" => "Success");
		
	}
	
	# Creates a new user with an associated name, username, major and password.  If unsuccessful returns 0 and an error message, else logs them in.	
	public function signup($username, $major, $name, $password) {
		$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$username = strtolower($username);
		
		// Username must be at least 4 characters check
		if( strlen($username) < 4 ) {
			return array("status" => 0, "message" => "Usernames must be at least 4 characters");
		}
		
		// Check if they entered a major
		if( strlen($major) == 0) {
			return array("status" => 0, "message" => "You must enter a major");
		}
		
		// Check if they entered a name
		if( strlen($name) == 0) {
			return array("status" => 0, "message" => "You must enter a name");
		}
		
		// Password must be at least 4 characters
		if( strlen($password) < 4) {
			return array("status" => 0, "message" => "Passwords must be at least 4 characters");
		}
		
		$selectStatement = $dbh->prepare('SELECT * FROM student where s_id = ?');
		$result = $selectStatement->execute([
			$username
		]);
		
		# a user by this name already exists
		if( $selectStatement->rowCount() != 0 ) {
			return array("status" => 0, "message" => "This student id already exists");
			
		}
		
		# insert the value into the database
		$insertStatement = $dbh->prepare('INSERT INTO student values(?, ?, ?, ?, ?) ');
		$result = $insertStatement->execute([
			$username,
			$major,
			$name,
			crypt($password),
			null
		]);
		
		$this->login($username, $password);

		return array("status" => 1, "message" => "Success");
	}
}

?>
