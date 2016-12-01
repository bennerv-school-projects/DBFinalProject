<?php
try{
 $dbh = new PDO( 'mysql:host=classdb.it.mtu.edu;dbname=airline', "cs3425gr",
  echo '<form action="ok.php" method="post">';
    echo'ID: <input type= "text" name="id"/></br>';
    echo'Name: <input type= "text" name="name"/></br>';
    echo'Department: <input type= "text" name="department"/></br>';
    echo'Exam: <select name="exam">';
    foreach($dbh->query("select exam_name from exam") as $row)
      echo'<option>"'.$row'"</option>';
  echo'OK: <input type="submit" name="ok" value="Begin">';
  echo'</form>'
}
catch((PDOException $e) {
  print "Error!".$e->getMessage()."</br>";
  die();
}
?>
