<?php
include 'vars.php';
include 'db_connect.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//
if ($_SERVER['REQUEST_METHOD'] === 'GET')
  {
    $table = 'scores';
    $sql = "SELECT * FROM `$table` LIMIT 1;";
    if (mysqli_query($connect, $sql))
      {
        //
      }
    else
      {
        $errmsg = mysqli_error($connect);
        echo json_encode(array("message" => $errmsg), JSON_UNESCAPED_UNICODE);
        exit();
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
        echo json_encode(array("message" => "Season changed. Please update `games` and `scores` tables"), JSON_UNESCAPED_UNICODE);
        exit();
      }

    if ($result == 0)
      {
        echo json_encode(array("message" => "No result found"), JSON_UNESCAPED_UNICODE);
        exit();
      }

    $dbdata = array();
    while ( $row = mysqli_fetch_assoc($result) )
      {
        $dbdata[]=$row;
      }

    $var_arr = array('season' => $season, 'playernationality' => $playernationality, 'resultlines' => $resultlines, 'topplayers' => $dbdata);
    echo json_encode($var_arr);
  }
else
  {
    echo json_encode(array("message" => "Only GET allowed"), JSON_UNESCAPED_UNICODE);
    exit();
  }
?>
