<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student - SRMS</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Dashboard</a>
        <a href="register.php" class="active">Register Student</a>
        <a href="attendance.php">Mark Attendance</a>
        <a href="attendance_report.php">View Attendance</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="form-container">
        <h2>Register New Student</h2>
        <form method="POST">
            <label>Full Name:</label>
            <input type="text" name="name" required placeholder="Enter full name">

            <label>Roll No:</label>
            <input type="text" name="rollno" required placeholder="Enter roll no">

            <label>Date of Birth:</label>
            <input type="date" name="dob" required>

            <label>Contact:</label>
            <input type="text" name="contact" required placeholder="Enter contact number">

            <label>Program:</label>
            <input type="text" name="program" required placeholder="Enter program name">

            <label>Course:</label>
            <select name="course" required>
                <option value="Computer Science">Computer Science</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Electronics Engineering">Electronics Engineering</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
                <option value="Civil Engineering">Civil Engineering</option>
            </select>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $roll=$_POST['rollno'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $program = $_POST['program'];
    $course = $_POST['course'];
  

    $sql = "INSERT INTO students (name,roll_no,program,course,contact,dob) VALUES ('$name', '$roll', '$program', '$course','$contact','$dob')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student registered successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>
