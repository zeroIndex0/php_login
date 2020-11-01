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

if (isset($_POST["register_button"])) {
  $firstname = strip_tags($_POST["register_firstname"]);
  $firstname = str_replace(" ", "", $firstname);
  $firstname = ucfirst(strtolower($firstname));
  $_SESSION["register_firstname"] = $firstname; // store modified input into a session variable
  echo "firstname session: " . $_SESSION["register_firstname"] . " "; //checking output of session variable

  $lastname = strip_tags($_POST["register_lastname"]);
  $lastname = str_replace(" ", "", $lastname);
  $lastname = ucfirst(strtolower($lastname));
  $_SESSION["register_lastname"] = $lastname; // store modified input into a session variable

  $email = strip_tags($_POST["register_email"]);
  $email = str_replace(" ", "", $email);
  $_SESSION["register_email"] = $email; // store modified input into a session variable

  $email2 = strip_tags($_POST["register_email2"]);
  $email2 = str_replace(" ", "", $email2);
  $_SESSION["register_email2"] = $email2; // store modified input into a session variable

  $password = strip_tags($_POST["register_password"]);

  $password2 = strip_tags($_POST["register_password2"]);

  $date = date("Y-m-d"); //The current date
  echo "The current date: " . $date . " ";

  if ($email === $email2) {
    //check for email valid format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //if the check was a success, set the email to the validated version of the email
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);

      //check if email already exists.
      include_once "api/check_email.php";
      if ($_SESSION["email_used"]) {
        echo "Email is already in use";
      }
    } else {
      echo "Invalid Email Format";
    }
  } else {
    echo "Emails don't match";
    echo ": " . $email . " and " . $email2;
  }

  if (strlen($firstname) > 25 || strlen($firstname) < 2) {
    echo "Your first name must be between 2 and 25 characters.";
  }

  if (strlen($lastname) > 25 || strlen($lastname) < 2) {
    echo "Your last name must be between 2 and 25 characters.";
  }

  if ($password !== $password2) {
    echo "Your passwords don't match";
  } else {
    if (preg_match('/[^A-Za-z0-9]/', $password)) {
      echo "Password can only contain letter a-z and/or numbers";
    }
  }

  if (strlen($password) > 30 || strlen($password) < 6) {
    echo "You password must be between 6 and 30 characters";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Kirby's Space</title>
</head>

<body>
  <form action="register.php" method="POST">
    <input type="text" name="register_firstname" placeholder="First Name" value="<?php
    if (isset($_SESSION["register_firstname"])) {
      echo $_SESSION["register_firstname"];
    }
    ?>" required>
    <br>
    <input type="text" name="register_lastname" placeholder="Last Name" value="<?php
    if (isset($_SESSION["register_lastname"])) {
      echo $_SESSION["register_lastname"];
    }
    ?>" required>
    <br>
    <input type="email" name="register_email" placeholder="Email" value="<?php
    if (isset($_SESSION["register_email"])) {
      echo $_SESSION["register_email"];
    }
    ?>" required>
    <br>
    <input type="email" name="register_email2" placeholder="Confirm Email" value="<?php
    if (isset($_SESSION["register_email2"])) {
      echo $_SESSION["register_email2"];
    }
    ?>" required>
    <br>
    <input type="password" name="register_password" placeholder="Password" required>
    <br>
    <input type="password" name="register_password2" placeholder="Confirm Password" required>
    <br>
    <input type="submit" name="register_button" value="Register">
  </form>

</body>

</html>