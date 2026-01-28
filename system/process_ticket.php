<?php
/*
===========================================
? Support Ticket Processing Module
===========================================
*/

require_once "../includes/header.php";
require_once "../includes/access.php";
require_once "../config/database.php";

// just user authentication check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ticket'])) {
    
    // input sanitization
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $ticket_id = "TIC-" . strtoupper(substr(md5(time()), 0, 8));

    if (empty($subject) || empty($message)) {
        $error_msg = "Please fill in all required fields.";
    } else {
        $query = "INSERT INTO support_tickets (ticket_id, user_id, subject, priority, category, message, status, created_at) 
                  VALUES ('$ticket_id', '$user_id', '$subject', '$priority', '$category', '$message', 'Open', NOW())";

        if (mysqli_query($conn, $query)) {
            $success_msg = "Ticket #$ticket_id has been created successfully!";
        } else {
            $error_msg = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket | TMS</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <style>
        :root {
            --primary: #2563eb;
            --bg-glass: rgba(255, 255, 255, 0.7);
            --border: rgba(0, 0, 0, 0.1);
            --text: #1e293b;
        }

        [data-theme="dark"] {
            --bg-glass: rgba(15, 23, 42, 0.8);
            --border: rgba(255, 255, 255, 0.1);
            --text: #f8fafc;
        }

        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: var(--text);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .ticket-container {
            max-width: 700px;
            width: 100%;
            background: var(--bg-glass);
            backdrop-filter: blur(15px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .header h2 { margin-top: 0; color: var(--primary); }

        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.2);
            color: var(--text);
            box-sizing: border-box;
            font-size: 1rem;
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            transition: 0.3s;
        }

        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="header">
        <h2>📩 Open a Support Ticket</h2>
        <p>Need help? Submit your query and we'll get back to you soon.</p>
    </div>

    <?php if($success_msg): ?>
        <div class="alert success"><?= $success_msg ?></div>
    <?php endif; ?>

    <?php if($error_msg): ?>
        <div class="alert error"><?= $error_msg ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" placeholder="Summary of the issue" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="Technical">Technical Issue</option>
                    <option value="Billing">Billing/Tender Fee</option>
                    <option value="Account">Account Access</option>
                    <option value="General">General Query</option>
                </select>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Urgent">Urgent</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Detailed Description</label>
            <textarea name="message" rows="5" placeholder="Describe your problem in detail..." required></textarea>
        </div>

        <button type="submit" name="submit_ticket" class="btn-submit">Submit Ticket</button>
    </form>
    
    <div style="text-align: center; margin-top: 20px;">
        <a href="dashboard.php" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">← Back to Dashboard</a>
    </div>
</div>

<script>
    // System theme sync
    document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');
</script>

</body>
</html>