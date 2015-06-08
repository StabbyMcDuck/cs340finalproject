<?php

/**
 * Created by PhpStorm.
 * User: Regina Imhoff
 * Date: 5/28/15
 * Time: 2:56 PM
 */


// turns on error reporting
error_reporting(E_ALL);
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "imhoffr-db", "kSPLM3ed144rC1dd", "imhoffr-db");

// test connection
if($mysqli->connect_errno){
    echo "Connection error" . $mysqli->connect_errno . " " .  $mysqli->connect_error;
}
?>

<! DOCTYPE html >

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<?php

require 'navbar.php'

?>
</body>
</html>