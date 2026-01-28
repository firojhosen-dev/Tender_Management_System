<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "tender_management_system");

// Fetch roles from the database
$sql = "SELECT id, role_name FROM roles";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Access | Tender Management System</title>
    <link rel="shortcut icon" href="../assets/image/system_logo.jpg" type="image/x-icon">
    <style>
        :root {
            --primary: #9d50bb;
            --secondary: #6e8efb;
            --dark: #2d3436;
            --light-gray: #f1f2f6;
            --success: #00b894;
            --glass: rgba(255, 255, 255, 0.9);
        }
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
    font-family: 'Rajdhani', sans-serif;

        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* --- Animation Keyframes --- */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* --- Main Card --- */
        .request-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 600px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 20px;
            animation: slideUp 0.6s ease-out;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: var(--dark);
            font-size: 24px;
            margin-bottom: 8px;
        }

        .header p {
            color: #636e72;
            font-size: 14px;
        }

        /* --- Form Elements --- */
        .form-group {
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }
        .form-group:nth-child(3) { animation-delay: 0.4s; }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--light-gray);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus, textarea:focus, select:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(157, 80, 187, 0.1);
        }

        textarea {
            resize: none;
            height: 100px;
        }

        /* --- Buttons --- */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(157, 80, 187, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .footer-links {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
        }

        .footer-links a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
        }

        /* --- Success State --- */
        .success-msg {
            display: none;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background: var(--success);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 20px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .request-card { padding: 25px; }
            .header h1 { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="request-card" id="formContainer">
        <div id="requestForm">
            <div class="header">
                <h1>Request System Access</h1>
                <p>Submit your details to the administrator for review.</p>
            </div>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return handleForm(event)">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Name" required>
                </div>

                <div class="form-group">
                    <label for="department">Role</label>
                        <select class="role_dropdown">
                                <option value="" disabled selected>Select your role</option>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo htmlspecialchars($row['role_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                        </select>
                </div>

                <div class="form-group">
                    <label for="reason">Reason for Access</label>
                    <textarea id="reason" name="reason" placeholder="Please describe why you need access to this resource..." required></textarea>
                </div>

                <button type="submit" class="btn-submit">Submit Request</button>
            </form>

            <div class="footer-links">
                <a href="javascript:history.back()">← Back to Login</a>
            </div>
        </div>

        <div id="successMessage" class="success-msg">
            <div class="success-icon">✓</div>
            <h2>Request Received</h2>
            <p style="color: #636e72; margin-top: 10px;">Your request has been sent to the IT Department. You will receive an email notification once approved.</p>
            <br>
            <button onclick="window.location.href='/'" class="btn-submit" style="background: var(--dark)">Return Home</button>
        </div>
    </div>

    <script>
        function handleForm(e) {
            e.preventDefault();
            
            // Simulation of an AJAX request
            const form = document.getElementById('requestForm');
            const success = document.getElementById('successMessage');
            
            form.style.display = 'none';
            success.style.display = 'block';

            return false;
        }
    </script>

    <?php
    // Basic PHP Logic for actual submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['full_name']);
        $dept = htmlspecialchars($_POST['department']);
        $reason = htmlspecialchars($_POST['reason']);
        
        // Database connection and insertion logic would go here
        // mail("admin@company.com", "Access Request from $name", $reason);
    }
    ?>
</body>
</html>
