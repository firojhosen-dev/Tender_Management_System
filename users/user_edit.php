<?php
session_start();
require_once '../config/db.php';
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access

if (!isset($_GET['id'])) {
    header("Location: user_list.php");
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    if (!$user) { die("User not found!"); }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "UPDATE users SET 
                full_name = ?, email = ?, gender = ?, mobile = ?, 
                office_phone = ?, employee_id = ?, company_name = ?, 
                department = ?, designation = ?, address = ?, 
                role_name = ?, status = ? 
                WHERE id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['full_name'], $_POST['email'], $_POST['gender'], $_POST['mobile'],
            $_POST['office_phone'], $_POST['employee_id'], $_POST['company_name'],
            $_POST['department'], $_POST['designation'], $_POST['address'],
            $_POST['role_name'], $_POST['status'], $id
        ]);

        $message = "<div class='notification success show'>✅ User updated successfully!</div>";
        header("Refresh:1"); 
    } catch (PDOException $e) {
        $message = "<div class='notification danger show'>❌ Update failed: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | <?php echo htmlspecialchars($user['full_name']); ?></title>
    
    <style>
        :root {
            --primary: #46B5D3;
            --primary-dark: #0D0B63;
            --bg-dark: #160C40;
            --secondary-dark: #151B4D;
            --white: #FFFFFF;
            --gray-light: #E7DFDF;
            --accent-light: #E1F3F3;
            --success: #4CAF50;
            --danger: #F44336;
            --warning: #FF9800;
            --gradient-main: linear-gradient(135deg, var(--primary-dark), var(--bg-dark));
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.4);
            --shadow: 0 15px 35px rgba(0,0,0,0.1);
            --app-bg: var(--accent-light);
            --surface: var(--white);
            --text-main: var(--secondary-dark);
            --text-muted: #666;
            --border-color: var(--gray-light);
            --input-bg: var(--white);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        [data-theme="dark"] {
            --app-bg: var(--bg-dark);
            --surface: #1d144d;
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: var(--white);
            --text-muted: var(--gray-light);
            --border-color: rgba(255,255,255,0.1);
            --input-bg: rgba(255,255,255,0.05);
            --shadow: 0 15px 35px rgba(0,0,0,0.4);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        body {
            background: var(--app-bg);
            color: var(--text-main);
            transition: background 0.5s ease;
            min-height: 100vh;
            padding: 40px 20px;
            overflow-x: hidden;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 0.8s forwards;
        }

        @keyframes slideUp {
            to { transform: translateY(0); opacity: 1; }
        }

        /* Header Styles */
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .theme-toggle {
            cursor: pointer;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--glass-border);
            transition: var(--transition);
        }

        .theme-toggle:hover { transform: rotate(360deg) scale(1.1); }

        /* Card & Glassmorphism */
        .card {
            background: var(--surface);
            padding: 40px;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .form-group {
            position: relative;
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary);
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            background: var(--input-bg);
            color: var(--text-main);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(70, 181, 211, 0.2);
            transform: translateY(-2px);
        }

        /* Buttons */
        .btn-group {
            margin-top: 40px;
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 15px 30px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--primary), #3aa2bd);
            color: white;
            box-shadow: 0 10px 20px rgba(70, 181, 211, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(70, 181, 211, 0.5);
        }

        .btn-danger {
            background: transparent;
            border: 2px solid var(--danger);
            color: var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: white;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 20px 30px;
            border-radius: 15px;
            color: white;
            z-index: 1000;
            transform: translateX(200%);
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .notification.show { transform: translateX(0); }
        .success { background: var(--success); }
        .danger { background: var(--danger); }

/* --- Custom Scrollbar Styling --- */

::-webkit-scrollbar {
    width: 10px;
    height: 10px; 
}

::-webkit-scrollbar-track {
    background: var(--app-bg);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, var(--primary), var(--primary-dark));
    border-radius: 10px;
    border: 2px solid var(--app-bg); 
    transition: var(--transition);
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, var(--primary-dark), var(--primary));
}

