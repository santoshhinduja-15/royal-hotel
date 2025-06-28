<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $message = trim($_POST["message"]);

  if (empty($name) || empty($email) || empty($message)) {
    header("Location: contact_page.php?error=emptyfields");
    exit();
  }

  $stmt = $conn->prepare("INSERT INTO contact_messages(name, email, message, created_at) VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("sss", $name, $email, $message);

  if ($stmt->execute()) {
    header("Location: contact_page.php?success=1");
  } else {
    header("Location: contact_page.php?error=sqlerror");
  }

  $stmt->close();
  $conn->close();
} else {
  // Redirect if accessed directly
  header("Location: contact_page.php");
  exit();
}
?>
