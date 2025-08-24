<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$msg = "";

// Handle form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        if ($stmt->execute()) {
            $msg = "✅ Message sent successfully!";
        } else {
            $msg = "❌ Failed to send message.";
        }
    } else {
        $msg = "⚠️ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us</title>
  <link rel="stylesheet" href="contact_page.css">
</head>
<body>
  <div class="layout">
    <nav class="sidebar">
      <h2 class="navtop">Admin</h2>
      <a class="active" href="admin/admin_dashboard.php">Dashboard</a>
      <a href="admin/admin_projects.php">Projects</a>
      <a href="admin/admin_add_project.php">Add Project</a>
      <a href="admin/admin_clients.php">Clients</a>
      <a href="admin/admin_files_upload.php">Upload Files</a>
      <a href="contact_page.php">Contact us</a>
      <a href="#">Settings</a>
    </nav>

  <main class="main-content">
    <div class="container">
      <h2>Contact Us</h2>

      <?php if (!empty($msg)) : ?>
        <p id="phpmsg"><?php echo $msg; ?></p>
      <?php endif; ?>

      <form method="POST" action="contact_page.php" class="contact-form">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Subject</label>
        <input type="text" name="subject" required>

        <label>Message</label>
        <textarea name="message" rows="5" required></textarea>

        <button type="submit" id="addprojectbtn">Send Message</button>
      </form>
    </div>
  </main>
</div>
</body>
</html>
