<?php
require 'db_connection.php';

if ($conn->connect_error) {
    header("Location: customer_dashboard_page.php?error");
    exit;
}

$room_type = $_POST['room_type'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];

// Total rooms of that type
$inventory_sql = "SELECT total_rooms FROM room_inventory WHERE room_type = '$room_type'";
$inventory_result = $conn->query($inventory_sql);

if ($inventory_result && $inventory_result->num_rows > 0) {
    $row = $inventory_result->fetch_assoc();
    $total_rooms = $row['total_rooms'];

    // Booked rooms in the given date range
    $booking_sql = "SELECT COUNT(*) AS booked FROM room_bookings 
        WHERE room_type = '$room_type' 
        AND (check_in < '$check_out' AND check_out > '$check_in')";

    $booking_result = $conn->query($booking_sql);
    $booked = 0;

    if ($booking_result && $booking_result->num_rows > 0) {
        $booking_row = $booking_result->fetch_assoc();
        $booked = $booking_row['booked'];
    }

    if ($booked < $total_rooms) {
        header("Location: customer_dashboard_page.php?available");
    } else {
        header("Location: customer_dashboard_page.php?unavailable");
    }
} else {
    header("Location: customer_dashboard_page.php?error");
}

$conn->close();
exit;
?>
