<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
require_once 'db_connection.php';

$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Messages - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

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
            <a class="nav-link" href="logout.php">
              <i class="bi bi-box-arrow-right me-1 text-danger"></i> Logout
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="my_bookings.php">
              <i class="bi bi-journal-bookmark me-1 text-warning"></i> My Bookings
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<section class="py-5 bg-primary text-white text-center">
  <div class="container">
    <h1 class="display-5 fw-bold">Guest Queries</h1>
    <p class="lead">Resolve the Query of Guest</p>
  </div>
</section>

<!-- Main Content -->
<div class="container my-5">
  <h2 class="text-center mb-4 text-dark">Contact Messages</h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="row g-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
              <h5 class="card-title mb-1"><?= htmlspecialchars($row['name']) ?></h5>
              <h6 class="card-subtitle mb-2 text-muted">
                <i class="bi bi-envelope"></i> <?= htmlspecialchars($row['email']) ?>
              </h6>
              <p class="card-text"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <small class="text-muted"><i class="bi bi-clock"></i> <?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></small>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center mt-4">
      <i class="bi bi-info-circle-fill"></i> No contact messages found.
    </div>
  <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
  <p class="mb-0">© 2025 Royal Hotel. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
