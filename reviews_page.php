<?php
session_start();
include 'db_connection.php';

$limit = 4;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$totalResult = $conn->query("SELECT COUNT(*) as total FROM reviews");
$totalReviews = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalReviews / $limit);

$stmt = $conn->prepare("SELECT * FROM reviews ORDER BY submitted_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$reviews = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Reviews | Royal Hotel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-body-secondary">

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
          $active = basename($_SERVER['PHP_SELF']) == $file ? 'active' : '';
          echo "<li class='nav-item'>
                  <a class='nav-link d-flex align-items-center $active' href='$file'>
                    <i class='bi $icon me-2'></i> $label
                  </a>
                </li>";
        }
        ?>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="logout.php">
            <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<section class="py-5 bg-primary text-white text-center">
  <div class="container">
    <h1 class="display-5 fw-bold">Guest Reviews</h1>
    <p class="lead">See what our guests say about their stay at Royal Hotel</p>
  </div>
</section>

<!-- Reviews Section -->
<div class="container my-5">
  <h2 class="text-center mb-4 fw-bold text-dark">What Our Guests Say</h2>

  <?php if ($reviews->num_rows > 0): ?>
    <div class="row g-4">
      <?php while ($review = $reviews->fetch_assoc()): ?>
        <div class="col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                  <?= strtoupper(substr($review['full_name'], 0, 1)) ?>
                </div>
                <div>
                  <h5 class="mb-0"><?= htmlspecialchars($review['full_name']) ?></h5>
                  <small class="text-muted"><?= ucfirst($review['room_type']) ?> Room</small>
                </div>
              </div>

              <?php
                $reviewId = $review['id'];
                $isLong = strlen($review['review']) > 250;
                $shortText = nl2br(htmlspecialchars(substr($review['review'], 0, 250)));
                $fullText = nl2br(htmlspecialchars($review['review']));
              ?>

              <p class="card-text <?= $isLong ? '' : 'mb-3' ?>">
                <?= $isLong ? $shortText . '...' : $fullText ?>
              </p>

              <?php if ($isLong): ?>
                <div class="collapse" id="fullReview<?= $reviewId ?>">
                  <p class="card-text"><?= $fullText ?></p>
                </div>
                <a class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" href="#fullReview<?= $reviewId ?>" role="button" aria-expanded="false" aria-controls="fullReview<?= $reviewId ?>">
                  Read more
                </a>
              <?php endif; ?>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="bi <?= $i <= $review['rating'] ? 'bi-star-fill text-warning' : 'bi-star text-muted' ?>"></i>
                  <?php endfor; ?>
                </div>
                <small class="text-muted"><?= date('d M Y', strtotime($review['submitted_at'])) ?></small>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <nav aria-label="Review pagination" class="mt-5">
      <ul class="pagination justify-content-center">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
        </li>
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
          <li class="page-item <?= $p == $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
        </li>
      </ul>
    </nav>

  <?php else: ?>
    <div class="alert alert-info text-center">
      No reviews found.
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

<?php
$stmt->close();
$conn->close();
?>
