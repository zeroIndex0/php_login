<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Stuff</title>
</head>

<body>
  <?php session_start() ?>
  <?php echo "hello again"; ?>
  <form method="POST">
    <input type="submit" name="test" value="button">
  </form>
  <!-- This is no longer working, was just used as a test to check my db connection
  <?php if (isset($_POST["test"])) {
    include_once "api/read.php";
    echo $data_array[0]["name"];
  } ?> -->
</body>

</html>