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

</body>

</html>