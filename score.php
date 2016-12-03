<?php
try {
  //include config file
  $dbh = new PDO( dbhost.';'.dbname, dbuser, dbpass);
  $dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $score =0;
  for($i = 0; $i<$num; $i++)
   {
     $correct = dhb->query('select answer from question where exam_name="'.$_POST("exam").'" and question_number="'.$i.'"');
     if($_POST["$i"] == $correct){
       $point = dbh->query('select points from question where   
     printf("<a href=\"mailto:wics@mtu.edu\">Contact</a>");
   }
 }else{
    echo "Would you like to switch to CS Department? <br/>";
  }

?>
