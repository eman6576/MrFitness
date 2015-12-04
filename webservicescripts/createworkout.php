<?php
//Require the connection to the database to happen
require('connection.php');

//Check if the posted data is not empty
if (!empty($_POST)) {
  //Check if any of the required fields are empty
  if (empty($_POST['userid'])) {
        //Create the data that will be the JSON response
        $response["success"] = 0;
        $response["message"] = "Not all fields were entered!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
  }
  else {
    //Insert the workout into the database
    $query = "INSERT INTO userworkout (userid, treadmillmiles, treadmillminutes,
              pushups, situps, squats) VALUES (:userid, :treadmillmiles,
              :treadmillminutes, :pushups, :situps, :squats)";
    //Update the tokens with the actually values
    $query_params = array(':userid' => $_POST['userid'],
                         ':treadmillmiles' => $_POST['treadmillmiles'],
                         ':treadmillminutes' => $_POST['treadmillminutes'],
                         ':pushups' => $_POST['pushups'],
                         ':situps' => $_POST['situps'],
                         ':squats' => $_POST['squats']);
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

    //Get the workout id of the workout that was just inserted
    $query = "SELECT MAX(workoutid) as workoutid FROM userworkout";
    //Run the query
    try {
      $statement = $db->prepare($query);
      $result = $statement->execute();
    }
    catch (PDOException $ex) {
      //Create the data that will be the JSON response
      $response["success"] = 0;
      $response["message"] = "Database query error#1!";
      //Kill the script and send the JSON response to the client
      header('Content-Type: application/json; charset=utf8');
      die(json_encode($response));
    }

    //Fetch the array of returned data and check if any rows were returned
    $row = $statement->fetch();
    if ($row) {
      //Create the data that will be the JSON response
      $response["success"] = 1;
      $response["message"] = "Workout has been added successfully!";
      //Get the work out id from the returned rows
      $response['workoutid'] = $row['workoutid'];
      //Send the JSON response to the client
      header('Content-Type: application/json; charset=utf8');
      echo json_encode($response);
    }
  }
}
?>
