
<?php
require_once ("globalSetup.php");
echo '<link rel="stylesheet" href="score.css">';

$dbh = new PDO(DBHOST . ';' . DBNAME, DBUSER, DBPASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Make sure the user is logged in if not redirect them
if (!$UserFunctions->loggedIn()) {
	header('Location: signin.php');
}

if( !isset($_POST['exam'])) {
	header('Location: selectExam.php');
}
//echo var_dump($_POST);

$initialCheck = $dbh->prepare('select count(*) from takes where exam_name =? and s_id=?');
$initialCheck->execute([$_POST['exam'], $_SESSION['userid']]);
$hasTaken = $initialCheck->fetch();
$hasTaken = $hasTaken['count(*)'];  //used so that when user refreshes, score doesn't double

$questionsStatement = $dbh->prepare('select count(*) from question where exam_name =?');
$questionsStatement->execute([$_POST['exam']]);
$numberOfQuestions = $questionsStatement->fetch();
$numberOfQuestions = $numberOfQuestions['count(*)'];


echo "<div>";
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
		$outOf = $result['points'];
		if ($hasTaken == 0)
			$result = $insertStatement->execute([$_POST['exam'], $i, $_SESSION['userid'], $_POST[$i], $result['points']]);
		echo $i.'. Correct answer: '.$correctAnswer.'   Selected answer: '.$_POST[$i].'   Score: '.$outOf.' out of '.$outOf.'</br></br>';
	}
	else {
		$outOf = $result['points'];
		if ($hasTaken == 0)
			$result = $insertStatement->execute([$_POST['exam'], $i, $_SESSION['userid'], $_POST[$i], 0]);
		echo $i.'. Correct answer: '.$correctAnswer.'   Selected answer: '.$_POST[$i].'   Score: 0 out of '.$outOf.'</br></br>';
	}
}
//}

$totalScoreStatement = $dbh->prepare("SELECT SUM(score) FROM answer WHERE exam_name=? AND s_id=?");
$totalScoreStatement->execute([$_POST['exam'], $_SESSION['userid']]);
$result = $totalScoreStatement->fetch();
$insertStatement = $dbh->prepare("insert into takes values(?, ?, ?)");
if($hasTaken == 0)
	$insertStatement->execute([$_SESSION['userid'], $_POST['exam'], $result['SUM(score)']]);

echo "</br></br>";

echo 'Your score was: ' . $result['SUM(score)'];
echo "</div>";
?>


<html>
  <body>
    <br/>
    <a href="selectExam.php">Select a new exam</a>
  </body>
</html>
