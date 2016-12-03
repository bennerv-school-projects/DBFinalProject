<?php

require_once('UserFunctions.php');

$UserFunctions = new UserFunctions();

if( $UserFunctions->loggedIn() ) {
	header('Location: session_test.php');
}

if(isset($_POST['submitButton']) ) {
	$UserFunctions->signup($_POST['username'], $_POST['major'], $_POST['name'], $_POST['password']);
}


?>

<html>
	<body>
		
		<form action="" method="post">
			Name: <input type="text" name="name"/> <br/>
			Student Id: <input type="text" name="username"/> <br/>
			Password: <input type="password" name="password"/> <br/>
			Major: <input type="text" name="major"/>
			<input type="submit" name="submitButton" value="Log In"/>
		</form>
	</body>
</html>

