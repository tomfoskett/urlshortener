<?php
// include database and object files
include_once '../App/Database.php';
include_once '../App/ShortUrl.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();