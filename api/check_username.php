<?php
//check for session
if (!isset($_SESSION)) session_start();

include_once "config/Database.php";
include_once "models/User.php";

//create DB object and connect to it
$database = new Database();
$db = $database->connectToDatabase();

$user = new User($db);

// echo "Pre setting username: " . $_SESSION["username"] . "<br>";

$user->username = $_SESSION["username"];
// print out the username
// echo "This is the USERNAME IN check_username.php: " . $_SESSION["username"] . "<br>";

$result = $user->check_username();

$rows = $result->rowCount();
// echo "Row count: " . $rows . "<br>";

if($rows > 0) {
  $_SESSION["username_used"] = true;
} else {
  $_SESSION["username_used"] = false;
}