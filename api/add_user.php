<?php
//check for session
if (!isset($_SESSION)) session_start();

include_once "config/Database.php";
include_once "models/User.php";

//create DB object and connect to it
$database = new Database();
$db = $database->connectToDatabase();

$user = new User($db);

$user->first_name   = $_POST["register_firstname"];
$user->last_name    = $_POST["register_lastname"];
$user->username     = $_SESSION["username"];
$user->email        = $_POST["register_email"];
$user->password     = $_SESSION["password"];
$user->signup_date  = $_SESSION["date"];
// extra vars ignoring for now and adding placeholder values;
$user->profile_pic  = "";
$user->num_posts    = 0;
$user->num_likes    = 0;
$user->user_closed  = "no";
$user->friend_array = ',';


$result = $user->add_user();