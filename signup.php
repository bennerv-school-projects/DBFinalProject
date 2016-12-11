<?php

require_once 'globalSetup.php';
echo '<link rel="stylesheet" href="front.css">';

// Check if the user is already logged in and redirect them if so
if( $UserFunctions->loggedIn() ) {
	exit(header('Location: selectExam.php'));
}

// Check if the user pressed the submit button and try to sign them up
if(isset($_POST['submitButton']) ) {
	$result = $UserFunctions->signup($_POST['username'], $_POST['major'], $_POST['name'], $_POST['password']);
	
	// Print out an error message if they failed to signup, else redirect them to the homepage
	if ($result['status'] == 0 ) {
		echo '<b>'.$result['message'].'</b>';
	} else {
		exit(header('location: index.php'));
	}
}


?>

<html>
	<link rel="stylesheet" type="test/css" href="front.css">
	<body>
		
		<form action="" method="post">
			Name: <input type="text" name="name"/> <br/>
			Student Id: <input type="text" name="username"/> <br/>
			Password: <input type="password" name="password"/> <br/>
			Major: <input type="text" name="major"/>
			<input type="submit" name="submitButton" value="Signup"/>
		</form>

		<a href="signin.php">Sign in</a>
	</body>
</html>

