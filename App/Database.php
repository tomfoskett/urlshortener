<?php
class Database
{
  
    // database credentials
    private $host = "localhost";
    private $db_name = "urlshortner";
    private $username = "root";
    private $password = "";
    public $conn;
  
    // get the database connection
    public function getConnection(){

        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
          } else {
            return $this->conn;
          }

    }
}
?>