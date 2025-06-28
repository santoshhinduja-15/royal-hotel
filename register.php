<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Server-side validation
    if (
        strlen($fullname) < 3 ||
        !preg_match('/^[0-9]{10}$/', $mobile) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        empty($role) ||
        !preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/', $password)
    ) {
        header("Location: register_page.php?error=validation");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check for duplicate user
    $checkQuery = "SELECT * FROM users WHERE fullname = ? OR mobile = ? OR email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("sss", $fullname, $mobile, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: register_page.php?error=exists");
        exit();
    }

    // Insert user
    $insertQuery = "INSERT INTO users (fullname, mobile, email, role, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssss", $fullname, $mobile, $email, $role, $hashed_password);

    if ($stmt->execute()) {
        header("Location: register_page.php?registered=success");
    } else {
        header("Location: register_page.php?error=unknown");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: register_page.php");
    exit();
}
