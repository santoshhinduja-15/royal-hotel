<?php
session_start();

// Include database connection
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $roomType = $_POST['roomType'];
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $price = $_POST['price'];

    // Insert the booking details into the database
    $sql = "INSERT INTO room_bookings (full_name, email, room_type, check_in, check_out, price) 
            VALUES ('$fullName', '$email', '$roomType', '$checkIn', '$checkOut', '$price')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the payment gateway (dummy in this case)
        header('Location: dummy_payment_gateway.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
