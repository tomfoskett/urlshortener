<?php
// include database and object files
include_once './App/Database.php';
include_once './App/ShortUrl.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

if (isset($_GET['url']) && $_GET['url'] != "") {
    //received a long url to convert and store

    //decode url and add http if needed
    $url = urldecode($_GET['url']);
    $url = strpos($url, 'http') !== 0 ? "http://{$url}" : $url;

    if (filter_var($url, FILTER_VALIDATE_URL)) {

        $short_url = new ShortUrl($db);
        $short_url->setLongUrl($url);

        $short_code = $short_url->getShortCode();

        echo "http://" . $_SERVER['HTTP_HOST'] . "/?r=" . $short_code;

    } else {
        die("$url is not a valid URL");
    }

} elseif(isset($_GET['r']) && $_GET['r']!="") { 
    //received a short code to redirect from

    //get shortcode
    $short_code =urldecode($_GET['r']);

    $short_url = new ShortUrl($db);
    $short_url->setShortCode($short_code);

    $redirect = $short_url->getLongUrl();

    //check whether url was returned - if yes redirect, if no display error
    if (filter_var($redirect, FILTER_VALIDATE_URL)) {
        header("location:".$redirect);
        exit;
    } else {
        echo $redirect;
    }
}
