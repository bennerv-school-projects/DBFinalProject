<?php
	require_once 'globalSetup.php';

	// Check if a user is logged in already and redirect them to the select exam page
	if( $UserFunctions->loggedIn()) {
		exit(header('location: selectExam.php'));
	}
	
	// If the user pressed the login button, try to log them in
	if( isset($_POST['loginButton'])) {
		$result = $UserFunctions->login($_POST['username'], $_POST['password']);

		// Check the status of the login and print out an error message if they failed to login
		if( $result['status'] == 0 ) {
			echo '<b>'.$result['message'].'</b>';
		} else {	
			exit(header('location: index.php'));
		}
	}
?>



<html>
	<link rel="stylesheet" type="css" href="front.css">
	<body>
		<form action="" method="post">
			Student Id: <input type="text" name="username"/> <br/>
			Password: <input type="password" name="password"/> <br/>
			<input type="submit" name="loginButton" value="Log In"/>
		</form>


		<a href="signup.php">Sign up</a>
	</body>
</html>
