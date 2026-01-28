<?php
require_once '../config/db.php';
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor']); // All users can access
$stmt = $pdo->prepare("SELECT * FROM users WHERE status = 0");
$stmt->execute();
$blocked_users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../assets/css/users.css">
    <title>Blocked Users</title>
</head>
<body>
    <div class="container">
        <h1>Blocked User List</h1>
        <div class="card">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($blocked_users): foreach($blocked_users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><span class="badge badge-blocked" style="background: #ffebee; color: #f44336; padding: 5px 10px; border-radius: 5px;">Blocked</span></td>
                        <td>
                            <a href="user_block.php?id=<?php echo $user['id']; ?>&status=1" class="btn btn-primary" style="background:#4caf50; color:white; text-decoration:none; padding: 5px 10px; border-radius:5px;">Unblock</a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" style="text-align:center;">No blocked users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>