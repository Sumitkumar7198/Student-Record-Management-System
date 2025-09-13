<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $program = $_POST['program'];
    $course = $_POST['course'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];

    // Update the student data in the database
    $stmt = $conn->prepare("UPDATE students SET name = ?, roll_no = ?, program = ?, course = ?, contact = ?, dob = ? WHERE student_id = ?");
    $stmt->bind_param("ssssssi", $name, $roll_no, $program, $course, $contact, $dob, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Student data updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error updating student data: " . $conn->error . "');</script>";
    }

    $stmt->close();
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Student not found!'); window.location.href='index.php';</script>";
        exit();
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student - SRMS</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Update Student</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['student_id']); ?>">
            <label>Full Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>

            <label>Roll No:</label>
            <input type="text" name="roll_no" value="<?php echo htmlspecialchars($row['roll_no']); ?>" required>

            <label>Program:</label>
            <input type="text" name="program" value="<?php echo htmlspecialchars($row['program']); ?>" required>

            <label>Course:</label>
            <input type="text" name="course" value="<?php echo htmlspecialchars($row['course']); ?>" required>

            <label>Contact:</label>
            <input type="text" name="contact" value="<?php echo htmlspecialchars($row['contact']); ?>" required>

            <label>Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo htmlspecialchars($row['dob']); ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>