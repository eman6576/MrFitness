<?php
//Require the connection to the database to happen
require('../connection.php');

//Test variable to test this script
$trainerid = 5;

//Check if the posted data is not empty
if (isset($trainerid)) {
  $query = "SELECT * FROM useraccount WHERE trainerid = :trainerid";
  //Update what :trainerid should be
  $query_params = array(':trainerid' => $trainerid);
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
  if ($result) {
    //Create the data that will be the JSON response
    $response['success'] = 1;
    $response['message'] = "Clients loaded!";
    //Create an array to hold all of the messages
    $response['clients'] = array();
    //Loop through all the rows that were returned
    while ($row = $statement->fetch()) {
      //Have a temporatry array to store the client details
      $client = array();
      $client['firstname'] = $row['firstname'];
      $client['lastname'] = $row['lastname'];
      $client['userid'] = $row['userid'];
      //Push single message into response array
      array_push($response['clients'], $client);
    }
    //Send the JSON response to the client
    echo json_encode($response);
  }
  else {
    //Create the data that will be the JSON response
    $response['success'] = 0;
    $response['message'] = "No clients found!";
    //Send the JSON response to the client
    echo json_encode($response);
  }
}
?>
