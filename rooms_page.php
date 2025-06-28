<?php
  session_start();
  $isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rooms - Royal Hotel</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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

  <!-- Rooms Section -->
  <div class="container py-5">
    <h1 class="text-center mb-5">Available Rooms</h1>
    <div class="row g-4 justify-content-center">

      <!-- Single Room -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="ratio ratio-4x3">
            <img src="images/single-room.jpg" class="img-fluid rounded object-fit-cover" alt="Single Room">
          </div>
          <div class="card-body">
            <h5 class="card-title">Single Room</h5>
            <span class="badge bg-primary mb-2">₹500/night</span>
            <p class="card-text">Perfect for solo travelers. Includes 1 bed, Wi-Fi, and complimentary breakfast.</p>
            <a href="booking.php" class="btn btn-outline-primary w-100">Book Now</a>
          </div>
        </div>
      </div>

      <!-- Double Room -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="ratio ratio-4x3">
            <img src="images/double-room.jpg" class="img-fluid rounded object-fit-cover" alt="Double Room">
          </div>
          <div class="card-body">
            <h5 class="card-title">Double Room</h5>
            <span class="badge bg-primary mb-2">₹1000/night</span>
            <p class="card-text">Spacious for two guests. Includes 2 beds, AC, TV, and private bathroom.</p>
            <a href="booking.php" class="btn btn-outline-primary w-100">Book Now</a>
          </div>
        </div>
      </div>

      <!-- Deluxe Room -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="ratio ratio-4x3">
            <img src="images/deluxe-room.jpg" class="img-fluid rounded object-fit-cover" alt="Deluxe Room">
          </div>
          <div class="card-body">
            <h5 class="card-title">Deluxe Room</h5>
            <span class="badge bg-primary mb-2">₹2000/night</span>
            <p class="card-text">Luxurious stay with king-size bed, mini-bar, bathtub, and balcony view.</p>
            <a href="booking.php" class="btn btn-outline-primary w-100">Book Now</a>
          </div>
        </div>
      </div>

      <!-- Suite -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="ratio ratio-4x3">
            <img src="images\suite-room.jpg" class="img-fluid rounded object-fit-cover" alt="Suite Room">
          </div>
          <div class="card-body">
            <h5 class="card-title">Suite</h5>
            <span class="badge bg-primary mb-2">₹3500/night</span>
            <p class="card-text">Experience luxury with spacious living area, king-sized bed, and breathtaking views.
            </p>
            <a href="booking.php" class="btn btn-outline-primary w-100">Book Now</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>