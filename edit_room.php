<?php
// Include the database connection
include('db_connection.php');

// Start the session to store temporary data for booked rooms and total rooms
session_start();

$alert = ""; // to store alert HTML

// Check if the room_type is passed in the URL
if (isset($_GET['room_type'])) {
    $room_type = $_GET['room_type'];

    // Fetch the room data for the specific room type
    $query = "
        SELECT ri.room_type, ri.total_rooms, COALESCE(br.booked_rooms, 0) AS booked_rooms
        FROM room_inventory ri
        LEFT JOIN (SELECT room_type, COUNT(*) AS booked_rooms FROM room_bookings GROUP BY room_type) br
        ON ri.room_type = br.room_type
        WHERE ri.room_type = '$room_type'
    ";

    $result = $conn->query($query);
    $room = $result->fetch_assoc();

    // Check if data exists for this room type
    if (!$room) {
        die("Room type not found.");
    }

    // Handle the form submission to update total rooms and booked rooms (only for session, not in DB)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_total_rooms = $_POST['total_rooms'];
        $new_booked_rooms = $_POST['booked_rooms'];  // Get updated booked_rooms value

        // Store the updated booked rooms temporarily in the session
        $_SESSION['updated_booked_rooms'][$room_type] = $new_booked_rooms;

        // Update the total rooms in the database (we will not update booked_rooms in DB)
        $updateQuery = "UPDATE room_inventory SET total_rooms = '$new_total_rooms' WHERE room_type = '$room_type'";

        if ($conn->query($updateQuery)) {
            // Update available rooms in session as well
            $_SESSION['updated_total_rooms'][$room_type] = $new_total_rooms;

            // Set success Bootstrap alert
            $alert = '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Total room count updated successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            // Set error Bootstrap alert
            $alert = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error updating room details: ' . htmlspecialchars($conn->error) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
} else {
    die("Room type not specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Room - <?php echo htmlspecialchars($room['room_type']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/admin.css" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <li class="nav-item"><a class="nav-link" href="room_status.php">Room Status</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Edit Room Form -->
    <div class="container mt-5">
        <h2>Edit Room - <?php echo htmlspecialchars($room['room_type']); ?></h2>

        <!-- Display alert here -->
        <?php echo $alert; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="total_rooms" class="form-label">Total Rooms</label>
                <input
                    type="number"
                    class="form-control"
                    id="total_rooms"
                    name="total_rooms"
                    value="<?php echo htmlspecialchars($room['total_rooms']); ?>"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="booked_rooms" class="form-label">Booked Rooms</label>
                <input
                    type="number"
                    class="form-control"
                    id="booked_rooms"
                    name="booked_rooms"
                    value="<?php 
                        // Display temporarily updated booked rooms if available, else original value
                        echo isset($_SESSION['updated_booked_rooms'][$room_type]) ? 
                            htmlspecialchars($_SESSION['updated_booked_rooms'][$room_type]) : 
                            htmlspecialchars($room['booked_rooms']); 
                    ?>"
                    required
                >
            </div>
            <button type="submit" class="btn btn-primary">Update Room</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
