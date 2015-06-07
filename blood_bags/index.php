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
                    var tr = $('#blood-bag-' + responseJSON.id);
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
<!-- Fixed navbar -->
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
            <a class="navbar-brand" href="#">Blood Bags List</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="new.php">Add Blood Bag</a></li>
                <li><a href="../session/destroy.php">Logout</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>

<?php
include '../configuration.php';
// Create connection
$connection = new mysqli(
    $database_configuration['servername'],
    $database_configuration['username'],
    $database_configuration['password'],
    $database_configuration['database']
);
if (!($statement = $connection->prepare(
    "SELECT blood_bags.id, " .
    "blood_bags.collection_datetime, " .
    "clinics.id, " .
    "clinics.location, " .
    "nurses.id, " .
    "nurses.first_name, " .
    "nurses.last_name, " .
    "donors.id, " .
    "donors.first_name, " .
    "donors.last_name, " .
    "blood_types.id, " .
    "blood_types.blood_group, " .
    "blood_types.rh_factor, " .
    "blood_types.rare_antigen " .
    "FROM blood_bags " .
    "INNER JOIN clinics " .
    "ON clinics.id = blood_bags.FK_clinic_id " .
    "INNER JOIN nurses " .
    "ON nurses.id = blood_bags.FK_nurse_id " .
    "INNER JOIN donors " .
    "ON donors.id = blood_bags.FK_donor_id " .
    "INNER JOIN blood_types " .
    "ON blood_types.id = blood_bags.FK_blood_type_id "
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
$out_blood_bags_id = null;
$out_blood_bags_collection_datetime = null;
$out_clinics_id = null;
$out_clinics_location = null;
$out_nurses_id = null;
$out_nurses_first_name = null;
$out_nurses_last_name = null;
$out_donors_id = null;
$out_donors_first_name = null;
$out_donors_last_name = null;
$out_blood_types_id = null;
$out_blood_types_blood_group = null;
$out_blood_types_rh_factor = null;
$out_blood_types_rare_antigen = null;

if (!$statement->bind_result(
    $out_blood_bags_id,
    $out_blood_bags_collection_datetime,
    $out_clinics_id,
    $out_clinics_location,
    $out_nurses_id,
    $out_nurses_first_name,
    $out_nurses_last_name,
    $out_donors_id,
    $out_donors_first_name,
    $out_donors_last_name,
    $out_blood_types_id,
    $out_blood_types_blood_group,
    $out_blood_types_rh_factor,
    $out_blood_types_rare_antigen)){
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
            <th colspan="1">
                Blood Bags
            </th>
            <th colspan="1">
                Clinic
            </th>
            <th colspan="2">
                Nurse
            </th>
            <th colspan="2">
                Donor
            </th>
            <th colspan="3">
                Blood Type
            </th>
            <th colspan="2">
                Actions
            </th>
        </tr>
        <tr>
            <th>Collection Date/Time</th>
            <th>Location</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Blood Group</th>
            <th>RH Factor</th>
            <th>Rare Antigen'/</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($statement->fetch()) {
            ?>
            <tr id="donor-<?php echo $out_blood_bags_id ?>">
                <td>
                    <?php echo $out_blood_bags_collection_datetime ?>
                </td>
                <td>
                    <?php echo $out_clinics_location ?>
                </td>
                <td>
                    <?php echo $out_nurses_first_name ?>
                </td>
                <td>
                    <?php echo $out_nurses_last_name ?>
                </td>
                <td>
                    <?php echo $out_donors_first_name?>
                </td>
                <td>
                    <?php echo $out_donors_last_name ?>
                </td>
                <td>
                    <?php echo $out_blood_types_blood_group?>
                </td>
                <td>
                    <?php echo $out_blood_types_rh_factor ?>
                </td>
                <td>
                    <?php echo $out_blood_types_rare_antigen ?>
                </td>
                <td>
                    <form action="edit.php" class="edit" method="get">
                        <input type="hidden" name="id" value="<?php echo $out_blood_bags_id ?>">
                        <button class="btn btn-sm" type="submit">Edit</button>
                    </form>
                </td>
                <td>
                    <form action="destroy.php" class="delete" method="post">
                        <input type="hidden" name="id" value="<?php echo $out_blood_bags_id ?>">
                        <button class="btn btn-sm" type="submit">Delete</button>
                    </form>
                </td>
            </tr>

        <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>