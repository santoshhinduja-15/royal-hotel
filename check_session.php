<?php
session_start();

header('Content-Type: application/json');

$response = [];

if (isset($_SESSION['user_id'])) {
    $response['isLoggedIn'] = true;
    $response['fullname'] = $_SESSION['fullname'];
    $response['role'] = $_SESSION['role'];
} else {
    $response['isLoggedIn'] = false;
}

echo json_encode($response);
?>
