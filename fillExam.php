<?php
  try {
    //include config file
    $dbh = new PDO( DBHOST.';'.DBNAME, DBUSER, DBPASS);
    $dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    echo "Welcome";
    echo $_POST["name"];
    $qs = select count(*) from Questions where exam=$_Post("exam");
    echo "<hr>";
    echo '<form name="exam">';
    for($i= 0; $i<qs; $i++)
    {
      $a = 'a';
      $num = 'q' + i;
      //get q id somehow..
      $choice_count = dbh->query('select count(*) from Choice where exam="'.$_Post("exam").'" and question_number="'.$i'")';
      $all_choice = dbh->query('select * from Choice where exam="'.$_Post("exam").'" and question_number="'.$i'")';
      $row = $all->fetch_array(MYSQLI_NUM); 
      for($j = 0; j < $choices; $j++)
      {
        dbh->query("select * from Choice c join Question q on c.id=q.id");
        echo '<input id="a" type="radio" unchecked name="'.$num + $j.'">';
        echo '<label for ="'.$num +$j.'">'.$row[$j].'"</label><br>"'; 
      }
     }
   }  
  catch (PDOException $e) 
  {
    print"Error".$e->getMessage()."<br>";
    die();
  }     
      

?>

