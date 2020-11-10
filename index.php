<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Stuff</title>
</head>

<body>
  <?php if (!isset($_SESSION)) session_start(); ?>
  <?php echo "hello again <br>"; ?>
  <?php echo "You are logged in as: " . $_SESSION["username"] . ".  Welcome! <br>"; ?>

  
  <form method="POST">
    <input type="submit" name="test" value="button">
  </form>
  <!-- Added mock data into the database, just using as a test to check my db connection -->
  <?php if (isset($_POST["test"])) {
    include_once "api/read.php";
    echo "Id: " . $data_array[0]["id"];
    echo "<br>";
    echo "Username: " . $data_array[0]["username"];
  } ?>
</body>

</html>