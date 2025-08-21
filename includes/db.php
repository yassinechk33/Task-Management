<?php
// Database configuration
$host = "localhost";
$db_user = "root";
$db_pass = ""; // default for XAMPP
$db_name = "client_portal_db";

/*// Create connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/
$conn = new mysqli('db', 'user', 'password', 'client_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