* {
    scrollbar-width: thin;
    scrollbar-color: var(--primary) var(--app-bg);
}

.table-wrapper::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 5px;
}
        /* Responsive */
        @media (max-width: 768px) {
            .header-flex { flex-direction: column; gap: 20px; text-align: center; }
            .form-grid { grid-template-columns: 1fr; }
            .btn-group { flex-direction: column; }
        }
    </style>
</head>
<body>

    <div class="notification-container">
        <?php echo $message; ?>
    </div>

    <div class="container">
        <header class="header-flex">
            <div>
                <h1 style="font-size: 2.2rem;">User Settings</h1>
                <p style="color: var(--text-muted); font-size: 1.1rem;">
                    Update profile for <span style="color: var(--primary); font-weight: bold;">@<?php echo htmlspecialchars($user['username']); ?></span>
                </p>
            </div>
            <div style="display: flex; gap: 15px;">
                <div class="theme-toggle" onclick="toggleTheme()" id="themeIcon">🌙</div>
                <a href="user_list.php" class="btn" style="background: var(--surface); color: var(--text-main); border: 1px solid var(--border-color); text-decoration:none;">Cancel</a>
            </div>
        </header>

        <div class="card">
            <form method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="Male" <?php if($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            <option value="Other" <?php if($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>Employee ID</label>
                        <input type="text" name="employee_id" class="form-control" value="<?php echo htmlspecialchars($user['employee_id'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>Office Phone</label>
                        <input type="text" name="office_phone" class="form-control" value="<?php echo htmlspecialchars($user['office_phone'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($user['company_name'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="department" class="form-control" value="<?php echo htmlspecialchars($user['department'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" class="form-control" value="<?php echo htmlspecialchars($user['designation'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>System Role</label>
                        <select name="role_name" class="form-control">
                            <option value="Admin" <?php if($user['role_name'] == 'Admin') echo 'selected'; ?>>Admin</option>
                            <option value="Tender Creator" <?php if($user['role_name'] == 'Tender Creator') echo 'selected'; ?>>Tender Creator</option>
                            <option value="Reviewer" <?php if($user['role_name'] == 'Reviewer') echo 'selected'; ?>>Reviewer</option>
                            <option value="Auditor" <?php if($user['role_name'] == 'Auditor') echo 'selected'; ?>>Auditor</option>
                            <option value="Guest" <?php if($user['role_name'] == 'Guest') echo 'selected'; ?>>Guest</option>
                            <option value="Vendor" <?php if($user['role_name'] == 'Vendor') echo 'selected'; ?>>Vendor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Account Status</label>
                        <select name="status" class="form-control">
                            <option value="1" <?php if(($user['status'] ?? 1) == 1) echo 'selected'; ?>>Active</option>
                            <option value="0" <?php if(($user['status'] ?? 1) == 0) echo 'selected'; ?>>Blocked</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 25px;">
                    <label>Residential Address</label>
                    <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Update Profile Information</button>
                    <button type="reset" class="btn btn-danger">Reset Fields</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Theme Toggle Logic
        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('themeIcon');
            const currentTheme = html.getAttribute('data-theme');
            
            if (currentTheme === 'light') {
                html.setAttribute('data-theme', 'dark');
                icon.textContent = '☀️';
                localStorage.setItem('theme', 'dark');
            } else {
                html.setAttribute('data-theme', 'light');
                icon.textContent = '🌙';
                localStorage.setItem('theme', 'light');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.getElementById('themeIcon').textContent = savedTheme === 'light' ? '🌙' : '☀️';
            
            // Auto-hide notifications
            const note = document.querySelector('.notification');
            if(note) {
                setTimeout(() => { note.classList.remove('show'); }, 3000);
            }
        });
    </script>
</body>
</html>