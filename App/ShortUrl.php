<?php
class ShortUrl
{

    // database connection and table name
    private $conn;
    private $table_name = "short_urls";

    // object properties
    protected $short_code;
    protected $long_url;

    //constructor
    function __construct($db)
    {
        $this->conn = $db;
    }

}