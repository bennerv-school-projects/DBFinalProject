
<?php
require_once ("globalSettup.php");

$dbh = new PDO(DBHOST . ';' . DBNAME, DBUSER, DBPASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Make sure the user is logged in if not redirect them
if (!$UserFunctions->loggedIn()) {
	header('Location: signin.php');
}

$questionsStatement = dbh->prepare('select count(*) from question');
$questionsStatement->execute();
$numberOfQuestions = $questionsStatement->rowCount();

// Go through each of the questions and responses
for ($i = 0; $i < $numberOfQuestions; $i++) {
	$selectStatement = dbh->prepare('select answer, points from question where exam_name=? and question_number=?');
	$result = dbh->execute([$_POST['exam'], $i]);
	$result = $result->fetch();
	$correctAnswer = $result['answer'];
	$insertStatement = dbh->prepare("insert into answer values(?, ?, ?, ?, ?");

	// Give them the correct number of points
	if ($_POST[(string)$i] == $correctAnswer) {
		$result = dbh->execute([$_POST['exam'], $i, $_SESSION['userid'], '?', $result['points']]);
	}
	else {
		$result = dbh->execute([$_POST['exam'], $i, $_SESSION['userid'], '?', 0]);
	}
}

$totalScoreStatement = dbh->prepare("SELECT SUM(points) FROM answer WHERE exam_name=?");
$result = $totalScoreStatement->execute([$_POST['exam']]);
$result->fetch();
$insertStatement = dbh->prepare("insert into takes values(?, ?, ?)");
$insertStatement->execute([$_SESSION['userid'], $_POST['exam'], $result['SUM(points)']]);
echo 'Your score was: ' . $result['SUM(points)'];

?>


<html>
  <body>
    <br/>
    <a href="selectExam.php">Select a new exam</a>
  </body>
</html>