<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

// Fetch all clients from DB
$clients = $conn->query("SELECT id, username, email, status ,created_at FROM users WHERE role = 'client'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Clients</title>
  <link rel="stylesheet" href="adminclients.css">
</head>
<body>
<div class="layout">
  <nav class="sidebar">
      <h2 class="navtop">Admin</h2>
      <a class="active" href="admin_dashboard.php">Dashboard</a>
      <a href="admin_projects.php">Projects</a>
      <a href="admin_add_project.php">Add Project</a>
      <a href="admin_clients.php">Clients</a>
      <a href="../contact_page.php">Contact us</a>
      <a href="#">Settings</a>
  </nav>

  <main class="main-content">
    <div class="container">
      <h2>All Clients</h2>

      <table class="clients-table">
        <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Created</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $clients->fetch_assoc()) : ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
              <span class="status <?php echo strtolower(trim($row['status'])); ?>">
                <?php echo $row['status']; ?>
              </span>
            </td>
            <td><?php echo date("d-m-Y", strtotime($row['created_at'])); ?></td>
            <td>
              <div class="action-btns">
                <span>👁 View</span>
                <span>✏️ Edit</span>
                <span>🗑 Delete</span>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>
