<?php

require_once('UserFunctions.php');

$UserFunctions = new UserFunctions();

if( $UserFunctions->loggedIn() ) {
	header('Location: session_test.php');
}

if(isset($_POST['submitButton']) ) {
	var_dump($_POST);
	echo "logging in";
	$UserFunctions->login($_POST['username'], $_POST['password']);
} else {
	var_dump($_POST);
}


?>

<html>
	<body>
		
		<form action="" method="post">
			Name: <input type="text" name="name"/> <br/>
			Student Id: <input type="text" name="username"/> <br/>
			Password: <input type="password" name="pasword"/> <br/>
			Major: <input type="text" name="major"/>
			<input type="submit" name="submitButton" value="Log In"/>
		</form>
	</body>
</html>

