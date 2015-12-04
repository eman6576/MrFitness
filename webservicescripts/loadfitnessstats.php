<?php
//Require the connection to the database to happen
require('connection.php');

if (!empty($_POST)) {
  //Get the user's fitnes stats based on their user id
  $query = "SELECT * FROM userfitnessstatus WHERE userid = :userid";
  //Update what :userid and :workoutid should be
  $query_params = array(':userid' => $_POST['userid']);
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
    $response['message'] = "Fitness Stats loaded!";
    $response['weight'] = $row['weight'];
    $response['heightfeet'] = $row['heightfeet'];
    $response['heightinches'] = $row['heightinches'];
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
  else {
    //Create the data that will be the JSON response
    $response['success'] = 0;
    $response['message'] = "Fitness stats does not exist!";
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
}
?>
