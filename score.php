
<?php
require_once ("globalSetup.php");

$dbh = new PDO(DBHOST . ';' . DBNAME, DBUSER, DBPASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Make sure the user is logged in if not redirect them
if (!$UserFunctions->loggedIn()) {
	header('Location: signin.php');
}

if( !isset($_POST['exam'])) {
	header('Location: selectExam.php');
}

$questionsStatement = $dbh->prepare('select count(*) from question where exam_name =?');
$questionsStatement->execute([$_POST['exam']]);
$numberOfQuestions = $questionsStatement->rowCount();


// Go through each of the questions and responses
for ($i = 1; $i <= $numberOfQuestions; $i++) {
	$selectStatement = $dbh->prepare('select answer, points from question where exam_name=? and question_number=?');
	$result = $selectStatement->execute([$_POST['exam'], $i]);
	$result = $selectStatement->fetch();
	$correctAnswer = $result['answer'];
	$insertStatement = $dbh->prepare("insert into answer values(?, ?, ?, ?, ?)");

	// If they didn't answer the question set the value for them
	if( !isset($_POST[$i]) ) {
		$_POST[$i] = "";
	}
	
	// Give them the correct number of points
	if ($_POST[$i] == $correctAnswer) {
		$result = $insertStatement->execute([$_POST['exam'], $i, $_SESSION['userid'], $_POST[$i], $result['points']]);
	}
	else {
		$result = $insertStatement->execute([$_POST['exam'], $i, $_SESSION['userid'], $_POST[$i], 0]);
	}
}

$totalScoreStatement = $dbh->prepare("SELECT SUM(score) FROM answer WHERE exam_name=? AND s_id=?");
$totalScoreStatement->execute([$_POST['exam'], $_SESSION['userid']]);
$result = $totalScoreStatement->fetch();
$insertStatement = $dbh->prepare("insert into takes values(?, ?, ?)");
$insertStatement->execute([$_SESSION['userid'], $_POST['exam'], $result['SUM(score)']]);
echo 'Your score was: ' . $result['SUM(score)'];

?>


<html>
  <body>
    <br/>
    <a href="selectExam.php">Select a new exam</a>
  </body>
</html>