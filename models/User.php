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
  //variables that arent currently being used
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

    // echo "EMAIL PASED IN USER.php: " . $this->email . " ";

    try {
      $stmt->execute();
    } catch (PDOException $error) {
      echo "Connection Error On Check_Email: " . $error->getMessage();
    }
    return $stmt;
  }

  public function check_username() {
    $query =
      "SELECT username FROM " .
      $this->table_name .
      //nothing quite like spending 30 mitnues to find out the error was due to a not having a space before WHERE
      " WHERE username= :username";

    //prepare statement
    $stmt = $this->connection->prepare($query);

    $stmt->bindParam(":username", $this->username);

    try {
      $stmt->execute();
    } catch (PDOException $error) {
      echo "Connection Error On Check_Username: " . $error->getMessage();
    }
    return $stmt;
  }

  public function add_user() {
    $query =
      "INSERT INTO " .
      $this->table_name .
      " VALUES( '', :first_name, :last_name, :username, :email, :password, :signup_date, " .
      ":profile_pic, :num_posts, :num_likes, :user_closed, :friend_array)";

    //prepare statement
    $stmt = $this->connection->prepare($query);

    $stmt->bindParam(":first_name", $this->first_name);
    $stmt->bindParam(":last_name", $this->last_name);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":signup_date", $this->signup_date);
    //variables that aren't currently being used, so they are just placeholder values for now, created in api/add_user.php
    $stmt->bindParam(":profile_pic", $this->profile_pic);
    $stmt->bindParam(":num_posts", $this->num_posts);
    $stmt->bindParam(":num_likes", $this->num_likes);
    $stmt->bindParam(":user_closed", $this->user_closed);
    $stmt->bindParam(":friend_array", $this->friend_array);

    try {
      $stmt->execute();
    } catch (PDOException $error) {
      echo "Connection Error On Check_Username: " . $error->getMessage();
    }
    return $stmt;
  }

  public function login_user() {
    $query = 
    "SELECT * FROM " . 
    $this->table_name . 
    " WHERE email = :email AND password = :password";

    $stmt = $this->connection->prepare($query);

    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);

    try {
      $stmt->execute();
    } catch (PDOException $error) {
      echo "Connection Error On Login_User: " . $error->getMessage();
    }
    return $stmt;
  }
}
