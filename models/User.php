<?php
class User {
  private $table_name = "users";
  private $connection;

  public $id;
  public $first_name;
  public $last_name;
  public $username;
  public $email;
  public $password;
  public $signup_date;
  public $profile_pic;
  public $num_posts;
  public $num_likes;
  public $user_closed;
  public $friend_array;

  //constructor from a passed in Database object
  public function __construct($db) {
    $this->connection = $db;
  }

  public function read() {
    $query =
      "SELECT * FROM " .
      $this->table_name;

    //prepare statement
    $stmt = $this->connection->prepare($query);

    //execute
    try {
      $stmt->execute();
    } catch (PDOException $error) {
      echo "Connection Error: " . $error->getMessage();
    }
    return $stmt;
  }

  public function check_email() {
    $query =
      "SELECT email FROM " .
      $this->table_name .
      //nothing quite like spending 30 mitnues to find out the error was due to a not having a space before WHERE
      " WHERE email= :email";

    //prepare statement
    $stmt = $this->connection->prepare($query);

    $stmt->bindParam(":email", $this->email);

    echo "EMAIL PASED IN USER.php: " . $this->email . " ";

    try {
      $stmt->execute();
    } catch (PDOException $error) {
      echo "Connection Error On Check_Email: " . $error->getMessage();
    }
    return $stmt;
  }
}
