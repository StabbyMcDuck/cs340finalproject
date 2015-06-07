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

    <title>New Blood Types</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/blood_types/new.css" rel="stylesheet">

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

<div class="container">

    <form action="create.php" class="form-signin" id="form" method="post">
        <h2 class="form-signin-heading">Add Blood Type</h2>

        <label for="blood_group" class="sr-only">Blood Group</label>
        <input type="radio" id="blood_group" class="form-control" placeholder="blood_group" required autofocus name="blood_group">

        <label for="rh_factor" class="sr-only">RH Factor</label>
        <input type="radio" id="rh_factor" class="form-control" placeholder="rh_factor" required autofocus name="rh_factor">

        <label for="rare_antigen" class="sr-only">Rare Antigen</label>
        <input type="text" id="rare_antigen" class="form-control" placeholder="rare_antigen" required autofocus name="rare_antigen">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Add Blood Type</button>

        <p id="form-errors">

        </p>
    </form>
</div> <!-- /container -->



</body>
</html>