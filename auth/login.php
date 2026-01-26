<?php
/*
* Filename: login.php
* Description: Authenticates users and sets session variables.
*/
require_once "../config/database.php";

session_start();

// *Send directly to the dashboard if the user is logged in.
if(isset($_SESSION['user_id'])){
    header("Location: ../dashboard/dashboard.php");
    exit;
}

$message = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $safe_email = mysqli_real_escape_string($conn, $email);

    // *Fetch user and role information
    $sql = "SELECT u.*, r.role_name 
            FROM users u 
            LEFT JOIN roles r ON u.role_id = r.id 
            WHERE u.email='$safe_email' LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Database Query Failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // *Password verification
        if (password_verify($password, $user['password'])) {
            
            // *1. Update last login time (now in the correct place)
            $user_id = $user['id']; 
            $login_query = "UPDATE users SET last_login = NOW() WHERE id = '$user_id'";
            mysqli_query($conn, $login_query);

            // *2. Set session variables
            $_SESSION['user_id']      = $user['id'];
            $_SESSION['user_name']    = $user['full_name'];
            $_SESSION['username']     = $user['username'];
            $_SESSION['role_id']      = $user['role_id'];
            $_SESSION['role_name']    = $user['role_name'] ?? 'User';
            
            $_SESSION['profile_pic']  = $user['profile_picture'] ?? ''; 

            // *Redirect
            header("Location: ../dashboard/dashboard.php");
            exit;
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "No account found with that email.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tender Management System</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <style>
        @import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
    </style>
</head>
<body>

<div class="auth-card login-card">
    <h2>User Login</h2>
    
    <?php if($message != ""): ?>
        <div class="msg-box">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="login-form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="login-form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="form-actions">
            <button type="submit" name="login">Login Account</button>
            <button type="button" id="themeToggle" class="theme-switch-btn">🌙 Dark Mode</button>
            
            <p class="footer-text">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </div>
    </form>
</div>

<script src="../assets/js/auth.js"></script>
</body>
</html>