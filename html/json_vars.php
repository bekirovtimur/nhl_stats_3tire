<?php
include 'vars.php';
include 'db_connect.php';
//
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//
$input_data = json_decode(file_get_contents("php://input"), true);
$var_arr = array('season' => $season, 'playernationality' => $playernationality, 'resultlines' => $resultlines);
//
if ($_SERVER['REQUEST_METHOD'] === 'GET')
  {
    echo json_encode($var_arr);
  }
elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    if ($input_data == null)
      {
        echo json_encode(array("message" => "Input data incorrect"), JSON_UNESCAPED_UNICODE);
      }
    else
      {
        $season = $input_data['season'];
        $playernationality = $input_data['playernationality'];
        $resultlines = $input_data['resultlines'];
        $query =  '';
        if ($season)
        {
          //echo $season;
          $query .=  'UPDATE vars SET var_value="'.$season.'" WHERE var_name="season"; ';
        }
        if ($playernationality)
        {
          //echo $playernationality;
          $query .=  'UPDATE vars SET var_value="'.$playernationality.'" WHERE var_name="playernationality"; ';
        }
        if ($resultlines)
        {
          //echo $resultlines;
          $query .=  'UPDATE vars SET var_value="'.$resultlines.'" WHERE var_name="resultlines"; ';
        }

      $insert = mysqli_multi_query($connect, $query);
      echo json_encode(array("message" => "OK"), JSON_UNESCAPED_UNICODE);
      }
  }

//USAGE POST: curl -X POST -H "Content-Type: application/json" -d '{"season": "20212022", "playernationality": "RUS", "resultlines": "10"}' http://site.local/json_vars.php -s | jq
//USAGE GET: curl http://site.local/json_vars.php -s | jq

?>
