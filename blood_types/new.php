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

    <title>New Blood Type</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/blood_types/new.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://malsup.github.com/jquery.form.js"></script>

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
        <h2 class="form-signin-heading">Add Blood Type</h2>

        <fieldset>
            <legend>
                Blood Group
            </legend>
            <ul class="radio">
                <li>
                    <input type="radio" name="blood_group" id="blood-group-a" value="A"/>
                    <label for="blood-group-a">
                        A
                    </label>
                </li>
                <li>
                    <input type="radio" name="blood_group" id="blood-group-b" value="B"/>
                    <label for="blood-group-b">
                        B
                    </label>
                </li>
                <li>
                    <input type="radio" name="blood_group" id="blood-group-ab" value="AB"/>
                    <label for="blood-group-ab">
                        AB
                    </label>
                </li>
                <li>
                    <input type="radio" name="blood_group" id="blood-group-o" value="O"/>
                    <label for="blood-group-o">
                        O
                    </label>
                </li>
            </ul>
        </fieldset>

        <fieldset>
            <legend>
                Rh Factor
            </legend>
            <ul class="radio">
                <li>
                    <input type="radio" name="rh_factor" id="rh-factor-positive" value="Positive"/>
                    <label for="rh-factor-positive">
                        Positive
                    </label>
                </li>
                <li>
                    <input type="radio" name="rh_factor" id="rh-factor-negative" value="Negative"/>
                    <label for="rh-factor-negative">
                        Negative
                    </label>
                </li>
            </ul>
        </fieldset>

        <fieldset>
            <legend>Rare Antigen (not required)</legend>
            <label for="rare_antigen" class="sr-only">Rare Antigen</label>
            <input type="text" id="rare_antigen" class="form-control" placeholder="rare_antigen" autofocus name="rare_antigen">
        </fieldset>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Add Blood Type</button>

        <p id="form-errors">

        </p>
    </form>
</div> <!-- /container -->



</body>
</html>