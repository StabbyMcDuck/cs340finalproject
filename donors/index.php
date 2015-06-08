<?php
/**
 * Created by PhpStorm.
 * User: reginaimhoff
 * Date: 6/5/15
 * Time: 6:12 PM
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

    <title>Donors</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/navbar-fixed-top.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <script>
        // wait for the DOM to be loaded
        $(document).ready(function () {
            var options = {
                error: function (xhr, statusText, errorThrown) {
                    alert(xhr.responseJSON.message);
                },
                success: function (responseJSON, statusText, xhr, formElement) {
                    var tr = $('#donor-' + responseJSON.id);
                    // see http://stackoverflow.com/a/15604153
                    //change the background color to red before removing
                    tr.css("background-color", "#FF3700");
                    tr.fadeOut(400, function () {
                        tr.remove();
                    });
                    return false;
                }
            };
            $('form.delete').ajaxForm(options);
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
if (!($statement = $connection->prepare(
    "SELECT donors.id, " .
    "donors.first_name, " .
    "donors.last_name, " .
    "donors.dob " .
    "FROM donors"
))
) {
    error_log($connection->error);
    ?>
    <p>Try again later (1)</p>
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
?>

<div class="container">
    <table class="jumbotron table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="3">
                Donors
            </th>
            <th colspan="2">
                Actions
            </th>
        </tr>
        <tr>
            <th>Donor First Name</th>
            <th>Donor Last Name</th>
            <th>Donor Date of Birth</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($statement->fetch()) {
            ?>
            <tr id="donor-<?php echo $out_id ?>">
                <td>
                    <?php echo $out_first_name ?>
                </td>
                <td>
                    <?php echo $out_last_name ?>
                </td>
                <td>
                    <?php echo $out_dob ?>
                </td>
                <td>
                    <form action="edit.php" class="edit" method="get">
                        <input type="hidden" name="id" value="<?php echo $out_id ?>">
                        <button class="btn btn-sm" type="submit">Edit</button>
                    </form>
                </td>
                <td>
                    <form action="destroy.php" class="delete" method="post">
                        <input type="hidden" name="id" value="<?php echo $out_id ?>">
                        <button class="btn btn-sm" type="submit">Delete</button>
                    </form>
                </td>
            </tr>

        <?php
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3"></td>
            <td></td>
            <td><a href="new.php">Add</a></td>
        </tr>
        </tfoot>
    </table>
</div>
</body>
</html>