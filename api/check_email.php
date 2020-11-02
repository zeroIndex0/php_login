<?php
//check for session
if (!isset($_SESSION)) session_start();

include_once "config/Database.php";
include_once "models/User.php";

//create DB object and connect to it
$database = new Database();
$db = $database->connectToDatabase();

$user = new User($db);

$user->email = $_POST["register_email"];
// echo "THIS IS THE EMAIL: " . $_POST["register_email"] . " ";

$result = $user->check_email();

$rows = $result->rowCount();

if($rows > 0) {
  $_SESSION["email_used"] = true;
} else {
  $_SESSION["email_used"] = false;
}