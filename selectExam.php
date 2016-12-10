<?php
require_once ("globalSetup.php");

echo '<link rel="stylesheet" href="front.css">';

// Make sure the user is logged in
if (!$UserFunctions->loggedIn()) {
	header('Location: signin.php');
}

// Make sure the student cannot take an exam more than once
if( isset($_POST['exam'])) {
	$dbh = new PDO(DBHOST . ';' . DBNAME, DBUSER, DBPASS);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$statement = $dbh->prepare("SELECT * FROM takes WHERE s_id=? AND exam_name=?");
	$statement->execute([$_SESSION['userid'], $_POST['exam']]);
	
	if( $statement->rowCount() != 0 ) { 
		$result = $statement->fetch();
		echo '<b> You have already taken this exam and got ' . $result['student_score'] . ' points.</b>';
	} else {
		$_SESSION['exam'] = $_POST['exam'];
		header('location: fillExam.php');
	}
}

try {
	$dbh = new PDO(DBHOST . ';' . DBNAME, DBUSER, DBPASS);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo '<form action="" method="post">';
	echo 'Exam: <select name="exam">';
	
	// Print out all the selectable exams
	$statement = $dbh->prepare("SELECT exam_name FROM exam");
	$statement->execute();
	$contents = $statement->fetchAll();
	
	foreach( $contents as $row ) {
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

<html>
	<body>
		<br/>
		<a href="signout.php">Sign out</a>
	</body>
</html>