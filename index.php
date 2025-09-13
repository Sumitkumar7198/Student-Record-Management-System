<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Count total students
$total_students = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'] ?? 0;

// Count total attendance records
$total_attendance = $conn->query("SELECT COUNT(*) as total FROM attendance")->fetch_assoc()['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SRMS</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="active">Dashboard</a>
        <a href="register.php">Register Student</a>
        <a href="attendance.php">Mark Attendance</a>
        <a href="attendance_report.php">View Attendance</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="dashboard-container">
        <h1>🎓 Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Manage students and their attendance efficiently.</p>

        <div class="stats">
            <div class="stat-box">
                <h2>Total Students</h2>
                <p><?php echo $total_students; ?></p>
            </div>
            <div class="stat-box">
                <h2>Total Attendance Records</h2>
                <p><?php echo $total_attendance; ?></p>
            </div>
        </div>

        <h2>📌 Student List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Roll</th>
                <th>Program</th>
                <th>Course</th>
                <th>Contact</th>
                <th>Date of Birth</th>
                <th>Action</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM students ORDER BY student_id DESC");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['student_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['roll_no']}</td>
                            <td>{$row['program']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['contact']}</td>
                            <td>{$row['dob']}</td>
                            <td>
                                <a href='update.php?id={$row['student_id']}' class='delete-btn'>Update</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No students found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
