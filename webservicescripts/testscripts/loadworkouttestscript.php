<?php
//Require the connection to the database to happen
require('../connection.php');

//Test varibales used to test this script
$userid = 1;
$workoutid = 2;

if (isset($userid)) {
  //Get the user's info based on their user id
  $query = "SELECT * FROM userworkout WHERE userid = :userid AND workoutid =
           :workoutid";
  //Update what :userid and :workoutid should be
  $query_params = array(':userid' => $userid,
                        ':workoutid' => $workoutid);
  //Run the query
  try {
    $statement = $db->prepare($query);
    $result = $statement->execute($query_params);
  }
  catch (PDOException $ex) {
    //Create the data that will be the JSON response
    $response['success'] = 0;
    $response['message'] = "Database query error#1!";
    //Kill the script and send the JSON response to the client
    header('Content-Type: application/json; charset=utf8');
    die(json_encode($response));
  }

  //Fetch the array of returned data and check if any rows were returned
  $row = $statement->fetch();
  if ($row) {
    //Create the data that will be the JSON response
    $response['success'] = 1;
    $response['message'] = "Workout loaded!";
    $response['workoutid'] = $row['workoutid'];
    $response['treadmillmiles'] = $row['treadmillmiles'];
    $response['treadmillminutes'] = $row['treadmillminutes'];
    $response['pushups'] = $row['pushups'];
    $response['situps'] = $row['situps'];
    $response['squats'] = $row['squats'];
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
  else {
    //Create the data that will be the JSON response
    $response['success'] = 0;
    $response['message'] = "Workout does not exist!";
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
}
?>
