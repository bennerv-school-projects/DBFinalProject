<?php
  require_once("globalSetup.php");

  if ( $UserFunctions->!loggedIn() )
    header('Location: signing.php');
 
  try {
    //include config file
    $dbh = new PDO( DBHOST.';'.DBNAME, DBUSER, DBPASS);
    $dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


 
    echo "Welcome";
    echo $_POST["name"];
    $qs = dbh->query('select count(*) from Questions where exam=$_Post("exam")');
    echo "<hr>";
    echo '<form action="score.php" method="post">';
    for($i= 0; $i<qs; $i++)
    {
      $a = 'a';
      $q_contents = dbh->query('select question_contents from question where exam="'.$_Post("exam").'and question_number="'.$i.'"');
      echo $q_contents;
      foreach(dbh->query('select choice_contents from Choice where exam="'.$_Post("exam").'" and question_number="'.$i'"') as $row)
      {
        dbh->query("select * from Choice c join Question q on c.id=q.id");
        echo '<input type="radio" name="'.$i.'" value="'.$a.'">';
        echo '<label for ="'.$i + $a.'">'.$a .+"."+.$row[$0].'"</label><br>"'; 
        $a++;
      }
    }
     echo'<input type="submit" name="ok" value="Submit">';
   }  
  catch (PDOException $e) 
  {
    print"Error".$e->getMessage()."<br>";
    die();
  }     
      

?>

