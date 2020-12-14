<?php
class Database
{
  
    // database credentials
    private $host = "localhost"; //SETUP - UPDATE THIS
    private $db_name = "urlshortner"; //SETUP - UPDATE THIS
    private $username = "root"; //SETUP - UPDATE THIS
    private $password = ""; //SETUP - UPDATE THIS
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