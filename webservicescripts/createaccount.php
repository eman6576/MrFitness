<?php
//Require the connection to the database to happen
require('connection.php');

//Check if the posted data is not empty
if (!empty($_POST)) {
    //Check if any of the required fields are empty
    if (empty($_POST['username']) || empty($_POST['password']) ||
        empty($_POST['firstname']) || empty($_POST['lastname']) ||
        empty($_POST['age']) || empty($_POST['reasonforuse'])) {
      //Create the data that will be the JSON response
      $response["success"] = 0;
      $response["message"] = "Not all fields were entered!";
      //Kill the script and send the JSON response to the client
      header('Content-Type: application/json; charset=utf8');
      die(json_encode($response));
    }
    else {
      //Check if the username already exists in the database
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
        $response["success"] = 0;
        $response["message"] = "Database query error#1!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
      }

      //Fetch the array of returned data and check if any rows were returned
      $row = $statement->fetch();
      if ($row) {
        //Create the data that will be the JSON response
        $response["success"] = 0;
        $response["message"] = "The username is already taken!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
      }
      else {
        //We can insert the new user into the database
        $query = "INSERT INTO useraccount (username, password, firstname, lastname,
                  age, reasonforuse, trainerid, certificationnumber, insurancenumber)
                  VALUES (:username, :password, :firstname, :lastname, :age, :reasonforuse,
                  :trainerid, :certificationnumber, :insurancenumber)";
        //Update the tokens with the actual data
        $query_params = array(':username' => $_POST['username'],
                              ':password' => $_POST['password'],
                              ':firstname' => $_POST['firstname'],
                              ':lastname' => $_POST['lastname'],
                              ':age' => $_POST['age'],
                              ':reasonforuse' => $_POST['reasonforuse'],
                              ':trainerid' => $_POST['trainerid'],
                              ':certificationnumber' => $_POST['certificationnumber'],
                              ':insurancenumber' => $_POST['insurancenumber']);
        //Run the query
        try {
          $statement = $db->prepare($query);
          $result = $statement->execute($query_params);
        }
        catch (PDOException $ex) {
          //Create the data that will be the JSON response
          $response["success"] = 0;
          $response["message"] = "The username is already taken!";
          //Kill the script and send the JSON response to the client
          header('Content-Type: application/json; charset=utf8');
          die(json_encode($response));
        }

        //Get the user id of the workout that was just inserted
        $query = "SELECT MAX(userid) as userid FROM useraccount";
        //Run the query
        try {
          $statement = $db->prepare($query);
          $result = $statement->execute();
        }
        catch (PDOException $ex) {
          //Create the data that will be the JSON response
          $response["success"] = 0;
          $response["message"] = "Database query error#1!";
          //Kill the script and send the JSON response to the client
          header('Content-Type: application/json; charset=utf8');
          die(json_encode($response));
        }
        //Fetch the array of returned data and check if any rows were returned
        $row = $statement->fetch();
        if($row) {
          //Insert into the userfitnessstatus table
          $query = "INSERT INTO userfitnessstatus (userid, weight, heightfeet,
                    heightinches) VALUES (:userid, :weight,
                    :heightfeet, :heightinches)";
          $weight = 0;
          $heightfeet = 0;
          $heightinches = 0;
          //Update the tokens with the actual data
          $query_params = array(':userid' => $row['userid'],
                                ':weight' => $weight,
                                ':heightfeet' => $heightfeet,
                                ':heightinches' => $heightinches);
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
        $response["message"] = "Account has been created successfully!";
        //Send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($response);
      }
    }
  }
}
?>
