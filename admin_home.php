<?php
include('db_connection.php');
session_start();

// Fetch total bookings
$bookingsQuery = "SELECT COUNT(*) AS total_bookings FROM room_bookings";
$bookingsResult = $conn->query($bookingsQuery);
$totalBookings = $bookingsResult ? $bookingsResult->fetch_assoc()['total_bookings'] : 0;

// Fetch total customers (not admins)
$usersQuery = "SELECT COUNT(*) AS total_customers FROM users WHERE role = 'customer'";
$usersResult = $conn->query($usersQuery);
$totalUsers = $usersResult ? $usersResult->fetch_assoc()['total_customers'] : 0;

// Fetch available rooms
$availableRoomsQuery = "
    SELECT SUM(total_rooms - COALESCE(booked_rooms, 0)) AS available_rooms
    FROM (
        SELECT ri.total_rooms, COALESCE(br.booked_rooms, 0) AS booked_rooms
        FROM room_inventory ri
        LEFT JOIN (
            SELECT room_type, COUNT(*) AS booked_rooms
            FROM room_bookings
            GROUP BY room_type
        ) br ON ri.room_type = br.room_type
    ) AS available_room_data";
$availableRoomsResult = $conn->query($availableRoomsQuery);
$totalAvailableRooms = $availableRoomsResult ? $availableRoomsResult->fetch_assoc()['available_rooms'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Royal Hotel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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

<!-- Dashboard Metrics -->
<div class="container my-5">
  <div class="row g-4 text-center">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm bg-white h-100">
        <div class="card-body">
          <i class="bi bi-journal-bookmark-fill text-primary fs-1 mb-2"></i>
          <h5 class="card-title">Total Bookings</h5>
          <p class="fs-4 fw-bold text-dark"><?= $totalBookings ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm bg-white h-100">
        <div class="card-body">
          <i class="bi bi-people-fill text-success fs-1 mb-2"></i>
          <h5 class="card-title">Registered Customers</h5>
          <p class="fs-4 fw-bold text-dark"><?= $totalUsers ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm bg-white h-100">
        <div class="card-body">
          <i class="bi bi-door-open-fill text-warning fs-1 mb-2"></i>
          <h5 class="card-title">Available Rooms</h5>
          <p class="fs-4 fw-bold text-dark"><?= $totalAvailableRooms ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Registered Users Table -->
<div class="container mt-5">
  <h4 class="mb-3">Registered Customers</h4>
  <div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle table-bordered bg-white">
      <thead class="table-dark text-center">
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $userQuery = "SELECT fullname, email, role FROM users WHERE role = 'customer'";
        $userResult = $conn->query($userQuery);
        if ($userResult && $userResult->num_rows > 0) {
          while ($userRow = $userResult->fetch_assoc()) {
            echo "<tr class='text-center'>
                    <td>{$userRow['fullname']}</td>
                    <td>{$userRow['email']}</td>
                    <td><span class='badge bg-success text-uppercase'>{$userRow['role']}</span></td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='3' class='text-center text-muted'>No registered customers found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
