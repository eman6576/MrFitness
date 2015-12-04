<?php
//Require the connection to the database to happen
require('connection.php');

if (!empty($_POST)) {
  //Check to see if the user's account exists
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
    //Check if the user has any messages in the usertextmessage table
    $query = "SELECT * FROM usertextmessage WHERE userid = :userid";
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
      //Delete all the messages in the textmessagetable based on the userid
      $query = "DELETE FROM usertextmessage WHERE userid = :userid";
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
    }

    //Check if the user has any workouts in the userworkout table
    $query = "SELECT * FROM userworkout WHERE userid = :userid";
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
      //Delete all the workouts in the userworkout based on the userid
      $query = "DELETE FROM userworkout WHERE userid = :userid";
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
    }

    //Check if the user has any fitness stats in the userfitnessstatus table
    $query = "SELECT * FROM userfitnessstatus WHERE userid = :userid";
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
      //Delete all the fitness stats in the userfitnessstatus based on the userid
      $query = "DELETE FROM userfitnessstatus WHERE userid = :userid";
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
    }

    //Delete the user's account from the database
    $query = "DELETE FROM useraccount WHERE userid = :userid";
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
    //Create the data that will be the JSON response
    $response["success"] = 1;
    $response["message"] = "Account deleted successfully!";
    //Send the JSON response to the client
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($response);

  }
  else {
      //Create the data that will be the JSON response
      $response["success"] = 0;
      $response["message"] = "User's account does not exist!";
      //Send the JSON response to the client
      header('Content-Type: application/json; charset=utf8');
      echo json_encode($response);
  }
}
?>
