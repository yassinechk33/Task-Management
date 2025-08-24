<?php
    session_start();
    require_once '../includes/db.php';

    if (!isset($_SESSION["user_id"])) {
        header("Location: index.php");
        exit;
    }

    $msg="";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file_to_upload"])) {
        
        $uploaded_by = $_SESSION["username"];
        $filename = $_FILES["file_to_upload"]["name"];
        $filepath = "../upload_files/" . basename($filename);
        $public_path = "upload_files/" . basename($filename);

        if(move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $filepath)) {

            $stmt = $conn->prepare("insert into upload_files (filename, filepath, uploaded_by) values (?, ?, ?)");
            $stmt->bind_param("sss", $filename, $public_path, $uploaded_by);
            $stmt->execute();
            $stmt->close();
        
        } else {
            $msg = "❌ Failed to upload.";
        }

    }

    $result = $conn->query("SELECT uploaded_by, uploaded_at, filename, filepath FROM upload_files");


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload - Download</title>
    <link rel="stylesheet" href="admin_files_upload.css">
</head>
<body>
  <div class="layout">
    <nav class="sidebar">
      <h2 class="navtop">Admin</h2>
      <a class="active" href="admin_dashboard.php">Dashboard</a>
      <a href="admin_projects.php">Projects</a>
      <a href="admin_add_project.php">Add Project</a>
      <a href="admin_clients.php">Clients</a>
      <a href="admin_files_upload.php">Upload Files</a>
      <a href="../contact_page.php">Contact us</a>
      <a href="#">Settings</a>
    </nav>

    <main class="main-content">
        <div class="container">
            <div class="container-upload">
                <h1>Upload</h1>
                <form method="POST" action="admin_files_upload.php" enctype="multipart/form-data">
                    <div class="form-input">
                        <input type="file" name="file_to_upload" required>
                    </div>
                    <div class="form-btn">
                        <button type="submit">Upload File</button>
                    </div>
                </form>
                <p><?php echo $msg; ?></p>
            </div>
            <div class="borderleft"></div>
            <div class="container-download">
                <h1>Download</h1>
                <table>
                    <tr>
                        <th>Uploaded-By</th>
                        <th>Uploaded-At</th>
                        <th>File-Name</th>
                        <th>File-Path</th>
                    </tr>
                        <?php while($row = $result->fetch_assoc()):?>
                    <tr>
                            <td><?php echo htmlspecialchars($row["uploaded_by"]); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row['uploaded_at'])); ?></td>
                            <td><?php echo htmlspecialchars($row["filename"]); ?></td>
                            <td><a href="<?php echo htmlspecialchars($row["filepath"]) ?>">Download</a></td>
                    </tr>
                        <?php endwhile; ?>
                </table>
            </div>
        </div>
    </main>
  </div>
</body>
</html>