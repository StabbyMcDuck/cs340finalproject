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

    <title>New Blood Bag</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/new.css" rel="stylesheet">

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

include '../configuration.php';
// Create connection
$connection = new mysqli(
    $database_configuration['servername'],
    $database_configuration['username'],
    $database_configuration['password'],
    $database_configuration['database']
);
?>

<div class="container">

    <form action="create.php" class="form-signin" id="form" method="post">
        <h2 class="form-signin-heading">Add Blood Bag</h2>

        <label for="collection_datetime" class="sr-only">Collection Date/Time</label>
        <input type="datetime-local" id="collection_datetime" class="form-control" placeholder="collection_datetime" required autofocus name="collection_datetime">

        <fieldset>
            <legend>Clinic</legend>
            <ul class="radio">
                <?php
                  if (!($clinic_statement = $connection->prepare(
                      "SELECT clinics.id, clinics.location FROM clinics ORDER BY clinics.location ASC"
                  ))) {
                      error_log($connection->error);
                      ?>
                      <p>Try again later (1)</p>
                      <?php
                      exit;
                  }

                  if (!$clinic_statement->execute()) {
                      error_log($clinic_statement->error);
                      ?>
                      <p>Try again later (2)</p>
                      <?php
                      exit;
                  }

                  $out_clinic_id = null;
                  $out_clinic_location = null;

                  if (!$clinic_statement->bind_result($out_clinic_id, $out_clinic_location)) {
                      error_log($clinic_statement->error);
                      ?>
                      <p>Try again later (3)</p>
                      <?php
                      exit;
                  }

                  while ($clinic_statement->fetch()) {
                      ?>
                      <li>
                          <input type="radio" name="fk_clinic_id" id="clinic-<?php echo $out_clinic_id ?>"
                                 value="<?php echo $out_clinic_id ?>"/>
                          <label for="clinic-<?php echo $out_clinic_id ?>">
                              <?php echo $out_clinic_location ?>
                          </label>
                      </li>
                  <?php
                  }
                ?>
            </ul>
        </fieldset>

        <fieldset>
            <legend>Nurse</legend>
            <ul class="radio">
                <?php
                if (!($nurse_statement = $connection->prepare(
                    "SELECT nurses.id, " .
                    "nurses.last_name, " .
                    "nurses.first_name " .
                    "FROM nurses " .
                    "ORDER BY nurses.last_name ASC, " .
                    "nurses.first_name ASC"
                ))) {
                    error_log($connection->error);
                    ?>
                    <p>Try again later (4)</p>
                    <?php
                    exit;
                }

                if (!$nurse_statement->execute()) {
                    error_log($nurse_statement->error);
                    ?>
                    <p>Try again later (5)</p>
                    <?php
                    exit;
                }

                $out_nurse_id = null;
                $out_nurse_last_name = null;
                $out_nurse_first_name = null;

                if (!$nurse_statement->bind_result($out_nurse_id, $out_nurse_last_name, $out_nurse_first_name)) {
                    error_log($nurse_statement->error);
                    ?>
                    <p>Try again later (6)</p>
                    <?php
                    exit;
                }

                while ($nurse_statement->fetch()) {
                    ?>
                    <li>
                        <input type="radio" name="fk_nurse_id" id="nurse-<?php echo $out_nurse_id ?>"
                               value="<?php echo $out_nurse_id ?>"/>
                        <label for="nurse-<?php echo $out_nurse_id ?>">
                            <?php echo $out_nurse_last_name ?>, <?php echo $out_nurse_first_name ?>
                        </label>
                    </li>
                <?php
                }
                ?>
            </ul>
        </fieldset>

        <fieldset>
            <legend>Donor</legend>
            <ul class="radio">
                <?php
                if (!($donor_statement = $connection->prepare(
                    "SELECT donors.id, " .
                    "donors.last_name, " .
                    "donors.first_name " .
                    "FROM donors " .
                    "ORDER BY donors.last_name ASC, " .
                    "donors.first_name ASC"
                ))) {
                    error_log($connection->error);
                    ?>
                    <p>Try again later (7)</p>
                    <?php
                    exit;
                }

                if (!$donor_statement->execute()) {
                    error_log($donor_statement->error);
                    ?>
                    <p>Try again later (8)</p>
                    <?php
                    exit;
                }

                $out_donor_id = null;
                $out_donor_last_name = null;
                $out_donor_first_name = null;

                if (!$donor_statement->bind_result($out_donor_id, $out_donor_last_name, $out_donor_first_name)) {
                    error_log($donor_statement->error);
                    ?>
                    <p>Try again later (9)</p>
                    <?php
                    exit;
                }

                while ($donor_statement->fetch()) {
                    ?>
                    <li>
                        <input type="radio" name="fk_donor_id" id="donor-<?php echo $out_donor_id ?>"
                               value="<?php echo $out_donor_id ?>"/>
                        <label for="donor-<?php echo $out_donor_id ?>">
                            <?php echo $out_donor_last_name ?>, <?php echo $out_donor_first_name ?>
                        </label>
                    </li>
                <?php
                }
                ?>
            </ul>
        </fieldset>

        <fieldset>
            <legend>Blood Type</legend>
            <ul class="radio">
                <?php
                if (!($blood_type_statement = $connection->prepare(
                    "SELECT blood_types.id, " .
                    "blood_types.blood_group, " .
                    "blood_types.rh_factor, " .
                    "blood_types.rare_antigen " .
                    "FROM blood_types " .
                    "ORDER BY blood_types.blood_group ASC, " .
                    "blood_types.rh_factor ASC, " .
                    "blood_types.rare_antigen ASC"
                ))) {
                    error_log($connection->error);
                    ?>
                    <p>Try again later (10)</p>
                    <?php
                    exit;
                }

                if (!$blood_type_statement->execute()) {
                    error_log($blood_type_statement->error);
                    ?>
                    <p>Try again later (11)</p>
                    <?php
                    exit;
                }

                $out_blood_type_id = null;
                $out_blood_type_blood_group = null;
                $out_blood_type_rh_factor = null;
                $out_blood_type_rare_antigen = null;

                if (!$blood_type_statement->bind_result($out_blood_type_id, $out_blood_type_blood_group, $out_blood_type_rh_factor, $out_blood_type_rare_antigen)) {
                    error_log($blood_type_statement->error);
                    ?>
                    <p>Try again later (9)</p>
                    <?php
                    exit;
                }

                while ($blood_type_statement->fetch()) {
                    ?>
                    <li>
                        <input type="radio" name="fk_blood_type_id" id="donor-<?php echo $out_blood_type_id ?>"
                               value="<?php echo $out_blood_type_id ?>"/>
                        <label for="donor-<?php echo $out_blood_type_id ?>">
                            <?php echo $out_blood_type_blood_group ?>, <?php echo $out_blood_type_rh_factor ?>, <?php echo $out_blood_type_rare_antigen ?>
                        </label>
                    </li>
                <?php
                }
                ?>
            </ul>
        </fieldset>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Add Blood Type</button>

        <p id="form-errors">

        </p>
    </form>
</div> <!-- /container -->



</body>
</html>