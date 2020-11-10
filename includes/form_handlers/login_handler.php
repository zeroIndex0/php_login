<?php

//check for session, if nothing start one
if (!isset($_SESSION)) session_start();

//normally I would add this in the api file ( in this case it would be api/login_user.php )
// but Im trying something a little different this time.  I don't know if i like it, but I don't mind
// trying different things when learning.
// I would start api/login_user.php looking for the set post button then create the needed values after
// making my conncetions to the database.
// This is kind of a pointless file in the sense that its only 4 lines of needed code that would be in api/login_user.php
// But i like trying to wrap my head around sectioning out code into different files and since im just playing here
// then, im okay with it for now.
if (isset($_POST["login_button"])) {
  $email = filter_var($_POST["login_email"], FILTER_SANITIZE_EMAIL);
  //using SESSION['login_email'] for a wrong entry when trying to login, it will keep the email listed
  $_SESSION["login_email"] = $email;

  $password = $_POST["login_password"];

  require_once "api/login_user.php";
}
