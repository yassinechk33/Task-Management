<?php
session_start();
require_once 'includes/db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "❌ Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'client')");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $msg = "✅ Registration successful! You can now <a href='index.php'>log in</a>.";
        } else {
            $msg = "❌ Registration failed.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Client Portal</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <h2>Client Registration</h2>
        <form action="register.php" method="post">
            <?php if (!empty($msg)) : ?>
                <p class="message"><?php echo $msg; ?></p>
            <?php endif; ?>

            <input type="text" id="username" name="username" required placeholder="Username">
            <input type="email" id="email" name="email" required placeholder="Email">
            <input type="password" id="password" name="password" required placeholder="Password">
            <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
            
            <button type="submit" id="regitsterbtn" >Register</button>
            <p id="linktologinpage" >Already have an account <a href="index.php">Log in</a> </p>

        </form>
    </div>
</body>
</html>