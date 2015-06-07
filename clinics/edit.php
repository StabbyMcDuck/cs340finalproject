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

    <title>Edit Yarn</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/clinics/new.css" rel="stylesheet">

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
$clinic_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($clinic_id === null) {
    ?>
    <p>No clinic id given to edit!</p>
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
    "SELECT clinics.id, " .
    "clinics.location, " .
    "FROM clinics " .
    "WHERE clinics.id = ?"
))
) {
    error_log($connection->error);
    ?>
    <p>Try again later (1)</p>
    <?php
    exit;
}

if (!$statement->bind_param('i', $clinic_id)) {
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
$out_location = null;

if (!$statement->bind_result($out_id, $out_location)) {
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
            <h2 class="form-signin-heading">Edit Clinic</h2>
            <input type="hidden" name="id" value="<?php echo $out_id ?>">

            <label for="location" class="sr-only">Location</label>
            <input type="text" id="location" class="form-control" placeholder="Location" required autofocus
                   name="location" value="<?php echo $out_location ?>">

            <button class="btn btn-lg btn-primary btn-block" type="submit">Update Clinic</button>

            <p id="form-errors">

            </p>
        </form>
    </div> <!-- /container -->

<?php
}
?>
</body>
</html>