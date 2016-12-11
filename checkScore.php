
<?php
require_once ("globalSetup.php");
echo '<link rel="stylesheet" href="score.css">';

$dbh = new PDO(DBHOST . ';' . DBNAME, DBUSER, DBPASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Make sure the user is logged in if not redirect them
if (!$UserFunctions->loggedIn()) {
	header('Location: signin.php');
}

if( !isset($_SESSION['exam'])) {
	header('Location: selectExam.php');
}

$_POST['exam'] = $_SESSION['exam'];

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
	$points = $result['points'];	

	$selectStatement = $dbh->prepare('select choice, score from answer where exam_name=? and s_id=?');
	$result = $selectStatement->execute([$_POST['exam'], $_SESSION['userid']]);
	$selectedAnswer = $result['choice'];
	$score = $result['score'];
	// If they didn't answer the question set the value for them
	if( !isset($_POST[$i]) ) {
		$_POST[$i] = "";
	}
		echo $i.'. Correct answer: '.$correctAnswer.'   Selected answer: '.$selectedAnswer.'   Score: '.$score.' out of '.$points.'</br></br>';
	}

$totalScoreStatement = $dbh->prepare("SELECT student_score FROM takes WHERE exam_name=? AND s_id=?");
$totalScoreStatement->execute([$_POST['exam'], $_SESSION['userid']]);
$result = $totalScoreStatement->fetch();

echo "</br></br>";

echo 'Your score was: ' . $result['student_score'];
echo "</div>";
?>


<html>
  <body>
    <br/>
    <a href="selectExam.php">Select a new exam</a>
  </body>
</html>
