<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch user profile
    $profileQuery = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($profileQuery);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $profileResult = $stmt->get_result();
    $profile = $profileResult->fetch_assoc();

    // Fetch user bookings
    $bookingsQuery = "SELECT * FROM bookings WHERE user_id = ?";
    $stmt = $conn->prepare($bookingsQuery);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $bookingsResult = $stmt->get_result();

    // Fetch room availability (if dates are provided)
    if (isset($_POST['check_in']) && isset($_POST['check_out'])) {
        $checkIn = $_POST['check_in'];
        $checkOut = $_POST['check_out'];
        
        $availabilityQuery = "SELECT * FROM rooms WHERE id NOT IN (SELECT room_id FROM bookings WHERE check_in < ? AND check_out > ?)";
        $stmt = $conn->prepare($availabilityQuery);
        $stmt->bind_param('ss', $checkOut, $checkIn);
        $stmt->execute();
        $availabilityResult = $stmt->get_result();
        
        // Send the available rooms data to the frontend
        $availableRooms = [];
        while ($room = $availabilityResult->fetch_assoc()) {
            $availableRooms[] = $room;
        }

        echo json_encode(['availability' => $availableRooms]);
        exit();
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}
?>
