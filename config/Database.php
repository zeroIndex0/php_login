<?php
class Database {
  private $host = "localhost";
  private $port = "3307";
  private $db_name = "social";
  private $username = "root";
  private $password = "";
  private $connection;

  public function connectToDatabase() {
    //first, flush the connection
    $this->connection = null;

    try {
      $this->connection = new PDO(
        "mysql:host=" . $this->host .
          ";port=" . $this->port .
          ";dbname=" . $this->db_name,
        $this->username,
        $this->password
      );

      // get the error information and throw an exception
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
      echo "Connection Error: " . $error->getMessage();
    }

    return $this->connection;
  }
}
