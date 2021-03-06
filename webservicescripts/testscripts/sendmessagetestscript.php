<?php
//Require the connection to the database to happen
require('../connection.php');

//Test variables used to test this script
$userid = 1;
$senderid = 5;
$messagetext = "An tomato is a fruit";

//Check if the posted data is not empty
if (isset($userid)) {
  //Check if any of the required fields are empty
  if (empty($userid) || empty($senderid) ||
      empty($messagetext)) {
        //Create the data that will be the JSON response
        $response["success"] = 0;
        $response["message"] = "Not all fields were entered!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
  }
  else {
    //Prepare to insert the new message into the Database
    $query = "INSERT INTO usertextmessage (userid, senderid, messagetext)
              VALUES (:userid, :senderid, :messagetext)";
    //Update the tokens with the actual data
    $query_params = array(':userid' => $userid,
                          ':senderid' => $senderid,
                          ':messagetext' => $messagetext);
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
    $response["message"] = "Message has been sent successfully!";
    //Send the JSON response to the client
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($response);
  }
}
?>
