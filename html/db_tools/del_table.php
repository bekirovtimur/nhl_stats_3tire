<?php
include 'db_connect.php';
$query = "DROP TABLE `$table`;";
echo $query."<br>";
if (mysqli_query($connect, $query)) 
  {
    echo "Table ".$table." deleted";
  }
else 
  {
    echo "Error: " . mysqli_error($connect);
  }
?>
