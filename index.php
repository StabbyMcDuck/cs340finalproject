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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
<div class="container">
<h2>
    Blood Bank Inventory Database
</h2><br> <br>
<h3>
    By Regina Imhoff for CS 340 @ Oregon State University
</h3>
<p>
This project is a blood bank inventory.  It is designed to keep track of blood in stock in a blood bank, who it
came from (the donor), who drew the blood (the nurse), where it was drawn (the clinic), and the information that is
associated with the blood bag that is kept in frozen storage.  This is not a database for where the blood goes once it
leaves the blood bank.
</p>
<br>
<p>
This information is vital to the blood bank.  After the collection, a donor can ask for their blood to be destroyed,
    so you would need to know what bag came from what donor.  If a collection site's security or freezer storage is
    compromised, you would need to know what bags of blood came from which site.  In addition, if a nurse was not
    educated correctly and it turns out he was incorrectly drawing the blood, you would need to be able to go back
    through the database and be able to identify what bags he had drawn so they could be destroyed.
</p>
    <h3>
        To use this database:
    </h3>
    <p>Start with any table (located in header above) but be aware
    that the blood bag table will not be able to be filled in
    until the other tables are filled in.  </p>
    </div>
</body>
</html>