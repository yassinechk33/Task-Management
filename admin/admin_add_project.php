<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

$msg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["client"];
    $project_name = $_POST["projectname"];
    $status = $_POST["status"];
    $deadline = $_POST["deadline"];

    $stmt = $conn->prepare("INSERT INTO projects (user_id, project_name, status, deadline) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $project_name, $status, $deadline);

    if ($stmt->execute()) {
        $msg = "✅ Project assigned successfully.";
        // Log activity
        $activity_description = "Assigned new project: '$project_name' to user ID $user_id (Status: $status)";
        $log_stmt = $conn->prepare("INSERT INTO activities (user_id, description) VALUES (?, ?)");
        $log_stmt->bind_param("is", $_SESSION['user_id'], $activity_description);
        $log_stmt->execute();
        $log_stmt->close();

    } else {
        $msg = "❌ Failed to assign project.";
    }
}

// Fetch all clients for the dropdown
$clients = $conn->query("SELECT id, username FROM users WHERE role = 'client'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Add Project</title>
  <link rel="stylesheet" href="adminaddproject.css">
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
        <h2>Assign Project to Client</h2>

        <?php if (!empty($msg)) : ?>
          <p id="phpmsg" style="color: white;"><?php echo $msg; ?></p>
        <?php endif; ?>

        <form action="admin_add_project.php" method="post">
          <label for="client">Client</label>
          <select name="client" id="client" required>
            <option value="">Select a client</option>
            <?php while ($row = $clients->fetch_assoc()) : ?>
              <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?></option>
            <?php endwhile; ?>
          </select>

          <label for="projectname">Project Name</label>
          <input type="text" name="projectname" id="projectname" required>

          <label for="status">Status</label>
          <select name="status" id="status">
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
          </select>

          <label for="Deadline">Deadline</label>
          <input type="date" name="deadline" id="deadline" required>
          <button id="addprojectbtn" name="addprojectbtn" type="submit">Add Project</button>
        </form>

    </div>
    </main>
  </div>
</body>
</html>
