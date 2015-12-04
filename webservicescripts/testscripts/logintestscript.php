<?php
//Require the connection to the database to happen
require('../connection.php');

//Test variables used to test this script
$username = "test1";
$password = "demodemo";

//Check if the posted data is not empty
if (isset($username)) {
  //Get the user's info based on their username
  $query = "SELECT * FROM useraccount WHERE username = :username";
  //Update what :username should be
  $query_params = array(':username' => $username);
  //Run the query
  try {
    $statement = $db->prepare($query);
    $result = $statement->execute($query_params);
  }
  catch (PDOException $ex) {
    //Create the data that will be the JSON response
    $response = array('success' => 0,
                      'message' => "Datebase query error#1!");
    //Kill the script and send the JSON response to the client
    header('Content-Type: application/json; charset=utf8');
    die(json_encode($response));
  }

  //Fetch the array of returned data and check if any rows were returned
  $row = $statement->fetch();
  if ($row) {
    //Check if the password entered is the same as the password in the database
    if ($password == $row['password']) {
      //Create the data that will be the JSON response
      $response = array('success' => 1,
                        'message' => "Login successful!");
      //Send the JSON response to the client
      header('Content-Type: application/json; charset=utf8');
      die(json_encode($response));
    }
    else {
      //Create the data that will be the JSON response
      $response = array('success' => 0,
                        'message' => "Invalid Credentials");
      //Send the JSON response to the client
      header('Content-Type: application/json; charset=utf8');
      die(json_encode($response));
    }
  }
}
 ?>
