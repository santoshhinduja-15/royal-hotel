<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'db_connection.php';

if (!$isLoggedIn || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Bookings - Royal Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
      background-size: cover;
    }
    .glass-card {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      padding: 2rem;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center animate__animated animate__fadeInLeft" href="#">
      <img src="images/logo.jpg" alt="Royal Hotel Logo" height="40" class="me-2 rounded" />
      Royal Hotel
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php if (!$isLoggedIn): ?>
          <!-- Shown only when NOT logged in -->
          <li class="nav-item">
            <a class="nav-link" href="login.php">
              <i class="bi bi-box-arrow-in-right me-1 text-primary"></i> Login
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register_page.php">
              <i class="bi bi-pencil-square me-1 text-success"></i> Register
            </a>
          </li>
        <?php endif; ?>

        <!-- Always visible -->
        <li class="nav-item">
          <a class="nav-link" href="rooms_page.php">
            <i class="bi bi-door-open me-1 text-warning"></i> Rooms
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">
            <i class="bi bi-info-circle me-1 text-info"></i> About Us
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact_page.php">
            <i class="bi bi-envelope me-1 text-danger"></i> Contact
          </a>
        </li>

        <?php if ($isLoggedIn): ?>
          <!-- Shown only when logged in -->
          <li class="nav-item">
            <a class="nav-link" href="customer_dashboard_page.php">
              <i class="bi bi-speedometer2 me-1 text-primary"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="review.php">
              <i class="bi bi-chat-left-text me-1 text-success"></i> Write a Review
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="my_bookings.php">
              <i class="bi bi-journal-bookmark me-1 text-warning"></i> My Bookings
            </a>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="bi bi-box-arrow-right me-1 text-danger"></i> Logout
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<main class="container my-5">
  <div class="glass-card">
    <h2 class="text-center mb-4 text-dark">My Bookings</h2>

    <?php if (isset($_GET['cancel'])): ?>
      <div class="alert alert-<?= $_GET['cancel'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= $_GET['cancel'] === 'success' ? 'Booking cancelled successfully.' : 'Failed to cancel booking.' ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php
    $stmt = $conn->prepare("SELECT id, room_type, check_in, check_out, price, booking_date FROM room_bookings WHERE email = ? ORDER BY booking_date DESC");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>Room Type</th>
              <th>Check-In</th>
              <th>Check-Out</th>
              <th>Price (₹)</th>
              <th>Booking Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['room_type']) ?></td>
                <td><?= date("d M Y", strtotime($row['check_in'])) ?></td>
                <td><?= date("d M Y", strtotime($row['check_out'])) ?></td>
                <td>₹<?= number_format($row['price'], 2) ?></td>
                <td><?= date("d M Y, h:i A", strtotime($row['booking_date'])) ?></td>
                <td>
                  <form method="POST" action="cancel_booking.php">
                    <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">
        <i class="bi bi-info-circle-fill"></i> No bookings found.
      </div>
    <?php endif;
    $stmt->close();
    $conn->close();
    ?>
  </div>
</main>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
  <div class="container">
    <small>© 2025 Royal Hotel. All Rights Reserved.</small>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
