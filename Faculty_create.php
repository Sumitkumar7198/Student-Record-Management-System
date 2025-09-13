<?php
include 'db_config.php';

$username = "faculty";
$password = password_hash("fac123", PASSWORD_BCRYPT);
$role = "Faculty";

$sql = "INSERT INTO faculty (username, password, role) VALUES ('$username', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
