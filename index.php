<?php

/**
 * Created by PhpStorm.
 * User: Regina Imhoff
 * Date: 5/28/15
 * Time: 2:56 PM
 */

session_start();
if(!isset($_SESSION['id'])){
    //redirect them back to login page
    header("Location: session/new.php"); /* Redirect browser */
    exit();
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
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Blood Bank</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="blood_bags/index.php">Blood Bags</a></li>
                <li><a href="blood_types/index.php">Blood Types</a></li>
                <li><a href="clinics/index.php">Clinics</a></li>
                <li><a href="donors/index.php">Donors</a></li>
                <li><a href="nurses/index.php">Nurses</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="session/destroy.php">Logout</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
</body>
</html>