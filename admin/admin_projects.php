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
    $project_id = $_POST["id"];

    // Fetch project name before deleting
    $proj_stmt = $conn->prepare("SELECT project_name FROM projects WHERE id = ?");
    $proj_stmt->bind_param("i", $project_id);
    $proj_stmt->execute();
    $proj_stmt->bind_result($project_name);
    $proj_stmt->fetch();
    $proj_stmt->close();

    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $project_id);

    if ($stmt->execute()) {
        $msg = "✅ Project deleted successfully.";
        // Log activity
        $activity_description = "Deleted project: '$project_name'";
        $log_stmt = $conn->prepare("INSERT INTO activities (user_id, description) VALUES (?, ?)");
        $log_stmt->bind_param("is", $_SESSION['user_id'], $activity_description);
        $log_stmt->execute();
        $log_stmt->close();
    } else {
        $msg = "❌ Failed to delete project.";
    }
}

// Fetch all clients from DB
$Projects = $conn->query("SELECT id, user_id, project_name, status , deadline, file_path, created_at FROM projects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Projects</title>
  <link rel="stylesheet" href="projectslist.css">
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
      <h2>All Projects</h2>

      <table class="Projects-table">
        <thead>
        <tr>
          <th>Id</th>
          <th>User_id</th>
          <th>Name</th>
          <th>Status</th>
          <th>Deadline</th>
          <th>Created_at</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $Projects->fetch_assoc()) : ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
            <td><?php echo htmlspecialchars($row['project_name']); ?></td>
            <td>
              <span class="status <?php echo strtolower(trim($row['status'])); ?>">
                <?php echo $row['status']; ?>
              </span>
            </td>
            <td><?php echo date("d-m-Y", strtotime($row['deadline'])); ?></td>
            <td><?php echo date("d-m-Y", strtotime($row['created_at'])); ?></td>
            <td>
              <div class="action-btns">
                  <form method="get" action="admin_view_project.php" style="display:inline;">
                      <input type="hidden" name="id" value="<?= $row['id']; ?>">
                      <button class="edit-btn">👁 View</button>
                  </form>

                  <form method="get" action="admin_edit_project.php" style="display:inline;">
                      <input type="hidden" name="id" value="<?= $row['id']; ?>">
                      <button class="edit-btn">✏️ Edit</button>
                  </form>

                  <form method="post"  style="display:inline;">
                      <input type="hidden" name="id" value="<?= $row['id']; ?>">
                      <button class="edit-btn">🗑 Delete</button>
                  </form>
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
