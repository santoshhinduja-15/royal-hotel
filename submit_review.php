<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['fullName']);
    $roomType = $_POST['roomType'];
    $review = trim($_POST['review']);
    $rating = (int)$_POST['rating'];

    if ($fullName == "" || $roomType == "" || $review == "" || $rating == 0) {
        $_SESSION['review_error'] = "All fields are required.";
    } else {
        // Correct column name used: submitted_at
        $sql = "INSERT INTO reviews (full_name, room_type, review, rating, submitted_at)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $fullName, $roomType, $review, $rating);

        if ($stmt->execute()) {
            $_SESSION['review_success'] = "Thank you! Your review was submitted successfully.";
        } else {
            $_SESSION['review_error'] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }

    $conn->close();
    header("Location: review.php");
    exit();
}
?>
