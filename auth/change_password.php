<?php
/*
==================================================
 Change Password
--------------------------------------------------
 File: change_password.php
 Project: Tender Management System
 Description:
    Allows logged-in users to change their password
    securely by verifying current password.
==================================================
*/

session_start();

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/access.php";

/* ===== AUTH CHECK ===== */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";
$message_type = "";

/* ===== HANDLE FORM SUBMIT ===== */
if (isset($_POST['change_password'])) {

    $current_password = trim($_POST['current_password']);
    $new_password     = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    /* ---- BASIC VALIDATION ---- */
    if ($current_password === "" || $new_password === "" || $confirm_password === "") {
        $message = "All fields are required.";
        $message_type = "error";
    }
    elseif ($new_password !== $confirm_password) {
        $message = "New password and confirm password do not match.";
        $message_type = "error";
    }
    elseif (strlen($new_password) < 6) {
        $message = "New password must be at least 6 characters long.";
        $message_type = "error";
    }
    else {
        /* ---- FETCH CURRENT PASSWORD FROM DB ---- */
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

            /* ---- VERIFY OLD PASSWORD ---- */
            if (!password_verify($current_password, $row['password'])) {
                $message = "Current password is incorrect.";
                $message_type = "error";
            } else {
                /* ---- UPDATE PASSWORD ---- */
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update_sql = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user_id);

                if (mysqli_stmt_execute($update_stmt)) {
                    $message = "Password changed successfully.";
                    $message_type = "success";
                } else {
                    $message = "Something went wrong. Please try again.";
                    $message_type = "error";
                }
            }
        } else {
            $message = "User not found.";
            $message_type = "error";
        }
    }
}
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<style>
:root {
    --primary: #46B5D3;
    --primary-dark: #0D0B63;
    --bg-dark: #160C40;
    --secondary-dark: #151B4D;
    --white: #ffffff;
    --gray-light: #E7DFDF;
    --success: #4CAF50;
    --error: #F44336;
}
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
body {
    background: linear-gradient(135deg, var(--primary-dark), var(--bg-dark));
    margin: 0;
    padding: 0;
}

.change-password-wrapper {
    max-width: 420px;
    margin: 80px auto;
    background: rgba(255,255,255,0.95);
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.change-password-wrapper h2 {
    text-align: center;
    margin-bottom: 25px;
    color: var(--secondary-dark);
}

.form-group {
    margin-bottom: 18px;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--secondary-dark);
}

input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid var(--gray-light);
    outline: none;
    font-size: 14px;
}

input:focus {
    border-color: var(--primary);
}

button {
    width: 100%;
    padding: 14px;
    background: var(--primary);
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    color: var(--secondary-dark);
    cursor: pointer;
}

button:hover {
    background: #2fa2c0;
}

.message {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-size: 14px;
    text-align: center;
}

.message.success {
    background: rgba(76,175,80,0.15);
    color: var(--success);
}

.message.error {
    background: rgba(244,67,54,0.15);
    color: var(--error);
}

.back-link {
    display: block;
    margin-top: 20px;
    text-align: center;
    text-decoration: none;
    color: var(--primary-dark);
    font-weight: 500;
}
</style>

<div class="change-password-wrapper">
    <h2>Change Password</h2>

    <?php if ($message != ""): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" required>
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" required>
        </div>

        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>
        </div>

        <button type="submit" name="change_password">
            Change Password
        </button>
    </form>

    <a href="../profile/user_profile.php" class="back-link">
        ← Back to Profile
    </a>
</div>

<?php require_once "../includes/footer.php"; ?>
