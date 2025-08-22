<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Project ID not provided.");
}

$project_id = $_GET['id'];
$msg = "";

// Get current project data
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    die("Project not found.");
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = $_POST["projectname"];
    $status = $_POST["status"];
    $deadline = $_POST["deadline"];

    $update = $conn->prepare("UPDATE projects SET project_name = ?, status = ?, deadline = ? WHERE id = ?");
    $update->bind_param("sssi", $project_name, $status, $deadline, $project_id);

    if ($update->execute()) {
        $msg = "✅ Project updated successfully.";
        // Refresh project data
        $project['project_name'] = $project_name;
        $project['status'] = $status;
        $project['deadline'] = $deadline;
        // Log the update activity
        $activity_description = "Updated project: '$project_name' (Status: $status)";
        $activity_stmt = $conn->prepare("INSERT INTO activities (user_id, description) VALUES (?, ?)");
        $activity_stmt->bind_param("is", $_SESSION['user_id'], $activity_description);
        $activity_stmt->execute();
        $activity_stmt->close();


    } else {
        $msg = "❌ Failed to update project.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
    <link rel="stylesheet" href="admineditproject.css">
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
            <h2>Edit Project</h2>
                
                <?php if (!empty($msg)) : ?>
                    <p class="phpmsg"><?php echo $msg; ?></p>
                <?php endif; ?>
                
            <form method="POST">
                <label>Project Name:</label><br>
                <input type="text" name="projectname" value="<?php echo htmlspecialchars($project['project_name']); ?>" required><br><br>

                <label>Status:</label><br>
                <select name="status">
                    <option value="Pending" <?php if ($project['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="In Progress" <?php if ($project['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                    <option value="Completed" <?php if ($project['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                </select><br><br>

                <label>Deadline:</label><br>
                <input type="date" name="deadline" value="<?php echo $project['deadline']; ?>" required><br><br>

                <button type="submit" id="addprojectbtn">Update Project</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>
