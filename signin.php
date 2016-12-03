<?php
	require_once 'globalSetup.php';


	if( $UserFunctions->loggedIn()) {
		header('location: session_test.php');
	}

	if( isset($_POST['loginButton'])) {
		$UserFunctions->login($_POST['username'], $_POST['password']);
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
