<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["profile_image"])) {
    $imageName = $_FILES["profile_image"]["name"];
    $tmpName = $_FILES["profile_image"]["tmp_name"];
    $uploadPath = "uploads/" . basename($imageName);

    if (move_uploaded_file($tmpName, $uploadPath)) {
        $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        $stmt->bind_param("si", $imageName, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin/admin_dashboard.php"); // redirect back
        exit;
    } else {
        $msg = "❌ Failed to upload.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Upload Profile Image</title>
  <link rel="stylesheet" href="upload_profile.css">
</head>
<body>
  <form method="post" enctype="multipart/form-data">
    <h2>Upload Your Profile Image</h2>
    <input type="file" name="profile_image" required><br><br>
    <button type="submit">Upload</button>
  </form>
  <p><?php echo $msg; ?></p>
</body>
</html>
