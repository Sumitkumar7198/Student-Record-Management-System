<?php
session_start();
include 'db_config.php';

if ($_SESSION['role'] != 'username') {
    echo "<script>alert('Access Denied!');</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SRMS</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Dashboard</a>
        <a href="register.php">Register Student</a>
        <a href="attendance.php">Mark Attendance</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="container">
        <h2>Admin Panel</h2>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>

        <h3>Student List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Roll No</th>
                <th>Name</th>
                <th>Program</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM students");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['roll']}</td>
                        <td>{$row['program']}</td>
                        <td><a href='delete_student.php?id={$row['student_id']}'>Delete</a></td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
