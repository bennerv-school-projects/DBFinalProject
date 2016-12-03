<?php

require_once 'globalSetup.php';

if( $UserFunctions->loggedIn() ) {
	exit(header('Location: selectExam.php'));
}

if(isset($_POST['submitButton']) ) {
	$result = $UserFunctions->signup($_POST['username'], $_POST['major'], $_POST['name'], $_POST['password']);
	
	if ($result['status'] == 0 ) {
		echo $result['message'];
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

		<a href="signin.php">Signin</a>
	</body>
</html>

