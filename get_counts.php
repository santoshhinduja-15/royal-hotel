<?php
include 'db_connection.php';

// Initialize variables
$totalBookings = $registeredUsers = $availableRooms = 0;

// Total Bookings
$bookingResult = $conn->query("SELECT COUNT(*) AS total FROM room_bookings");
if ($bookingResult) {
    $row = $bookingResult->fetch_assoc();
    $totalBookings = $row['total'];
}

// Registered Users
$userResult = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");
if ($userResult) {
    $row = $userResult->fetch_assoc();
    $registeredUsers = $row['total'];
}

// Available Rooms
$roomResult = $conn->query("SELECT SUM(total_rooms) AS total FROM room_inventory");
if ($roomResult) {
    $row = $roomResult->fetch_assoc();
    $availableRooms = $row['total'];
}

$conn->close();
?>
