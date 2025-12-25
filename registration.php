<?php
require "config.php"; // Use your config file

// Create users table if not exists (optional but cleaner)
$create_table_query = "
CREATE TABLE IF NOT EXISTS users (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    college_name VARCHAR(100),
    gender VARCHAR(10),
    role VARCHAR(10),
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    year INT(2)
)";
$link->query($create_table_query);

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Escape values to prevent SQL injection
    $first_name  = $link->real_escape_string($_POST['firstname']);
    $last_name   = $link->real_escape_string($_POST['lastname']);
    $college_name = $link->real_escape_string($_POST['collegename']);
    $gender      = $link->real_escape_string($_POST['gender']);
    $role        = $link->real_escape_string($_POST['role']);
    $email       = $link->real_escape_string($_POST['email']);
    $year        = isset($_POST['year']) ? intval($_POST['year']) : NULL;

    // Hash password (important!)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if user already exists
    $check = $link->query("SELECT email FROM users WHERE email='$email'");

    if ($check->num_rows > 0) {
        header("Location: login.php");
        exit();
    }

    // Insert user
    $insert = $link->prepare("INSERT INTO users 
        (first_name, last_name, college_name, gender, role, email, password, year)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssssssi", $first_name, $last_name, $college_name, $gender, $role, $email, $password, $year);
    $insert->execute();

    // Redirect based on role
    if ($role == "student") {
        header("Location: studentdashboard.html");
    } else {
        header("Location: teacher_dashboard.html");
    }

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Skill Tube</title>
    <link rel="stylesheet" href="rstyle.css"> 

    <script>
        function toggleStudentInfo() {
            let role = document.getElementById('role').value;
            document.getElementById('student-info').style.display =
                role === 'student' ? 'block' : 'none';
        }
    </script>
</head>
<body>

    <h1>Registration Form</h1>

    <form action="" method="post">
        <div class="overlay"></div>

        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="firstname" required>
        </div><br/>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lastname" required>
        </div><br/>

        <div class="form-group">
            <label>College Name:</label>
            <input type="text" name="collegename" required>
        </div><br/>

        <div class="form-group">
            <label>Gender:</label>
            <input type="radio" name="gender" value="male" required> Male
            <input type="radio" name="gender" value="female"> Female
            <input type="radio" name="gender" value="other"> Other
        </div><br/>

        <div class="form-group">
            <label>Are you a Teacher or Student?</label>
            <select name="role" id="role" onchange="toggleStudentInfo()" required>
                <option value="">Select</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
        </div><br/>

        <div class="form-group">
            <label>Email Address:</label>
            <input type="email" name="email" required>
        </div><br/>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div><br/>

        <div id="student-info" class="form-group" style="display:none;">
            <label>Year of Engineering:</label>
            <input type="number" name="year" min="1" max="4">
        </div><br/>

        <button type="submit" class="btn">Register</button>
    </form>

</body>
</html>
