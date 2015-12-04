<?php
//Require the connection to the database to happen
require('connection.php');

if (!empty($_POST)) {
  ////Check if any of the required fields are empty
  if (empty($_POST['username']) || empty($_POST['password']) ||
      empty($_POST['firstname']) || empty($_POST['lastname']) ||
      empty($_POST['age'])) {
        //Create the data that will be the JSON response
        $response["success"] = 0;
        $response["message"] = "Not all fields were entered!";
        //Kill the script and send the JSON response to the client
        header('Content-Type: application/json; charset=utf8');
        die(json_encode($response));
    }
    else {
      //Update the user's info based on the user id
      $query = "UPDATE useraccount
                SET username = :username,
                    password = :password,
                    firstname = :firstname,
                    lastname = :lastname,
                    age = :age,
                    certificationnumber = :certificationnumber,
                    insurancenumber = :insurancenumber
                WHERE userid = :userid";
      //Update what the variables with ":" should be
      $query_params = array(':username' => $_POST['username'],
                            ':password' => $_POST['password'],
                            ':firstname' => $_POST['firstname'],
                            ':lastname' => $_POST['lastname'],
                            ':age' => $_POST['age'],
                            ':certificationnumber' => $_POST['certificationnumber'],
                            ':insurancenumber' => $_POST['insurancenumber'],
                            ':userid' => $_POST['userid']);
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
      $response["message"] = "Account updated successfully!";
      //Send the JSON response to the client
      header('Content-Type: application/json charset=utf8');
      echo json_encode($response);
    }
}
?>
