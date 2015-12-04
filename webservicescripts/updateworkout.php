<?php
//Require the connection to the database to happen
require('connection.php');

if (!empty($_POST)) {
  ////Check if any of the required fields are empty
  if (empty($_POST['userid']) || empty($_POST['workoutid'])) {
        //Create the data that will be the JSON response
        $response["success"] = 0;
        $response["message"] = "Not all fields were entered!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
    }
    else {
      //Update the user's workout info based on the user id
      $query = "UPDATE userworkout
                SET treadmillmiles = :treadmillmiles,
                    treadmillminutes = :treadmillminutes,
                    pushups = :pushups,
                    situps = :situps,
                    squats = :squats
                WHERE userid = :userid AND workoutid = :workoutid";
      //Update what the variables with ":" should be
      $query_params = array(':treadmillmiles' => $_POST['treadmillmiles'],
                            ':treadmillminutes' => $_POST['treadmillminutes'],
                            ':pushups' => $_POST['pushups'],
                            ':situps' => $_POST['situps'],
                            ':squats' => $_POST['squats'],
                            ':userid' => $_POST['userid'],
                            ':workoutid' => $_POST['workoutid']);
      //Run the query
      try {
        $statement = $db->prepare($query);
        $result = $statement->execute($query_params);
      }
      catch (PDOException $ex) {
        //Create the data that will be the JSON response
        $response["success"] = 0;
        $response["message"] = "Database query error#1!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
      }

      //Create the data that will be the JSON response
      $response["success"] = 1;
      $response["message"] = "Workout updated successfully!";
      //Send the JSON response to the client
      header('Content-Type: application/json charset=utf8');
      echo json_encode($response);
    }
}
?>
