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
    <link href="../css/donors/new.css" rel="stylesheet">

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
$donor_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($donor_id === null) {
    ?>
    <p>No donor id given to edit!</p>
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
    "SELECT donors.id, " .
    "donors.first_name, " .
    "donors.last_name, " .
    "donors.dob " .
    "FROM donors " .
    "WHERE donors.id = ?"
))
) {
    error_log($connection->error);
    ?>
    <p>Try again later (1)</p>
    <?php
    exit;
}

if (!$statement->bind_param('i', $donor_id)) {
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
$out_first_name = null;
$out_last_name = null;
$out_dob = null;

if (!$statement->bind_result($out_id, $out_first_name, $out_last_name, $out_dob)) {
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
            <h2 class="form-signin-heading">Edit Donor</h2>
            <input type="hidden" name="id" value="<?php echo $out_id ?>">

            <label for="first_name" class="sr-only">First Name</label>
            <input type="text" id="first_name" class="form-control" placeholder="First Name" required autofocus
                   name="first_name" value="<?php echo $out_first_name ?>">

            <label for="last_name" class="sr-only">Last Name</label>
            <input type="text" id="last_name" class="form-control" placeholder="Last Name" required autofocus
                   name="last_name" value="<?php echo $out_last_name ?>">

            <label for="dob" class="sr-only">Date of Birth</label>
            <input type="date" id="dob" class="form-control" placeholder="Date of Birth" required autofocus
                   name="dob" value="<?php echo $out_dob ?>">

            <button class="btn btn-lg btn-primary btn-block" type="submit">Update Donor</button>

            <p id="form-errors">

            </p>
        </form>
    </div> <!-- /container -->

<?php
}
?>
</body>
</html>