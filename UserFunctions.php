<?php
# Config for the database sign in
require_once("config.php");

#TODO <BMV> CHECK THE $RESULT is true and include error messages in everything if failed instead of die()

# List of public functions for checking if people are logged in etc.
class UserFunctions {
	
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
	
	public function login($username, $password) {
		$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$username = strtolower($username);
		
		$statement = $dbh->prepare('SELECT password FROM student WHERE s_id = ?');
		$result = $statement->execute([
			$username
		]);
		
		$numOfRows = $statement->rowCount();
		
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

		return array("status" => 1, "message" => "Success");
		
	}
	
	
	public function removeSession($username, $session) {
		
		$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$username = strtolower($username);
		
		$statement = $dbh->prepare('UPDATE student SET session = null WHERE s_id = ?' );
		$result = $statement->execute([
			$username
		]);
	}
	
	public function signup($username, $major, $name, $password) {
		$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$username = strtolower($username);
		
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
