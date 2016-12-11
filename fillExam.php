<?php
  require_once("globalSetup.php");
  echo '<link rel="stylesheet" href="exam.css">';
	# Make sure the user is logged in
	
	if (!$UserFunctions->loggedIn() or !isset($_SESSION['exam'])) {
		header('Location: signin.php');
	}
	$_POST['exam'] = $_SESSION['exam'];
	
	try {
		$dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		$questionStatement = $dbh->prepare('select count(*) from question where exam_name=?');
		$questionStatement->execute([
			$_POST['exam']
		]);
		
		$numberOfQuestions = $questionStatement->fetch();
		$numberOfQuestions = $numberOfQuestions['count(*)'];
		echo "<hr>";
		echo '<form action="score.php" method="post">';
		echo '<input type="hidden" name="exam" value='.$_POST["exam"].'>';
		for($i= 1; $i <= $numberOfQuestions; $i++)
		{				
			# Print out the question contents and teh question number
			$set_contents = $dbh->prepare('select question_contents from question where exam_name=? and question_number=?');
			$set_contents->execute([
				$_POST['exam'],
				$i
			]);
			$q_contents = $set_contents->fetch();
			echo $q_contents[0]."</br>";
			
			$choice_statement = $dbh->prepare('SELECT id, choice_contents FROM choice WHERE exam_name=? AND question_number=?');
			$choice_statement->execute([
				$_POST['exam'],
				$i
			]);		
			$data = $choice_statement->fetchAll();
			
			# Print out all the question choices
			foreach($data as $row)
			{
				echo '<input type="radio" name='.$i.' value='.$row[0].'>';
				echo '<label for ="'.$i.'">'.$row[0] .". ".$row[1].'</label><br>'; 
			}
			echo "</br>";
		}
			echo'<input type="submit" name="ok" value="Submit">';
			echo "</br>";
	}  
	catch (PDOException $e) 
	{
		print"Error".$e->getMessage()."<br>";
		die();
	}     	
?>

<html>
	<body>
		<br/>
		<a href="signout.php">Sign out</a>
	</body>
</html>

