<?php
//Require the connection to the database to happen
require('connection.php');

if (!empty($_POST)) {
  //Check if the username the user entered already exists in the database
  $query = "SELECT * FROM useraccount WHERE username = :username";
  //Update what :username should be
  $query_params = array(':username' => $_POST['username']);
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
    $response['success'] = 0;
    $response['message'] = "The username is already taken!";
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
  else {
    //Create the data that will be the JSON response
    $response['success'] = 1;
    $response['message'] = "The username is avaliable!";
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
}
?>
