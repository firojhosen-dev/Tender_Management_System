<?php
session_start();
// Database connection
require_once "../includes/header.php";
require_once '../config/db.php';
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access


try {
    // Fetch all information from the database
    $query = "SELECT * FROM users ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll();
    
    // Status Count (For KPI Cards)
    $totalUsers = count($users);
    $activeUsers = 0;
    $blockedUsers = 0;
    foreach($users as $u) {
        if(isset($u['status']) && $u['status'] == 1) $activeUsers++;
        else if(isset($u['status']) && $u['status'] == 0) $blockedUsers++;
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS User Management | TMS</title>
    <link rel="stylesheet" href="../assets/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">
</head>
<body>

<div class="users-container">
    <header class="users-header-flex">
        <div>
            <h1>Users Management</h1>
            <p style="color: var(--text-muted)">Dashboard / All Users Management</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="users-btn users-btn-primary" onclick="window.location='../auth/register.php'">+ Add User</button>
        </div>
    </header>

    <div class="users-stats-grid">
        <div class="users-stat-card">
            <p>Total Employees</p>
            <div class="users-stat-value"><?php echo $totalUsers; ?></div>
        </div>
        <div class="users-stat-card">
            <p>Active</p>
            <div class="users-stat-value" style="color:var(--success)"><?php echo $activeUsers; ?></div>
        </div>
        <div class="users-stat-card">
            <p>Blocked</p>
            <div class="users-stat-value" style="color:var(--danger)"><?php echo $blockedUsers; ?></div>
        </div>
    </div>

    <div class="users-card" style="margin-bottom: 15px;">
        <div class="users-header-flex" style="margin-bottom: 0;">
            <input type="text" id="userSearch" class="users-form-control" style="max-width: 400px" placeholder="Search by Name, Email, Employee ID or Company..." onkeyup="filterUsers()">
            <div style="display:flex; gap:10px;">
                <select class="users-form-control" id="roleFilter" onchange="filterUsers()">
                    <option value="">All Roles</option>
                    <option value="Admin">Admin</option>
                    <option value="Auditor">Auditor</option>
                    <option value="Reviewer">Reviewer</option>
                    <option value="Vendor">Vendor</option>
                    <option value="Tender Creator">Tender Creator</option>
                    <option value="Guest">Guest</option>
                </select>
            </div>
        </div>
    </div>

    <div class="users-table-wrapper">
        <table id="users-userTable">
            <thead>
                <tr>
                    <th>Emp ID</th>
                    <th>User Details</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Contact Info</th>
                    <th>Organization</th>
                    <th>Job Profile</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($user['employee_id'] ?? 'N/A'); ?></strong></td>
                    <td>
                        <div style="display:flex; flex-direction:column;">
                            <span style="font-weight:600; color:var(--primary-dark)"><?php echo htmlspecialchars($user['full_name']); ?></span>
                            <small><?php echo htmlspecialchars($user['email']); ?></small>
                            <small style="color:gray;">Gender: <?php echo htmlspecialchars($user['gender'] ?? '-'); ?></small>
                        </div>
                    </td>
                    <td><code><?php echo htmlspecialchars($user['username']); ?></code></td>
                    <td><span class="users-badge users-badge-active"><?php echo htmlspecialchars($user['role_name']); ?></span></td>
                    <td>
                        <small><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($user['mobile'] ?? '-'); ?></small><br>
                        <small><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($user['office_phone'] ?? '-'); ?></small><br>
                        <small><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($user['address'] ?? '-'); ?></small>
                    </td>
                    <td>
                        <strong><?php echo htmlspecialchars($user['company_name'] ?? 'N/A'); ?></strong><br>
                        <small><?php echo htmlspecialchars($user['department'] ?? '-'); ?></small>
                    </td>
                    <td>
                        <span style="color:var(--primary)"><?php echo htmlspecialchars($user['designation'] ?? 'N/A'); ?></span>
                    </td>
                    <td>
                        <small><?php echo $user['last_login'] ?? 'Never'; ?></small>
                    </td>
                    <td>
                        <div style="display:flex; gap:5px;">
                            <a href="user_edit.php?id=<?php echo $user['id']; ?>" class="users-btn users-btn-primary" style="padding:5px 10px; font-size:12px; background:var(--accent-light)">Edit</a>
                            <?php if(isset($user['status']) && $user['status'] == 1): ?>
                                <a href="user_block.php?id=<?php echo $user['id']; ?>&status=0" class="users-btn users-btn-danger" style="padding:5px 10px; font-size:12px;">Block</a>
                            <?php else: ?>
                                <a href="user_block.php?id=<?php echo $user['id']; ?>&status=1" class="users-btn" style="padding:5px 10px; font-size:12px; background:var(--success); color:white; ">Unblock</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
require_once "../includes/footer.php";
?>
<script>
    // Search and Filter Functionality
    function filterUsers() {
        const input = document.getElementById('userSearch').value.toLowerCase();
        const role = document.getElementById('roleFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#userTable tbody tr');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const matchesSearch = text.includes(input);
            const matchesRole = role === "" || row.children[3].innerText.toLowerCase().includes(role);
            
            row.style.display = (matchesSearch && matchesRole) ? "" : "none";
        });
    }

    // Theme Toggle Functionality
    function toggleTheme() {
        const body = document.documentElement;
        const currentTheme = body.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        body.setAttribute('data-theme', newTheme);
        document.getElementById('theme-btn').textContent = newTheme === 'light' ? '🌙' : '☀️';
    }
</script>

</body>
</html>