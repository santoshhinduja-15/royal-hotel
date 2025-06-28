<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Booking - Royal Hotel</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-dark text-light">

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

<!-- Booking Form Section -->
<section class="min-vh-100 d-flex align-items-center justify-content-center bg-image"
  style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c'); background-size: cover;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="bg-white text-dark p-5 rounded shadow">
          <h2 class="text-center mb-4">Room Booking Form</h2>

          <form method="POST" action="booking_confirmation.php">
            <div class="mb-3">
              <label for="fullName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullName" name="fullName" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="roomType" class="form-label">Room Type</label>
              <select class="form-select" id="roomType" name="roomType" required onchange="setPrice()">
                <option value="">Please Select</option>
                <option value="single">Single Room</option>
                <option value="double">Double Room</option>
                <option value="deluxe">Deluxe Room</option>
                <option value="suite">Suite</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="checkIn" class="form-label">Check-in Date</label>
              <input type="date" class="form-control" id="checkIn" name="checkIn" required>
            </div>
            <div class="mb-3">
              <label for="checkOut" class="form-label">Check-out Date</label>
              <input type="date" class="form-control" id="checkOut" name="checkOut" required>
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">Price</label>
              <input type="text" class="form-control" id="price" name="price" readonly required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Confirm Booking</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<footer class="bg-black text-white text-center py-3">
  <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
</footer>

<script>
function setPrice() {
  const roomType = document.getElementById('roomType').value;
  const priceField = document.getElementById('price');
  let price = 0;

  switch (roomType) {
    case 'single': price = 500; break;
    case 'double': price = 1000; break;
    case 'deluxe': price = 2000; break;
    case 'suite': price = 3500; break;
  }

  priceField.value = price.toFixed(2);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
