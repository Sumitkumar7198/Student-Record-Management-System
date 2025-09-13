<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            header("Location: index.php");
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SRMS</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        a{
            font-size:15px;
            font-family:sainsarif;
            color:green;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔑Login to SRMS</h2>
        <form method="POST">
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit"> Admin Login</button>
            <i><a class="link" href="Fac_login.php">Faculty Login</a></i>
        </form>
    </div>
</body>
</html>
