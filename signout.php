<?php
	# Create a new session then destroy it and redirect them to the signin page
	session_start();
	
	session_destroy();
	
	exit(header('location: signin.php'));
	
?>
