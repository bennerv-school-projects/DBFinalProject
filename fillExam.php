<?php
  require_once("globalSetup.php");

  /*if (!$UserFunctions->loggedIn() )
    header('Location: signing.php');
 */
  try {
    //include config file
   $dbh = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $questionStuff = $dbh->query('select count(*) from question where exam_name='.$_POST["exam"].'');
    $qs= $questionStuff->fetch();
    echo $qs[0];
    echo "<hr>";
    echo '<form action="varDump.php" method="post">';
    echo '<input type="hidden" name="exam" value='.$_POST["exam"].'>';
    for($i= 1; $i<=$qs[0]; $i++)
    {
      $set_contents = $dbh->query('select question_contents from question where exam_name='.$_POST["exam"].' and question_number='.$i.'');
      $q_contents = $set_contents->fetch();
      echo $q_contents[0]."</br>";
      foreach($dbh->query('select id, choice_contents from choice where exam_name='.$_POST["exam"].' and question_number='.$i.' order by id') as $row)
      {
        echo '<input type="radio" name='.$i.' value='.$row[0].'>';
        echo '<label for ="'.$i.'">'.$row[0] .". ".$row[1].'</label><br>'; 
      }
      echo "</br>";
    }
     echo'<input type="submit" name="ok" value="Submit">';
   }  
  catch (PDOException $e) 
  {
    print"Error".$e->getMessage()."<br>";
    die();
  }     
      

?>

