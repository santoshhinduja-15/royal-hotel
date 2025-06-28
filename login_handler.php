<?php
session_start();
include 'db_connection.php'; // Adjust path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $fullname, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // ✅ Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email;

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: admin_home.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['error'] = 'Invalid password.';
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'User not found. Please register first.';
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
