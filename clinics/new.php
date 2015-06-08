<?php
/**
 * Created by PhpStorm.
 * User: reginaimhoff
 * Date: 6/5/15
 * Time: 6:12 PM
 */

session_start();
if(!isset($_SESSION['id'])){
    //redirect them back to login page
    header("Location: ../session/new.php"); /* Redirect browser */
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>New Clinic</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/clinics/new.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <script>
        // wait for the DOM to be loaded
        $(document).ready(function() {
            var options = {
                error: function(xhr, statusText, errorThrown) {
                    $('#form-errors').html(xhr.responseJSON.message);
                },
                success: function(responseJSON, statusText, xhr, formElement) {
                    $(location).attr('href','index.php');
                }
            };
            $('#form').ajaxForm(options);
        });
    </script>
</head>

<body>
<?php

require '../navbar.php';

?>

<div class="container">

    <form action="create.php" class="form-signin" id="form" method="post">
        <h2 class="form-signin-heading">Add Clinic</h2>

        <label for="location" class="sr-only">Location</label>
        <input type="text" id="location" class="form-control" placeholder="location" required autofocus name="location">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Add Clinic</button>

        <p id="form-errors">

        </p>
    </form>
</div> <!-- /container -->



</body>
</html>