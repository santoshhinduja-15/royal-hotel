<?php
  session_start();
  $isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Customer Dashboard - Royal Hotel</title>
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

<!-- Main Content -->
<div class="container mt-5">
  <h3>Check Room Availability</h3>

  <!-- Alert Container -->
  <div id="alertContainer" class="mt-3"></div>

  <!-- Form -->
  <form action="check_availability.php" method="POST" class="mt-3">
    <div class="mb-3">
      <label for="room_type" class="form-label">Room Type</label>
      <select name="room_type" id="room_type" class="form-control" required>
        <option value="single">Single</option>
        <option value="double">Double</option>
        <option value="deluxe">Deluxe</option>
        <option value="suite">Suite</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="check_in" class="form-label">Check-in Date</label>
      <input type="date" name="check_in" class="form-control" required />
    </div>
    <div class="mb-3">
      <label for="check_out" class="form-label">Check-out Date</label>
      <input type="date" name="check_out" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary">Check Availability</button>
  </form>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Alert Script -->
<script>
  const params = new URLSearchParams(window.location.search);
  const alertContainer = document.getElementById("alertContainer");

  if (params.has("available")) {
    alertContainer.innerHTML = `
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ Room is available!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
  } else if (params.has("unavailable")) {
    alertContainer.innerHTML = `
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        ❌ Room is not available.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
  } else if (params.has("error")) {
    alertContainer.innerHTML = `
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ⚠️ Error checking availability. Please try again later.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
  }
</script>

</body>
</html>
