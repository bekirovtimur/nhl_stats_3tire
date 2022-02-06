<?php
include 'vars.php';
include 'db_connect.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$table = 'scores';
$sql = "SELECT * FROM `$table` LIMIT 1;";
if (mysqli_query($connect, $sql))
  {
  }
else
  {
    die ("Error: " . mysqli_error($connect));
  }
$query = "SELECT `player_id`,`fullName`,`jerseyNumber`,`currentTeam_id`,`currentTeam_name`,SUM(`goals`) FROM `scores` WHERE `nationality`=\"$playernationality\" GROUP BY `player_id`,`fullName`,`jerseyNumber`,`currentTeam_id`,`currentTeam_name` ORDER BY SUM(`goals`) DESC LIMIT $resultlines;";
$result = mysqli_query($connect,$query);
//
$current_season_query = mysqli_query($connect,"SELECT `season` FROM `games` LIMIT 1;");
$current_season = mysqli_fetch_array($current_season_query)[0];
$start_year = mb_substr($current_season, 0, 4);
$end_year = mb_substr($current_season, 4, 4);

if ($current_season!=$season)
  {
  die ("Season changed. Please update `games` and `scores` tables");
  }

if ($result == 0)
  {
  die ("No result found");
  }

$dbdata = array();
while ( $row = mysqli_fetch_assoc($result) )
  {
  $dbdata[]=$row;
  }

$var_arr = array('season' => $season, 'playernationality' => $playernationality, 'resultlines' => $resultlines, 'topplayers' => $dbdata);

echo json_encode($var_arr);

?>
