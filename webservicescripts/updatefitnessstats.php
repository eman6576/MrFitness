<?php
//Require the connection to the database to happen
require('connection.php');

if (!empty($_POST)) {
  ////Check if any of the required fields are empty
  if (empty($_POST['userid'])) {
        //Create the data that will be the JSON response
        $response["success"] = 0;
        $response["message"] = "Not all fields were entered!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
    }
    else {
      //Update the user's workout info based on the user id
      $query = "UPDATE userfitnessstatus
                SET weight = :weight,
                    heightfeet = :heightfeet,
                    heightinches = :heightinches
                WHERE userid = :userid";
      //Update what the variables with ":" should be
      $query_params = array(':weight' => $_POST['weight'],
                            ':heightfeet' => $_POST['heightfeet'],
                            ':heightinches' => $_POST['heightinches'],
                            ':userid' => $_POST['userid']);
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
      $response["message"] = "Fitness stats updated successfully!";
      //Send the JSON response to the client
      header('Content-Type: application/json charset=utf8');
      echo json_encode($response);
    }
}
?>
