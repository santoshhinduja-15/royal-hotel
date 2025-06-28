<?php
  session_start();
  $isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Royal Hotel</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>

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


<!-- Hero Section -->
<header class="d-flex align-items-center justify-content-center bg-dark text-white text-center"
        style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c'); background-size: cover; background-position: center; height: 90vh;">
  <div class="container animate__animated animate__zoomIn">
    <h1 class="display-4 fw-bold mb-3 bg-primary">Welcome to Royal Hotel</h1>
    <p class="lead mb-4 bg-primary">Book your stay with comfort and elegance</p>
    <a href="rooms_page.php" class="btn btn-warning btn-lg animate__animated animate__pulse animate__infinite">
      <i class="bi bi-door-open-fill me-2"></i>View Rooms
    </a>
  </div>
</header>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
