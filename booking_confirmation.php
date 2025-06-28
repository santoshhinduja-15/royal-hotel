<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $roomType = trim($_POST['roomType']);
    $checkIn = trim($_POST['checkIn']);
    $checkOut = trim($_POST['checkOut']);
    $price = trim($_POST['price']);

    if ($fullName && $email && $roomType && $checkIn && $checkOut && $price) {
        $stmt = $conn->prepare("INSERT INTO room_bookings (full_name, email, room_type, check_in, check_out, price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssd", $fullName, $email, $roomType, $checkIn, $checkOut, $price);

        if ($stmt->execute()) {
            header("Location: thank_you.php");
            exit();
        } else {
            die("❌ Error while booking: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("❌ Please fill all the fields.");
    }

    $conn->close();
} else {
    header("Location: booking.php");
    exit();
}
