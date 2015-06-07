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
$clinic_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($clinic_id === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Clinic id not provided!'
    );
    echo json_encode($response_array);
    exit;
}
$location = filter_input(INPUT_POST, 'location', FILTER_DEFAULT);
if ($location === null) {
    http_response_code(422);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Location not entered!'
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
if (!($statement = $connection->prepare("UPDATE clinics SET location = ? WHERE id = ?"))) {
    http_response_code(500);
    header('Content-type: application/json');
    $response_array = array(
        'status' => 'error',
        'message' => 'Try again later (2)'
    );
    echo json_encode($response_array);
    exit;
}
if (!$statement->bind_param('si', $location, $clinic_id)) {
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
    'message' => 'Clinic updated!'
);
echo json_encode($response_array);
exit;
?>