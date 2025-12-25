<?php
session_start();
require_once "config.php";

// Session timeout = 5 minutes
$timeout = 300;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("location: login.php");
    exit();
}

$_SESSION['last_activity'] = time();

// Already logged in?
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["role"] === "student") {
        header("location: studentdashboard.html");
    } else {
        header("location: teacher_dashboard.html");
    }
    exit();
}

// Variables
$email = $password = "";
$email_err = $password_err = "";

// Form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Email check
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Password check
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate form
    if (empty($email_err) && empty($password_err)) {

        $sql = "SELECT id, email, password, role FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {

                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $role);

                    if (mysqli_stmt_fetch($stmt)) {

                        // Verify password
                        if (password_verify($password, $hashed_password)) {

                            // Start session and set variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = $role;

                            // Redirect based on role
                            if ($role === "student") {
                                header("location: studentdashboard.html");
                            } else {
                                header("location: teacher_dashboard.html");
                            }
                            exit;

                        } else {
                            $password_err = "Invalid password.";
                        }
                    }

                } else {
                    $email_err = "No account found with that email.";
                }

            } else {
                echo "Something went wrong. Try again.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="wrapper">
    <h2>Login</h2>
    <p>Please enter your credentials.</p>

    <form action="" method="post">

        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>

        <p>Don't have an account? <a href="registration.php">Sign up now</a></p>
    </form>
</div>

</body>
</html>
