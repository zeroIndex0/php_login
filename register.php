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

//add htmlspecialcharacters to the strip tags
if (isset($_POST["register_button"])) {
  $firstname = strip_tags($_POST["register_firstname"]);
  $firstname = str_replace(" ", "", $firstname);
  $firstname = ucfirst(strtolower($firstname));
  $_SESSION["register_firstname"] = $firstname; // store modified input into a session variable

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
    echo ": " . $email . " and " . $email2;
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
    echo "ADDING USER: " . $_SESSION["username"] . "<br>";
    include_once "api/add_user.php";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>

<body>
  <form action="register.php" method="POST">
    <!-- first name -->
    <input type="text" name="register_firstname" placeholder="First Name" value="<?php
                                                                                  if (isset($_SESSION["register_firstname"])) {
                                                                                    echo $_SESSION["register_firstname"];
                                                                                  }
                                                                                  ?>" required>
    <br>
    <?php if (in_array("Your first name must be between 2 and 25 characters.<br>", $error_array)) echo "Your first name must be between 2 and 25 characters.<br>"; ?>

    <!-- last name -->
    <input type="text" name="register_lastname" placeholder="Last Name" value="<?php
                                                                                if (isset($_SESSION["register_lastname"])) {
                                                                                  echo $_SESSION["register_lastname"];
                                                                                }
                                                                                ?>" required>
    <br>
    <?php if (in_array("Your last name must be between 2 and 25 characters.<br>", $error_array)) echo "Your last name must be between 2 and 25 characters.<br>"; ?>

    <!-- email -->
    <input type="email" name="register_email" placeholder="Email" value="<?php
                                                                          if (isset($_SESSION["register_email"])) {
                                                                            echo $_SESSION["register_email"];
                                                                          }
                                                                          ?>" required>
    <br>

    <!-- verify email -->
    <input type="email" name="register_email2" placeholder="Confirm Email" value="<?php
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