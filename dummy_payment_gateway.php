<?php
session_start();
require_once 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data safely
    $fullName  = $_POST['fullName'] ?? '';
    $email     = $_POST['email'] ?? '';
    $roomType  = $_POST['roomType'] ?? '';
    $checkIn   = $_POST['checkIn'] ?? '';
    $checkOut  = $_POST['checkOut'] ?? '';

    // Validate required fields
    if (empty($fullName) || empty($email) || empty($roomType) || empty($checkIn) || empty($checkOut)) {
        echo "All fields are required.";
        exit();
    }

    // Determine price based on room type
    switch (strtolower($roomType)) {
        case 'single':
            $price = 500;
            break;
        case 'double':
            $price = 1000;
            break;
        case 'deluxe':
            $price = 2000;
            break;
        case 'suite':
            $price = 3500;
            break;
        default:
            echo "Invalid room type selected.";
            exit();
    }

    // Simulate successful payment
    $paymentSuccessful = true;

    if ($paymentSuccessful) {
        $query = "INSERT INTO room_bookings (full_name, email, room_type, check_in, check_out, price) 
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sssssd", $fullName, $email, $roomType, $checkIn, $checkOut, $price);
            if ($stmt->execute()) {
                // Redirect to Thank You page on success
                header("Location: thank_you.php");
                exit();
            } else {
                echo "❌ Error inserting data: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "❌ Error preparing query: " . $conn->error;
        }
    } else {
        echo "❌ Payment failed. Please try again.";
    }
} else {
    // If request is not POST, redirect to booking form
    header("Location: booking.php");
    exit();
}

$conn->close();
?>
