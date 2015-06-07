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
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
}
$blood_bag_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($blood_bag_id === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Blood bag id not provided!'
    );
    echo json_encode($response_array);
    exit;
}

$collection_datetime = filter_input(INPUT_POST, 'collection_datetime', FILTER_DEFAULT);
if ($collection_datetime === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Collection date/time not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$collection_datetime_parsed = date_parse($collection_datetime);
if (!checkdate($collection_datetime_parsed['month'], $collection_datetime_parsed['day'], $collection_datetime_parsed['year'])) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Date entered is invalid!'
    );
    echo json_encode($response_array);
    exit;
}

$fk_clinic_id = filter_input(INPUT_POST, 'fk_clinic_id', FILTER_VALIDATE_INT);
if ($fk_clinic_id === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Clinic not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$fk_nurse_id = filter_input(INPUT_POST, 'fk_nurse_id', FILTER_VALIDATE_INT);
if ($fk_nurse_id === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Nurse not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$fk_donor_id = filter_input(INPUT_POST, 'fk_donor_id', FILTER_VALIDATE_INT);
if ($fk_donor_id === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Donor not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$fk_blood_type_id = filter_input(INPUT_POST, 'fk_blood_type_id', FILTER_VALIDATE_INT);
if ($fk_blood_type_id === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Blood type not entered!'
    );
    echo json_encode($response_array);
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
if ($connection->connect_error) {
    http_response_code(500);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Try again later (1)'
    );
    echo json_encode($response_array);
    exit;
}
if (!($statement = $connection->prepare(
    "UPDATE blood_bags " .
    "SET collection_datetime = ?, " .
    "fk_clinic_id = ?, " .
    "fk_nurse_id = ?, " .
    "fk_donor_id = ?" .
    "fk_blood_type_id = ? " .
    "WHERE id = ?"
))) {
    http_response_code(500);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Try again later (2)'
    );
    echo json_encode($response_array);
    exit;
}
if (!$statement->bind_param(
    'siiiii',
    $collection_datetime,
    $fk_clinic_id,
    $fk_nurse_id,
    $fk_donor_id,
    $fk_blood_type_id,
    $blood_bag_id
)) {
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Try again later (3)'
    );
    echo json_encode($response_array);
    exit;
}
if (!$statement->execute()) {
    error_log($statement->error);
    http_response_code(500);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Try again later (4)'
    );
    echo json_encode($response_array);
    exit;
}
$statement->close();
header('Content-type: application/json');
$response_array = array(
    'status' => 'success',
    'message' => 'Blood bag updated!'
);
echo json_encode($response_array);
exit;
?>