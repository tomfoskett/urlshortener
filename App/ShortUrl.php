<?php
class ShortUrl
{

    // database connection
    private $conn;

    // object properties
    protected $short_code;
    protected $long_url;

    //constructor
    function __construct($db)
    {
        $this->conn = $db;
    }

    //set long url
    function setLongUrl($url)
    {
        $this->long_url = $url;
    }

    //set short code
    function setShortCode($short_code)
    {
        $this->short_code = $short_code;
    }

    //get the short code, using one from the db if it exists or making one otherwise
    function getShortCode()
    {
        if ($this->long_url != null) {
            $query = "SELECT short_code FROM short_urls WHERE long_url = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $this->long_url);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0) {

                    //code exists in database - get it
                    while ($data = $result->fetch_assoc()) {
                        $short_code = $data['short_code'];
                    }

                    $this->setShortCode($short_code);
                    return $this->short_code;

                } else {

                    //code does not exist in database - make one
                    $query = "SELECT id FROM short_urls WHERE short_code = ?";
                    $stmt = $this->conn->prepare($query);
                    $is_unique = false;

                    while ($is_unique == false) {

                        //create a random shortcode
                        $short_code = substr(md5(uniqid(rand(), true)), 0, 9);

                        //check that it doesn't already exist
                        $stmt->bind_param("s", $short_code);
                        if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            if ($result->num_rows == 0) {
                                $is_unique = true;
                            }
                        }
                    }

                    $stmt->close();

                    //store shortcode in db
                    $query = "INSERT INTO short_urls (short_code, long_url) VALUES (?, ?)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("ss", $short_code, $this->long_url);

                    //return stored shortcode
                    if ($stmt->execute()) {
                        $this->setShortCode($short_code);
                        return $this->short_code;
                    } else {
                        return "Error: " . $stmt->error();
                    }
                    $stmt->close();
                }

            } else {

                return "Error: " . $stmt->error;
                $stmt->close();
            }
        }
    }

    //get the long url from the database
    function getLongUrl()
    {
        if ($this->short_code != null) {

            //get long url from database
            $query = "SELECT long_url FROM short_urls WHERE short_code = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $this->short_code);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0) {

                    //shortcode exists in database - return long url
                    while ($data = $result->fetch_assoc()) {
                        $long_url = $data['long_url'];
                    }
                    $this->setLongUrl($long_url);
                    return $this->long_url;

                } else {

                    //shortcode not found - return error message
                    return "Shortcode not found in database";
                    
                }
            } else {
                return "Error: " . $stmt->error();
            }
        }
    }
}
