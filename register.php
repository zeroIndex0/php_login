<?php
//check for session, if nothing start one
if (!isset($_SESSION)) session_start();

require "includes/form_handlers/register_handler.php";
require "includes/form_handlers/login_handler.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>

<body>

  <!-- Login -->
  <form action="register.php" method="POST">
    <input type="email" name="login_email" placeholder="Email Address">
    <br>
    <input type="password" name="login_password" placeholder="Password">
    <br>
    <input type="submit" name="login_button" value="Login">
  </form>

  <br>

  <!-- Register -->
  <form action="register.php" method="POST">

    <!-- first name -->
    <input type="text" name="register_firstname" placeholder="First Name" value="
<?php
if (isset($_SESSION["register_firstname"])) {
  echo $_SESSION["register_firstname"];
}
?>" required>
    <br>
    <?php if (in_array("Your first name must be between 2 and 25 characters.<br>", $error_array)) echo "Your first name must be between 2 and 25 characters.<br>"; ?>

    <!-- last name -->
    <input type="text" name="register_lastname" placeholder="Last Name" value="
<?php
if (isset($_SESSION["register_lastname"])) {
  echo $_SESSION["register_lastname"];
}
?>" required>
    <br>
    <?php if (in_array("Your last name must be between 2 and 25 characters.<br>", $error_array)) echo "Your last name must be between 2 and 25 characters.<br>"; ?>

    <!-- email -->
    <input type="email" name="register_email" placeholder="Email" value="
    <?php
    if (isset($_SESSION["register_email"])) {
      echo $_SESSION["register_email"];
    }
    ?>" required>
    <br>

    <!-- verify email -->
    <input type="email" name="register_email2" placeholder="Confirm Email" value="
    <?php
    if (isset($_SESSION["register_email2"])) {
      echo $_SESSION["register_email2"];
    }
    ?>" required>
    <br>
    <?php if (in_array("Email is already in use<br>", $error_array)) {
      echo "Email is already in use<br>";
    } else if (in_array("Invalid Email Format<br>", $error_array)) {
      echo "Invalid Email Format<br>";
    } else if (in_array("Emails don't match<br>", $error_array)) {
      echo "Emails don't match<br>";
    } ?>

    <!-- password -->
    <input type="password" name="register_password" placeholder="Password" required>
    <br>

    <!-- verify password -->
    <input type="password" name="register_password2" placeholder="Confirm Password" required>
    <br>
    <?php if (in_array("You password must be between 6 and 30 characters<br>", $error_array)) {
      echo "You password must be between 6 and 30 characters<br>";
    } else if (in_array("Password can only contain letter a-z and/or numbers<br>", $error_array)) {
      echo "Password can only contain letter a-z and/or numbers<br>";
    } else if (in_array("Your passwords don't match<br>", $error_array)) {
      echo "Your passwords don't match<br>";
    } ?>

    <!-- submit button -->
    <input type="submit" name="register_button" value="Register">
  </form>

</body>

</html>