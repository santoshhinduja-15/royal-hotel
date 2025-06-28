<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking_id'])) {
    $bookingId = (int)$_POST['booking_id'];
    $email = $_SESSION['email'];

    $select = $conn->prepare("SELECT * FROM room_bookings WHERE id = ? AND email = ?");
    $select->bind_param("is", $bookingId, $email);
    $select->execute();
    $result = $select->get_result();

    if ($result && $result->num_rows > 0) {
        $booking = $result->fetch_assoc();

        $insert = $conn->prepare("INSERT INTO cancelled_bookings 
            (full_name, email, room_type, check_in, check_out, price, booking_date, cancelled_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $insert->bind_param(
            "sssssss",
            $booking['full_name'],
            $booking['email'],
            $booking['room_type'],
            $booking['check_in'],
            $booking['check_out'],
            $booking['price'],
            $booking['booking_date']
        );

        if ($insert->execute()) {
            $delete = $conn->prepare("DELETE FROM room_bookings WHERE id = ?");
            $delete->bind_param("i", $bookingId);
            $delete->execute();
            header("Location: my_bookings.php?cancel=success");
            exit();
        }
    }

    header("Location: my_bookings.php?cancel=error");
    exit();
}

header("Location: my_bookings.php?cancel=error");
exit();
