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
$blood_group = filter_input(INPUT_POST, 'blood_group', FILTER_DEFAULT);
if ($blood_group === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Blood group not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$rh_factor = filter_input(INPUT_POST, 'rh_factor', FILTER_DEFAULT);
if ($rh_factor === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'RH factor not entered!'
    );
    echo json_encode($response_array);
    exit;
}

$rare_antigen = filter_input(INPUT_POST, 'rare_antigen', FILTER_DEFAULT);

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

if (!($statement = $connection->prepare("INSERT INTO blood_types(blood_group, rh_factor, rare_antigen) VALUES(?,?,?) "))) {
    http_response_code(500);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Try again later (2)'
    );
    echo json_encode($response_array);
    exit;
}

if (!$statement->bind_param('sss', $blood_group, $rh_factor, $rare_antigen)) {
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
    'message' => 'Blood Group registered'
);
echo json_encode($response_array);
exit;
?>