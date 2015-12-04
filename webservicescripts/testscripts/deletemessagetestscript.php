<?php
//Require the connection to the database to happen
require('../connection.php');

//Test variable used to test this script
$messageid = 7;

//Check if the posted data is not empty
if (isset($messageid)) {
  //Prepare the query to remove the speciic message from the database based on
  //the messageid
  $query = "DELETE FROM usertextmessage WHERE messageid = :messageid";
  //Update what :messageid should be
  $query_params = array(':messageid' => $messageid);
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
  //Create the data that will be the JSON response
  $response["success"] = 1;
  $response["message"] = "Message deleted successfully!";
  //Send the JSON response to the client
  header('Content-Type: application/json; charset=utf8');
  echo json_encode($response);
}
?>
