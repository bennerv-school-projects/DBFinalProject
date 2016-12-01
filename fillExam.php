<?php
  try {
    $dbh = new PDO( 'mysql:host=classdb.it.mtu.edu;dbname=airline', "cs3425gr",
    "cs3425gr");
    $dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    var_dump($_POST);
    echo "Welcome";
    echo $_POST["name"];
    if ($_POST["exam"] == "A")
      qs = select count(*) from Questions where exam="A";
    if ($_POST["exam"] == "B")
      qs = select count(*) from Questions where exam="B";
    if ($_POST["exam"] == "C")
      qs = select count(*) from Questions where exam="C";
    echo "<hr>";
    echo '<form name="exam">';
    for($i= 0; $i<qs; $i++)
    {
      $num = 'q' + i;
      //get q id somehow..
      $all = dbh->query("select * from Choice c join Question q on c.id=q.id");
      $choices = dbh->query("select count(*) from Choice c join Question q on c.exam_name=q.exam_name and c.question_number=q.question_number");
      $all = dbh->query("select * from Choice c join Question q on c.exam_name=q.exam_name and c.question_number=q.question_number");
      $row = $all->fetch_array(MYSQLI_NUM); 
      for($j = 0; j < $choices; $j++)
      {
        dbh->query("select * from Choice c join Question q on c.id=q.id");
        echo '<input id="a" type="radio" unchecked name="'.$num + $j.'">';
        echo '<label for ="'.$num +$j.'">'.$row[$j].'"</label><br>"'; 
      }  
       
      

?>

