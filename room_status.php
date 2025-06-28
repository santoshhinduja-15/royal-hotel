<?php
include('db_connection.php');
session_start();

$query = "
    SELECT ri.room_type, ri.total_rooms, COALESCE(br.booked_rooms, 0) AS booked_rooms
    FROM room_inventory ri
    LEFT JOIN (
        SELECT room_type, COUNT(*) AS booked_rooms
        FROM room_bookings
        GROUP BY room_type
    ) br ON ri.room_type = br.room_type
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Room Status - Royal Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="admin_home.php">
      <i class="bi bi-speedometer2 me-2 text-warning"></i> Admin Dashboard
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="adminNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center <?= basename($_SERVER['PHP_SELF']) == 'admin_home.php' ? 'active' : '' ?>" href="admin_home.php">
            <i class="bi bi-house-fill me-2 text-primary"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center <?= basename($_SERVER['PHP_SELF']) == 'room_status.php' ? 'active' : '' ?>" href="room_status.php">
            <i class="bi bi-door-open-fill me-2 text-success"></i> Room Status
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center <?= basename($_SERVER['PHP_SELF']) == 'admin_bookings.php' ? 'active' : '' ?>" href="admin_bookings.php">
            <i class="bi bi-journal-check me-2 text-info"></i> Room Bookings
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center <?= basename($_SERVER['PHP_SELF']) == 'reviews_page.php' ? 'active' : '' ?>" href="reviews_page.php">
            <i class="bi bi-chat-left-quote-fill me-2 text-danger"></i> Reviews
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center <?= basename($_SERVER['PHP_SELF']) == 'contact_messages.php' ? 'active' : '' ?>" href="contact_messages.php">
            <i class="bi bi-envelope-fill me-2 text-warning"></i> Messages
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="logout.php">
            <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Page Header -->
<header class="py-4 bg-white shadow-sm border-bottom mb-4">
  <div class="container text-center">
    <h2 class="fw-bold">Room Status Overview</h2>
    <p class="text-muted">Track total, booked, and available rooms at a glance</p>
  </div>
</header>

<!-- Room Status Table -->
<div class="container mb-5">
  <div class="table-responsive">
    <table class="table table-hover table-bordered align-middle text-center bg-white shadow-sm">
      <thead class="table-dark">
        <tr>
          <th>Room Type</th>
          <th>Total Rooms</th>
          <th>Booked Rooms</th>
          <th>Available Rooms</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result) {
          while ($row = $result->fetch_assoc()) {
            $updatedBookedRooms = $_SESSION['updated_booked_rooms'][$row['room_type']] ?? $row['booked_rooms'];
            $availableRooms = $row['total_rooms'] - $updatedBookedRooms;

            $availabilityBadge = $availableRooms > 0
              ? "<span class='badge bg-success'>$availableRooms</span>"
              : "<span class='badge bg-danger'>0</span>";

            echo "<tr>
                    <td class='fw-semibold'>{$row['room_type']}</td>
                    <td>{$row['total_rooms']}</td>
                    <td><span class='badge bg-warning text-dark'>{$updatedBookedRooms}</span></td>
                    <td>$availabilityBadge</td>
                    <td>
                      <a href='edit_room.php?room_type={$row['room_type']}' class='btn btn-sm btn-outline-primary'>
                        <i class='bi bi-pencil-square'></i> Edit
                      </a>
                    </td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='5' class='text-center text-muted'>No room data found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
  <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
