<?php
/**
 * Created by PhpStorm.
 * User: reginaimhoff
 * Date: 6/5/15
 * Time: 6:11 PM
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
$first_name = filter_input(INPUT_POST, 'first_name', FILTER_DEFAULT);
if ($first_name === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'First name not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$last_name = filter_input(INPUT_POST, 'last_name', FILTER_DEFAULT);
if ($last_name === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Last name not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$dob = filter_input(INPUT_POST, 'dob', FILTER_DEFAULT);
if ($dob === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Date of birth not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$dob_parsed = date_parse($dob);
if (!checkdate($dob_parsed['month'], $dob_parsed['day'], $dob_parsed['year'])) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Date entered is invalid!'
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

if (!($statement = $connection->prepare("INSERT INTO donors(first_name, last_name, dob) VALUES(?,?,?) "))) {
    http_response_code(500);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Try again later (2)'
    );
    echo json_encode($response_array);
    exit;
}

if (!$statement->bind_param('sss', $first_name, $last_name, $dob)) {
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
    'message' => 'Donor registered'
);
echo json_encode($response_array);
exit;
?>