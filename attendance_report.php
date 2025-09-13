<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Delete Student (Along with Attendance Records)
if (isset($_GET['delete_id'])) {
    $student_id = $_GET['delete_id'];
    $conn->query("DELETE FROM students WHERE student_id = '$student_id'");
    echo "<script>alert('Student and their attendance records deleted successfully!'); window.location.href='attendance_report.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - SRMS</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Dashboard</a>
        <a href="register.php">Register Student</a>
        <a href="attendance.php">Mark Attendance</a>
        <a href="attendance_report.php">View Attendance</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="container">
        <h2>📊 Attendance Report</h2>

        <h3>Student-wise Attendance Percentage</h3>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Total Hours</th>
                <th>Present Hours</th>
                <th>Percentage</th>
                <th>Action</th>
            </tr>
            <?php
            $students = $conn->query("SELECT * FROM students");

            while ($student = $students->fetch_assoc()) {
                $student_id = $student['student_id'];

                // Total Hours for Student
                $total_hours = $conn->query("SELECT SUM(hours) as total FROM attendance WHERE student_id = '$student_id'")->fetch_assoc()['total'] ?? 0;

                // Present Hours for Student
                $present_hours = $conn->query("SELECT SUM(hours) as present FROM attendance WHERE student_id = '$student_id' AND status = 'Present'")->fetch_assoc()['present'] ?? 0;

                // Calculate Percentage
                $percentage = ($total_hours > 0) ? ($present_hours / $total_hours) * 100 : 0;
                $percentage = round($percentage, 2);

                echo "<tr>
                        <td>{$student['name']}</td>
                        <td>{$total_hours}</td>
                        <td>{$present_hours}</td>
                        <td>{$percentage}%</td>
                        <td><a href='attendance_report.php?delete_id={$student_id}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this student?\")'>❌ Delete</a></td>
                      </tr>";
            }
            ?>
        </table>

        <h3>📋 Detailed Attendance Records</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Date</th>
                <th>Subject</th>
                <th>Hours</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $result = $conn->query("SELECT attendance.attendance_id, students.name, attendance.date, attendance.status, attendance.subject, attendance.hours 
                                    FROM attendance 
                                    INNER JOIN students ON attendance.student_id = students.student_id 
                                    ORDER BY attendance.date DESC");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['attendance_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['date']}</td>
                            <td>{$row['subject']}</td>
                            <td>{$row['hours']}</td>
                            <td>{$row['status']}</td>
                            <td><a href='attendance_report.php?delete_attendance={$row['attendance_id']}' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>❌ Delete</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No attendance records found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
