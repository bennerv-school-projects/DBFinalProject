<?php
	require_once 'globalSetup.php';

	if(isset($_SESSION['userid'] )) {
		echo "HI ".$_SESSION['userid'];
	}
	
	if(isset($_SESSION['session'] )) {
		echo "Session id =". $_SESSION['session'];
	} else {
		echo "Not found";
	}

?>