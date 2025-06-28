<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$registered = isset($_GET['registered']) && $_GET['registered'] === 'success';
$errorType = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Royal Hotel</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Optional blur support -->
  <style>
    .backdrop-blur {
      backdrop-filter: blur(10px);
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100 text-light" style="background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1500&q=80') center/cover no-repeat;">

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

<!-- Registration Form Section -->
<section class="flex-grow-1 d-flex align-items-center justify-content-center">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">

        <div class="card bg-white bg-opacity-75 backdrop-blur text-dark shadow border-0">
          <div class="card-body p-4">
            <h2 class="text-center fw-bold mb-3">Create Your Account</h2>

            <!-- Alerts -->
            <?php if ($registered): ?>
              <div class="alert alert-success text-center">🎉 Registration successful!</div>
            <?php elseif ($errorType === 'exists'): ?>
              <div class="alert alert-warning text-center">⚠️ User already exists.</div>
            <?php elseif ($errorType === 'validation'): ?>
              <div class="alert alert-danger text-center">❌ Invalid data. Please check your inputs.</div>
            <?php elseif ($errorType === 'unknown'): ?>
              <div class="alert alert-danger text-center">❌ Something went wrong. Please try again.</div>
            <?php endif; ?>

            <!-- Form -->
            <form action="register_handler.php" method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required minlength="3">
              </div>

              <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile" name="mobile" required pattern="\d{10}">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              <div class="mb-3">
                <label for="role" class="form-label">Register As</label>
                <select class="form-select" name="role" required>
                  <option value="">Select Role</option>
                  <option value="customer">Customer</option>
                  <option value="admin">Admin</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       required
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
                       title="Minimum 6 characters with uppercase, lowercase, and number">
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Register</button>
              </div>
            </form>

            <div class="text-center mt-4">
              <p class="mb-1">Already have an account?</p>
              <a href="login.php" class="btn btn-outline-secondary">Login</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark bg-opacity-75 text-center text-white py-3">
  <p class="mb-0">© 2025 Royal Hotel. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
