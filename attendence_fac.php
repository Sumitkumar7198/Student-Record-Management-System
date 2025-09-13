<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance - SRMS</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="register.php">Register Student</a>
        <a href="attendence_fac.php" class="active">Mark Attendance</a>
        <a href="attendance_report.php">View Attendance</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="form-container">
        <h2>Mark Attendance for All Students</h2>
        <form method="POST">
            <label>Select Date:</label>
            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>

            <label>Select Subject:</label>
            <select name="subject" required>
    
                <option value="SPM">SPM</option>
               
            </select>

            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Attendance Status</th>
                    <th>Lecture Hours</th>
                </tr>
                <?php
                include 'db_config.php';
                $result = $conn->query("SELECT * FROM students");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>
                                <select name='attendance[{$row['student_id']}][status]' required>
                                    <option value='Present'>Present</option>
                                    <option value='Absent'>Absent</option>
                                    <option value='Late'>Late</option>
                                </select>
                            </td>
                            <td>
                                <input type='number' name='attendance[{$row['student_id']}][hours]' min='1' max='6' required placeholder='Enter hours'>
                            </td>
                          </tr>";
                }
                ?>
            </table>

            <button type="submit">Mark Attendance</button>
        </form>
    </div>
</body>
</html>

<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $subject = $_POST['subject'];
    $attendance = $_POST['attendance'];

    foreach ($attendance as $student_id => $data) {
        $status = $data['status'];
        $hours = $data['hours'];

        // Check if the same student has already marked attendance for this subject on this date
        $check = $conn->query("SELECT * FROM attendance WHERE student_id = '$student_id' AND date = '$date' AND subject = '$subject'");
        
        if ($check->num_rows > 0) {
            echo "<script>alert('Attendance for student ID $student_id for this subject on this date is already marked!');</script>";
        } else {
            $sql = "INSERT INTO attendance (student_id, date, status, subject, hours) VALUES ('$student_id', '$date', '$status', '$subject', '$hours')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Attendance recorded successfully for student ID $student_id!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        }
    }
}
?>