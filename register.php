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

  $lastname = strip_tags($_POST["register_lastname"]);
  $lastname = str_replace(" ", "", $lastname);
  $lastname = ucfirst(strtolower($lastname));

  $email = strip_tags($_POST["register_email"]);
  $email = str_replace(" ", "", $email);

  $email2 = strip_tags($_POST["register_email2"]);
  $email2 = str_replace(" ", "", $email2);

  $password = strip_tags($_POST["register_password"]);

  $password2 = strip_tags($_POST["register_password2"]);

  $date = date("Y-m-d"); //The current date

  if ($email === $email2) {
    //check for email valid format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //if the check was a success, set the email to the validated version of the email
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);

      //check if email already exists.
      include_once "api/check_email.php";
      if($_SESSION["email_used"]){
        echo "Email is already in use";
      }

    } else {
      echo "Invalid Email Format";
    }
  } else {
    echo "Emails don't match";
    echo ": " . $email . " and " . $email2;
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
    <input type="text" name="register_firstname" placeholder="First Name" required>
    <br>
    <input type="text" name="register_lastname" placeholder="Last Name" required>
    <br>
    <input type="email" name="register_email" placeholder="Email" required>
    <br>
    <input type="email" name="register_email2" placeholder="Confirm Email" required>
    <br>
    <input type="password" name="register_password" placeholder="Password" required>
    <br>
    <input type="password" name="register_password2" placeholder="Confirm Password" required>
    <br>
    <input type="submit" name="register_button" value="Register">
  </form>

</body>

</html>