<?php
//Require the connection to the database to happen
require('../connection.php');

//Test variables used to test this script
$userid = 5;

if (isset($userid)) {
  //Load all of the messages of the user based on their user id
  $query = "SELECT * FROM usertextmessage WHERE userid = :userid
            ORDER BY datesent DESC";
  //Update what :userid should be
  $query_params = array(':userid' => $userid);
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
    $response['message'] = "Messages loaded!";
    //Create an array to hold all of the messages
    $response['messages'] = array();
    //Loop through all the rows that were returned
    while ($row = $statement->fetch()) {
      //Have a temporatry array to store the message details
      $message = array();
      $message['messageid'] = $row['messageid'];
      $message['userid'] = $row['userid'];
      $message['senderid'] = $row['senderid'];
      $message['datesent'] = $row['datesent'];
      $message['messagetext'] = $row['messagetext'];
      //Push single message into response array
      header('Content-Type: application/json; charset=utf8');
      array_push($response['messages'], $message);
    }
    //Send the JSON response to the client

    echo json_encode($response);
  }
  else {
    //Create the data that will be the JSON response
    $response['success'] = 0;
    $response['message'] = "No messages found!";
    //Send the JSON response to the client
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($response);
  }
}
?>
