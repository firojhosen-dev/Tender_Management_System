<?php
/*
===========================================
* Filename: register.php
* Description: Registration with dynamic Role selection from the database.
===========================================
*/
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access
// session_start();

$message = "";
$message_type = "";

// Fetch available roles from the database for the dropdown
$roles_query = mysqli_query($conn, "SELECT * FROM roles");

if (isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $username  = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password  = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role_id   = mysqli_real_escape_string($conn, $_POST['role_id']); // Selected role

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = "red";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' OR username='$username'");
        
        if (mysqli_num_rows($check) > 0) {
            $message = "Email or Username already exists.";
            $message_type = "red";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (full_name, username, email, password, role_id) 
                    VALUES ('$full_name', '$username', '$email', '$hashed_password', '$role_id')";

            if (mysqli_query($conn, $sql)) {
                $message = "Registration successful! <a href='login.php'>Login here</a>";
                $message_type = "green";
            } else {
                $message = "Database Error: " . mysqli_error($conn);
                $message_type = "red";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Tender Management System</title>
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

<div class="auth-card">
    <h2>Create Account</h2>
    
    <?php if($message != ""): ?>
        <div class="msg-box" style="color: <?= $message_type ?>; border: 1px solid <?= $message_type ?>; padding:10px; margin-bottom:15px; border-radius:10px; text-align:center;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-grid">
            <div class="left-col">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="right-col">
                <div class="form-group">
                    <label>Select Your Role</label>
                    <select name="role_id" required>
                        <option value="">-- Choose Role --</option>
                        <?php 
                        mysqli_data_seek($roles_query, 0); 
                        while($row = mysqli_fetch_assoc($roles_query)): 
                        ?>
                            <option value="<?= $row['id'] ?>"><?= $row['role_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="register">Register Account</button>
            <button type="button" id="themeToggle" class="theme-switch-btn">🌙 Dark Mode</button>
            
            <p class="footer-text">
                Already have an account? <a href="login.php" style="color: var(--primary); text-decoration:none; font-weight:bold;">Login</a>
            </p>
        </div>
    </form>
</div>

<script src="../assets/js/auth.js"></script>



<!-- 
    This is a placeholder for future comments or documentation.
    It can be used to add notes about the registration form or any other relevant information.
-->



</body>
</html>

