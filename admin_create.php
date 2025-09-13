<?php
include 'db_config.php';

$username = "admin";
$password = password_hash("admin123", PASSWORD_BCRYPT);
$role = "admin";

$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
