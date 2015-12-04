<?php
//Declare the variables needed to connect to the database
$host = "localhost";
$dbname = "eguerre4";
$username = "eguerre4";
$password = "pizza6576";

//Tell the MySQL server that we will communicate with UTF-8
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

//Open a connection to the database using the PDO library
try {
  $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;",
                $username, $password, $options);
}
catch (PDOException $ex) {
  //If an error occurs opening a connection to the database
  die("Connection to database failed: " . $ex->getMessage());
}

//Configures PDO to throw exceptions when an error occurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Configures PDO to return dayabase rows from the database using an associative
//array
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//This is used to undo magic quotes
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
  function undo_magic_quotes_gpc(&$array) {
    foreach ($array as &$value) {
      if (is_array($value)) {
        undo_magic_quotes_gpc($value);
      }
      else {
        $value = stripslashes($value);
      }
    }
  }

  undo_magic_quotes_gpc($_POST);
  undo_magic_quotes_gpc($_GET);
  undo_magic_quotes_gpc($_COOKIE);
}
//session_start();
 ?>
