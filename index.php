<?php
session_start();
require_once 'includes/db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password, role, profile_image FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password, $role, $profile_image);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;
            $_SESSION["profile_image"] = $profile_image;

            
            header("Location: admin/admin_dashboard.php");
            
            exit;
        } else {
            $msg = "❌ Invalid password.";
        }
    } else {
        $msg = "❌ Email not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Client Portal</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <h2>Client Login</h2>
        <form action="index.php" method="post">
            <?php if (!empty($msg)) : ?>
                <p class="message"><?php echo $msg; ?></p>
            <?php endif; ?>

            <input type="email" id="email" name="email" required placeholder="Email">
            <input type="password" id="password" name="password" required placeholder="Password">
            
            <button type="submit" id="regitsterbtn" >Login</button>
            <p id="linktoregisterpage" >Don't have an account yet<br><a id="linktoregisterpage2" href="register.php"> create one </a> </p>

        </form>
    </div>
</body>
</html>