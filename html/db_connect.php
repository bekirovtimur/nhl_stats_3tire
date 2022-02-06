<?php
include 'db_conf.php';
$check_conn = mysqli_connect($db_server, $db_username, $db_password);
if ($check_conn !== false)
  {
    $check_query = "USE $db_name";
    if (mysqli_query($check_conn, $check_query))
      {
        $connect = mysqli_connect($db_server, $db_username, $db_password, $db_name);
      }
    else
      {
        echo json_encode(array("message" => "Error while connecting to $db_name database"), JSON_UNESCAPED_UNICODE);
        exit();
      }
//    if (!$connect)
//      {
//        //die("Error: " . mysqli_connect_error());
//      }
  }
else
  {
    echo json_encode(array("message" => "Error while connecting to DB server"), JSON_UNESCAPED_UNICODE);
    exit();
  }
?>
