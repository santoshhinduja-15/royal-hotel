<?php
session_start();
require_once 'db_connection.php';

$active = $conn->query("SELECT * FROM room_bookings ORDER BY booking_date DESC");
$cancelled = $conn->query("SELECT * FROM cancelled_bookings ORDER BY cancelled_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Bookings</title>
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
        <?php
        $pages = [
          "admin_home.php" => ["Home", "bi-house-fill text-primary"],
          "room_status.php" => ["Room Status", "bi-door-open-fill text-success"],
          "admin_bookings.php" => ["Room Bookings", "bi-journal-check text-info"],
          "reviews_page.php" => ["Reviews", "bi-chat-left-quote-fill text-danger"],
          "contact_messages.php" => ["Messages", "bi-envelope-fill text-warning"]
        ];
        foreach ($pages as $file => [$label, $icon]) {
          $activeClass = basename($_SERVER['PHP_SELF']) == $file ? 'active' : '';
          echo "<li class='nav-item'>
                  <a class='nav-link d-flex align-items-center $activeClass' href='$file'>
                    <i class='bi $icon me-2'></i> $label
                  </a>
                </li>";
        }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container py-4">

  <!-- Active Bookings -->
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Room</th>
              <th>Check-In</th>
              <th>Check-Out</th>
              <th>Price</th>
              <th>Booked On</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $active->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= $row['email'] ?></td>
                <td><span class="badge text-bg-primary"><?= ucfirst($row['room_type']) ?></span></td>
                <td><?= $row['check_in'] ?></td>
                <td><?= $row['check_out'] ?></td>
                <td class="fw-semibold text-success">₹<?= number_format($row['price'], 2) ?></td>
                <td><?= date("d M Y, h:i A", strtotime($row['booking_date'])) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Cancelled Bookings -->
  <div class="card border-0 shadow-sm">
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center mb-0">
          <thead class="table-light">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Room</th>
              <th>Check-In</th>
              <th>Check-Out</th>
              <th>Price</th>
              <th>Booked On</th>
              <th>Cancelled On</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $cancelled->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= $row['email'] ?></td>
                <td><span class="badge text-bg-secondary"><?= ucfirst($row['room_type']) ?></span></td>
                <td><?= $row['check_in'] ?></td>
                <td><?= $row['check_out'] ?></td>
                <td class="fw-semibold text-danger">₹<?= number_format($row['price'], 2) ?></td>
                <td><?= date("d M Y, h:i A", strtotime($row['booking_date'])) ?></td>
                <td><?= date("d M Y, h:i A", strtotime($row['cancelled_at'])) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  <small>© 2025 Royal Hotel. All Rights Reserved.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
