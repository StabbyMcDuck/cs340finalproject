<?php
/**
 * Created by PhpStorm.
 * User: reginaimhoff
 * Date: 6/5/15
 * Time: 6:11 PM
 */

session_start();

if (!isset($_SESSION['id'])) {
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

    <title>Edit Blood Type</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/blood_types/new.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <script>
        // wait for the DOM to be loaded
        $(document).ready(function () {
            var options = {
                error: function (xhr, statusText, errorThrown) {
                    $('#form-errors').html(xhr.responseJSON.message);
                },
                success: function (responseJSON, statusText, xhr, formElement) {
                    $(location).attr('href', 'index.php');
                }
            };
            $('#form').ajaxForm(options);
        });
    </script>
</head>

<body>
<?php
$blood_type_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($blood_type_id === null) {
    ?>
    <p>No blood type id given to edit!</p>
    <?php
    exit;
}

include '../configuration.php';

// Create connection
$connection = new mysqli(
    $database_configuration['servername'],
    $database_configuration['username'],
    $database_configuration['password'],
    $database_configuration['database']
);

if (!($statement = $connection->prepare(
    "SELECT blood_types.id, " .
    "blood_types.blood_group, " .
    "blood_types.rh_factor, " .
    "blood_types.rare_antigen " .
    "FROM blood_types " .
    "WHERE blood_types.id = ?"
))
) {
    error_log($connection->error);
    ?>
    <p>Try again later (1)</p>
    <?php
    exit;
}

if (!$statement->bind_param('i', $blood_type_id)) {
    error_log($statement->error);
    ?>
    <p>Try again later (2)</p>
    <?php
    exit;
}


if (!$statement->execute()) {
    error_log($statement->error);
    ?>
    <p>Try again later (3)</p>
    <?php
    exit;
}

$out_id = null;
$out_blood_group = null;
$out_rh_factor = null;
$out_rare_antigen = null;

if (!$statement->bind_result($out_id, $out_blood_group, $out_rh_factor, $out_rare_antigen)) {
    error_log($statement->error);
    ?>
    <p>Try again later (4)</p>
    <?php
    exit;
}
while ($statement->fetch()) {
    ?>
    <div class="container">

        <form action="update.php" class="form-signin" id="form" method="post">
            <h2 class="form-signin-heading">Edit Blood Group</h2>
            <input type="hidden" name="id" value="<?php echo $out_id ?>">

            <label for="blood_group" class="sr-only">Blood Group</label>
            <input type="text" id="blood_group" class="form-control" placeholder="Blood Group" required autofocus
                   name="blood_group" value="<?php echo $out_blood_group ?>">

            <label for="rh_factor" class="sr-only">RH Factor</label>
            <input type="text" id="rh_factor" class="form-control" placeholder="RH Factor" required autofocus
                   name="rh_factor" value="<?php echo $out_rh_factor ?>">

            <label for="rare_antigen" class="sr-only">Rare Antigen</label>
            <input type="text" id="rare_antigen" class="form-control" placeholder="Rare Antigen" required autofocus
                   name="rare_antigen" value="<?php echo $out_rare_antigen ?>">


            <button class="btn btn-lg btn-primary btn-block" type="submit">Update Blood Group</button>

            <p id="form-errors">

            </p>
        </form>
    </div> <!-- /container -->

<?php
}
?>
</body>
</html>