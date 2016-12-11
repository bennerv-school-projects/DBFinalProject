<?php
	# Starts the session associated with a user login and instantiates the UserFunctios object
	session_start();
	
	require_once 'UserFunctions.php';
	
	$UserFunctions = new UserFunctions;
?>
