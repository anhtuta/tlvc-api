<?php
class Database
{
  // specify your own database credentials
  private $host = "localhost";

  // local
  private $db_name = "wordpress";
  private $username = "root";
  private $password = "5555";

  // product
  // private $db_name = "xuongduc_ddyy";
  // private $username = "xuongduc_tuzaku";
  // private $password = "tzk@att1995";

  public $conn;

  // get the database connection
  public function getConnection()
  {

    $this->conn = null;

    try {
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }

    return $this->conn;
  }
}
