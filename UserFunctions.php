<?php
# Config for the database sign in
require_once("config.php");

#TODO <BMV> CHECK THE $RESULT is true and include error messages in everything if failed instead of die()

# List of public functions for checking if people are logged in etc.
class UserFunctions {
	
	# The reference to the database
	public $dbh = NULL;
	
	function __construct() {
		$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Constructor finished";
	}
	
	public function loggedIn() {
		try {
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
			echo "FAILED";
			return false;
		}
	}	
	
	public function login($username, $password) {
		
		$username = strtolower($username);
		
		$statement = $dbh->prepare('SELECT password FROM student WHERE s_id = ?' );
		$result = $statement->execute([
			$username
		]);
		
		$numOfRows = $statement->rowCount();
		
		# The number of rows returned is not correct
		if( $numOfRows != 1 ) {
			die();
		}
		$correctPassword = $statement->fetch();
		
		# Wrong password 
		if( !password_verify($password, $correctPassword) ) {
			die();
		}
		
		# Set the session id in the sql database to check it's the correct person
		$updateStatement = $dbh->prepare('UPDATE student SET session = ? WHERE s_id = ?');
		$updateStatement->execute([
			session_id(),
			$username
		]);
		
		# Set the session and user ids in the $_SESSION variable
		$_SESSION['userid'] = $username;
		$_SESSION['session'] = session_id();
	}
	
	
	public function removeSession($username, $session) {
		
		$username = strtolower($username);
		
		$statement = $dbh->prepare('UPDATE student SET session = null WHERE s_id = ?' );
		$result = $statement->execute([
			$username
		]);
	}
	
	public function signup($username, $major, $name, $password) {
		$username = strtolower($username);
		
		$selectStatement = $dbh->prepare('SELECT COUNT(*) FROM student where s_id = ?');
		$result = $selectStatement->execute([
			$username
		]);
		
		# a user by this name already exists
		if( $selectStatement->rowCount() > 0 ) {
			die();
			
		}
		
		# insert the value into the database
		$insertStatement = $dbh->prepare('INSERT INTO student values(?, ?, ?, ?) ');
		$result = $insertStatement->execute([
			$username,
			$major,
			$name,
			password_hash($password, PASSWORD_DEFAULT)
		]);
	}
}

?>