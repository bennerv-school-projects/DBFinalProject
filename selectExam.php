<?php
require_once ("globalSetup.php");

echo '<link rel="stylesheet" href="front.css">';

// Make sure the user is logged in
if (!$UserFunctions->loggedIn()) {
	header('Location: signin.php');
}

try {
	$dbh = new PDO(DBHOST . ';' . DBNAME, DBUSER, DBPASS);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo '<form action="fillExam.php" method="post">';
	echo 'Exam: <select name="exam">';
	foreach($dbh->query("select exam_name from exam") as $row) {
		echo '<option>' . $row[0] . '</option>';
	}

	echo '</select>';
	echo 'OK: <input type="submit" name="ok" value="Begin">';
	echo '</form>';
}

catch(PDOException $e) {
	print "Error!" . $e->getMessage() . "</br>";
	die();
}

?>