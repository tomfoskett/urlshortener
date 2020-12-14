<?php
// include database and object files
include_once './App/Database.php';
include_once './App/ShortUrl.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

if (isset($_GET['url']) && $_GET['url'] != "") {

    //decode url and add http if needed
    $url = urldecode($_GET['url']);
    $url = strpos($url, 'http') !== 0 ? "http://{$url}" : $url;

    if (filter_var($url, FILTER_VALIDATE_URL)) {

        $short_url = new ShortUrl($db);
        $short_url->setUrl($url);

        echo $short_url->getUrl();

    } else {
        die("$url is not a valid URL");
    }
}
