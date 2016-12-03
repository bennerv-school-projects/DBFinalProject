<?php
	require_once 'globalSetup.php';


	if( $UserFunctions->loggedIn()) {
		exit(header('location: selectExam.php'));
	}

	if( isset($_POST['loginButton'])) {
		$result = $UserFunctions->login($_POST['username'], $_POST['password']);
		if( $result['status'] == 0 ) {
			echo $result['message'];
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
