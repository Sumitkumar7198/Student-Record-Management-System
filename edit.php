<?php
session_start();
include 'db_config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM students WHERE id=$id");
    $row = $result->fetch_assoc();
} else {
    die("No ID provided.");
}
?>

<h2>Update Student</h2>
<form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
    Roll No: <input type="text" name="roll_no" value="<?php echo $row['roll_no']; ?>"><br>
    Program: <input type="text" name="program" value="<?php echo $row['program']; ?>"><br>
    Course: <input type="text" name="course" value="<?php echo $row['course']; ?>"><br>
    Contact: <input type="text" name="contact" value="<?php echo $row['contact']; ?>"><br>
    DOB: <input type="date" name="dob" value="<?php echo $row['dob']; ?>"><br>
    <input type="submit" value="Update">
</form>