<?php

//this was created to test my database connections.  It currently does nothing, really

//check for session
if (!isset($_SESSION)) session_start();

include_once "config/Database.php";
include_once "models/User.php";

//create DB object and connect to it
$database = new Database();
$db = $database->connectToDatabase();

$user = new User($db);

$result = $user->read();

$thing_to_extract = $result->fetch(PDO::FETCH_ASSOC);

extract($thing_to_extract);

$data_array = array();

$row_item = array(
  "id" => $id,
  "username" => $username
);
array_push($data_array, $row_item);