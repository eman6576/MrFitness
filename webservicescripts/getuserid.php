<?php
//Require the connection to the database to happen
require('connection.php');

//Check if the posted data is not empty
if (!empty($_POST)) {
  //Get the user's info based on their username
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
    $response = array('success' => 0,
                      'message' => "Database query error#1");
    //Kill the script and send the JSON response to the client
    header('Content-Type: application/json; charset=utf8');
    die(json_encode($response));
  }

  //Fetch the array of returned data and check if any rows were returned
  $row = $statement->fetch();
  if ($row) {
    //Create the data that will be the JSON response
    $response["success"] = 1;
    $response["message"] = "UserID found!";
    $response["userid"] = $row["userid"];
    $response["userrole"] = $row["reasonforuse"];
    $response["trainerid"] = $row['trainerid'];

    //Send the JSON response to the client
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($response);
  }
}
 ?>
