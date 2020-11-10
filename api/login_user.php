<?php
//check for session
if (!isset($_SESSION)) session_start();

include_once "config/Database.php";
include_once "models/User.php";

//create DB object and connect to it
$database = new Database();
$db = $database->connectToDatabase();

$user = new User($db);

// $email and $password 's values are set in and passed in from 'includes/form_handlers/login_handler.php'
// Which happens to also be calling this file ( just trying something new );
$user->email = $email;
$user->password = $password;


$result = $user->login_user();

$rows = $result->rowCount();

if($rows == 1) {
  //on a valid entry, set the username to what was pulled from the database
  $data = $result->fetch(PDO::FETCH_ASSOC);
  $username = $data["username"];
  $_SESSION["username"] = $username;
  header("Location: index.php");
  exit();
} else {
  echo "You entered something in wrong";
}



?>