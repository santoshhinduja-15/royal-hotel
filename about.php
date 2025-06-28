<?php
  session_start();
  $isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - Royal Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
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

<!-- Page Header -->
<header class="bg-light py-5 text-center border-bottom">
  <div class="container">
    <h1 class="display-5 fw-bold">About Royal Hotel</h1>
    <p class="lead text-muted">Discover comfort, class, and a home away from home.</p>
  </div>
</header>

<!-- About Section -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-lg-6">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c" class="img-fluid rounded shadow" alt="Hotel Interior" />
      </div>
      <div class="col-lg-6">
        <h2 class="fw-bold">Welcome to Royal Hotel</h2>
        <p class="text-muted">
          Royal Hotel offers a perfect blend of comfort, convenience, and class. Strategically located in the heart of the city, we cater to both business travelers and tourists looking for a luxurious yet affordable stay.
        </p>
        <span class="badge bg-primary fs-6">Since 2015</span>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-light border-top border-bottom">
  <div class="container">
    <h2 class="text-center mb-4 fw-semibold">Why Choose Us?</h2>
    <div class="row text-center g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <i class="bi bi-house-fill fs-1 text-primary mb-3"></i>
            <h5 class="card-title">Modern Rooms</h5>
            <p class="card-text">Spacious and contemporary designs to ensure a relaxing experience.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <i class="bi bi-person-badge-fill fs-1 text-primary mb-3"></i>
            <h5 class="card-title">Friendly Staff</h5>
            <p class="card-text">Trained professionals who go the extra mile for your comfort.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <i class="bi bi-wifi fs-1 text-primary mb-3"></i>
            <h5 class="card-title">Free Wi-Fi & Breakfast</h5>
            <p class="card-text">Stay connected and start your day with a complimentary breakfast.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission Section -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-md-6 order-md-2">
        <img src="images/mission.jpg" class="img-fluid rounded shadow" alt="Our Mission" />
      </div>
      <div class="col-md-6">
        <h3 class="fw-bold">Our Mission</h3>
        <p>
          Our goal is to provide a relaxing and enriching hospitality experience for every guest.
          We are committed to delivering quality service, value, and satisfaction with every stay.
        </p>
        <ul class="list-group list-group-flush mt-3">
          <li class="list-group-item">24/7 Customer Support</li>
          <li class="list-group-item">Proximity to Major Attractions</li>
          <li class="list-group-item">Secure & Hassle-Free Booking</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
