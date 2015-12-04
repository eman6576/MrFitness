<?php
//Require the connection to the database to happen
require('connection.php');

if (!empty($_POST)) {
  //Get the user's info based on their user id
  $query = "SELECT * FROM useraccount WHERE userid = :userid";
  //Update what :userid should be
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
    //Note that we do not need the columns that contain the user's user id and
    //user role since we have it in the session of the application on the client
    //side
    $response['success'] = 1;
    $response['message'] = "Account loaded!";
    $response['username'] = $row['username'];
    $response['password'] = $row['password'];
    $response['firstname'] = $row['firstname'];
    $response['lastname'] = $row['lastname'];
    $response['age'] = $row['age'];
    $response['trainerid'] = $row['trainerid'];
    $response['certificationnumber'] = $row['certificationnumber'];
    $response['insurancenumber'] = $row['insurancenumber'];
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
  else {
    //Create the data that will be the JSON response
    $response['success'] = 0;
    $response['message'] = "Account does not exist!";
    //Send the JSON response to the client
    header('Content-Type: application/json charset=utf8');
    echo json_encode($response);
  }
}
?>
