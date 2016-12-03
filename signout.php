<?php

	session_start();
	
	session_destroy();
	
	exit(header('location: signin.php'));
	
?>
