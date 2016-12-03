<?php
try {
  require_once("globalSettup.php");
  $dbh = new PDO( DBHOST.';'.DBNAME, DBUSER, DBPASS);
  $dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $score =0;

  if ( $UserFunctions->!loggedIn() )
    header('Location: signing.php'); 
  
  for($i = 0; $i<$num; $i++)
   {
     $correct = dhb->query('select answer from question where exam_name="'.$_POST("exam").'" and question_number="'.$i.'"');
     if($_POST["$i"] == $correct)
       $points = dbh->query('select points from question where question_number="'.$i.'" and exam_name="'.$_POST("exam").'"');
     else
       $points = 0;
     dbh->query('insert into answer values("'.$_POST("exam").'", "'.$i.'", '.$_SESSION[userid].', '.$_POST[$i].', '.$points'"');
     $score += $points;
   }
   dbh->query('insert into takes values('.$_SESSION[userid].', "'.$_POST("exam").'", "'.$score.'');


?>
