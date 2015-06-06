<?php

/**
 * Created by PhpStorm.
 * User: Regina Imhoff
 * Date: 5/28/15
 * Time: 2:56 PM
 */


// turns on error reporting
error_reporting(E_ALL);
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "imhoffr-db", "kSPLM3ed144rC1dd", "imhoffr-db");

// test connection
if($mysqli->connect_errno){
    echo "Connection error" . $mysqli->connect_errno . " " .  $mysqli->connect_error;
}
?>

<! DOCTYPE html >

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
        <table>
            <tr>
                <td>Donor Information</td>
            </tr>
            <br>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Date of Birth</td>
                <td>Donor ID</td>
            </tr>

<?php

    if(!($statement = $mysqli->prepare("SELECT first_name, last_name, dob, id FROM donors"))){
        echo "Prepare failed: " . $mysqli->connect_errno . " " .  $mysqli->connect_error;
    }

    if(!($statement->execute())){
        echo "Execute failed: " . $mysqli->connect_errno . " " .  $mysqli->connect_error;
    }

    if(!($statement->bind_result($first_name, $last_name, $dob, $donor_id))){
        echo "Bind result failed: " . $mysqli->connect_errno . " " .  $mysqli->connect_error;
    }

    while($statement->fetch()){
        echo "<tr>\n<td>" . $first_name . "\n</td>\n<td>" . $last_name . "\n</td>\n<td>" . $dob . "\n</td>";

    }

?>
        </table>
</div>
<a href="donors/index.php">Donors</a>
<div>
    <form method="post" action="index.php"> <!-- change this LATER!!!!!! -->
        <fieldset>
            <legend>
                Blood Specimen Information
            </legend>
            <p>
                Date of Collection: <input type="date" name="CollectionDate" />
            </p>
            <p>
                Time of Collection: <input type="time" name="CollectionTime" />
            </p>
            <p>
                Blood Bag ID: <input type="text" name="BagID" />
            </p>
        </fieldset>
        <input type="submit" name="add" value="Add Blood Specimen Information" />
        <input type="submit" name="update" value="Update Blood Specimen Information" />
    </form>
</div>
<div>
    <form method="post" action="index.php"> <!-- CHANGE THIS LATER!!!! -->
        <fieldset class="radiogroup">
            <legend>
                Blood Type - Group
            </legend>
            <ul class="radio">
                <li><input type="radio" name="BloodGroup" id="A" value="A" /><label for="A">A</label></li>
                <li><input type="radio" name="BloodGroup" id="B" value="B" /><label for="B">B</label></li>
                <li><input type="radio" name="BloodGroup" id="AB" value="AB" /><label for="AB">AB</label></li>
                <li><input type="radio" name="BloodGroup" id="O" value="O" /><label for="O">O</label></li>
        </fieldset>

        <fieldset class="radiogroup">
            <legend>
                Blood Type - Rh Factor
            </legend>
            <ul class="radio">
                <li><input type="radio" name="BloodRh" id="Pos" value="Pos" /><label for="Pos">Positive</label></li>
                <li><input type="radio" name="BloodRh" id="Neg" value="Neg" /><label for="Neg">Negative</label></li>
        </fieldset>
        <input type="submit" name="add" value="Add Blood Type" />
        <input type="submit" name="update" value="Update Blood Type" />
    </form>
</div>
<div>
    <form method="post" action="index.php"> <!-- CHANGE THIS LATER!!!! -->
        <fieldset>
            <legend>
                Collection Information
            </legend>
            <p>
                Clinic Location: <input type="text" name="ClinicLocation" />
            </p>
            <p>
                Nurse First Name: <input type="text" name="NurseFirstName" />
            </p>
            <p>
                Nurse Last Name: <input type="text" name="NurseLastName" />
            </p>
            <p>
                Nurse ID: <input type="text" name="NurseID" />
            </p>
        </fieldset>
        <input type="submit" name="add" value="Add Collection Information" />
        <input type="submit" name="update" value="Update Collection Information" />
    </form>
</div>

<p><input type="submit" /></p>

    </form>
</div>

</body>
</html>