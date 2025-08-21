<?php
session_start();
require_once '../includes/db.php';



// Total clients
$clients_result = $conn->query("SELECT COUNT(*) AS total_clients FROM users WHERE role = 'client'");
$total_clients = $clients_result->fetch_assoc()['total_clients'];

// Total projects
$projects_result = $conn->query("SELECT COUNT(*) AS total_projects FROM projects");
$total_projects = $projects_result->fetch_assoc()['total_projects'];

// Completed projects
$completed_result = $conn->query("SELECT COUNT(*) AS completed_projects FROM projects WHERE status = 'completed'");
$completed_projects = $completed_result->fetch_assoc()['completed_projects'];

// In progress projects
$progress_result = $conn->query("SELECT COUNT(*) AS progress_projects FROM projects WHERE status = 'in progress'");
$progress_projects = $progress_result->fetch_assoc()['progress_projects'];

function logActivity($conn, $user_id, $description) {
    $stmt = $conn->prepare("INSERT INTO activities (user_id, description) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $description);
    $stmt->execute();
    $stmt->close();
}


// Fetch username from database
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT username, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $profileImage);
$stmt->fetch();
$stmt->close();

// Store it in session if needed
$_SESSION["user_name"] = $username;

// Fetch latest 5 activity logs
$activity_query = $conn->query("
  SELECT a.description, a.created_at, u.username 
  FROM activities a 
  JOIN users u ON a.user_id = u.id 
  ORDER BY a.created_at DESC 
  LIMIT 5
");


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Dashboard</title>
  <link rel="stylesheet" href="admindashboard.css">
  <!-- FullCalendar CSS -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

    </script>
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

        <div class="top">
          <div class="welcome">
            <a href="../upload_profile.php" class="profile-wrapper">
              <img src="../uploads/<?php echo htmlspecialchars($profileImage ?: 'default.png'); ?>" alt="Profile" class="profile-img">
              <div class="hover-text">Upload Image</div>
            </a>
            <h1>Welcome 👋 <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?> </h1>
          </div>


            <div class="top-actions">
              <input class="search" placeholder="Search…" />
              <button class="logout-btn"><a href="../logout.php">Logout</a></button>
            </div>

          </div>

        <div id="calendar"></div>

        <div class="dashboard-stats">
          <div class="stat-card">
            <a href="admin_clients.php">
              <h3>Total Clients</h3>
              <p><?php echo $total_clients; ?></p>
            </a>
          </div>
          <div class="stat-card">
            <a href="admin_projects.php">
              <h3>Total Projects</h3>
              <p><?php echo $total_projects; ?></p>
            </a>
          </div>
          <div class="stat-card">
            <a href="admin_projects.php">
              <h3>Completed Projects</h3>
              <p><?php echo $completed_projects; ?></p>
            </a>
          </div>
          <div class="stat-card">
            <a href="admin_projects.php">
              <h3>In Progress Projects</h3>
              <p><?php echo $progress_projects; ?></p>
            </a>
          </div>
        </div>

        <div class="activity-feed">
          <h2>🕓 Latest Activity</h2>
          <ul>
            <?php while ($row = $activity_query->fetch_assoc()) : ?>
              <li>
                <strong><?php echo htmlspecialchars($row['username']); ?>:</strong>
                <?php echo htmlspecialchars($row['description']); ?>
                <small style="color: gray; display:block;"><?php echo date("M d, H:i", strtotime($row['created_at'])); ?></small>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>

    </main>
  </div>
</body>
</html>