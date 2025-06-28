<?php
include 'db_connection.php';

$result = $conn->query("SELECT COUNT(*) AS total FROM room_bookings");
if ($result && $row = $result->fetch_assoc()) {
    echo $row['total'];
} else {
    echo "0";
}
$conn->close();
?>
