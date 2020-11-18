<?php
//check for session, if nothing start one
if (!isset($_SESSION)) session_start();

//variables for the register form
$firstname = "";
$lastname  = "";
$email     = "";
$email2    = "";
$password  = "";
$password2 = "";
$date      = "";
$error_array = array();


if (isset($_POST["register_button"])) {
  $firstname = htmlspecialchars(strip_tags($_POST["register_firstname"]));
  $firstname = str_replace(" ", "", $firstname);
  $firstname = ucfirst(strtolower($firstname));
  $_SESSION["register_firstname"] = $firstname; // store modified input into a session variable

  $lastname = htmlspecialchars(strip_tags($_POST["register_lastname"]));
  $lastname = str_replace(" ", "", $lastname);
  $lastname = ucfirst(strtolower($lastname));
  $_SESSION["register_lastname"] = $lastname; // store modified input into a session variable

  $email = htmlspecialchars(strip_tags($_POST["register_email"]));
  $email = str_replace(" ", "", $email);
  $_SESSION["register_email"] = $email; // store modified input into a session variable

  $email2 = htmlspecialchars(strip_tags($_POST["register_email2"]));
  $email2 = str_replace(" ", "", $email2);
  $_SESSION["register_email2"] = $email2; // store modified input into a session variable

  $password = htmlspecialchars(strip_tags($_POST["register_password"]));

  $password2 = htmlspecialchars(strip_tags($_POST["register_password2"]));

  $date = date("Y-m-d"); //The current date
  

  if ($email === $email2) {
    //check for email valid format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //if the check was a success, set the email to the validated version of the email
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);

      //check if email already exists.
      include_once "api/check_email.php";
      if ($_SESSION["email_used"]) {
        array_push($error_array, "Email is already in use<br>");
      }
    } else {
      array_push($error_array, "Invalid Email Format<br>");
    }
  } else {
    array_push($error_array, "Emails don't match<br>");
  }

  if (strlen($firstname) > 25 || strlen($firstname) < 2) {
    array_push($error_array, "Your first name must be between 2 and 25 characters.<br>");
  }

  if (strlen($lastname) > 25 || strlen($lastname) < 2) {
    array_push($error_array, "Your last name must be between 2 and 25 characters.<br>");
  }

  if ($password !== $password2) {
    array_push($error_array, "Your passwords don't match<br>");
  } else {
    if (preg_match('/[^A-Za-z0-9]/', $password)) {
      array_push($error_array, "Password can only contain letter a-z and/or numbers<br>");
    }
  }

  if (strlen($password) > 30 || strlen($password) < 6) {
    array_push($error_array, "You password must be between 6 and 30 characters<br>");
  }
}

//if the error_array is empty, then all checks have passed.
if (empty($error_array)) {
  //not enough, but for this purpose its plenty
  // $password = hash('SHA512', $password);
  $_SESSION["password"] = $password;
  $_SESSION["date"] = $date;
  //firstname and lastname are init as "" along with the error_array being init as empty.
  //so this makes sure it doesn't run the check on load.
  //basically, if all the values are default, then don't run the username check.
  if ($firstname != "" && $lastname != "") {
    $username = strtolower($firstname . "_" . $lastname);
    $_SESSION["username"] = $username;
    require "api/check_username.php";
    $i = 1;
    //This keeps checking for a username that doesnt exist by adding _(i) to the end
    //until it finds a username that's not in the database
    while ($_SESSION["username_used"]) {
      //This is an auto assigned username, for now
      $_SESSION["username"] = $username . "_" . $i;
      require "api/check_username.php";
      $i++;
    }
    //we made all the checks, insert the user into the database.
    //INsert all data into database, kthxbye
    include_once "api/add_user.php";
    header("Location: index.php");
  }
  //unset to clear out the form after a successful entry
  //now that I redirect, im curious if i need to unset just to clear out the form since I wont see it anymore
  //I suppose the real question is: Is a header the same as a return therefore making this line of code unreachable
  //logic would say this is unreachable, but scripting langauges can be werid
  unset($_SESSION["register_firstname"], $_SESSION["register_lastname"], $_SESSION["register_email"], $_SESSION["register_email2"]);
}

?>