<?php
$conn = mysqli_connect("localhost", "root", "", "tender_management_system");

// Delete logic
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM user_requests WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Request Deleted Successfully!'); window.location='add_user_request_list.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM user_requests WHERE status='pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Request List</title>
    <style>
        table { width: 95%; border-collapse: collapse; margin: 20px auto; background: white; font-family: Arial, sans-serif; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }

        /* Button Styles */
        .btn-approve { background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 14px; margin-right: 5px; }
        .btn-delete { background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 14px; border: none; cursor: pointer; }
        .btn-approve:hover { background: #0056b3; }
        .btn-delete:hover { background: #a71d2a; }
    </style>
</head>
<body>

<h2 style="text-align:center;">User Registration Requests</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['full_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td>
            <a href="../auth/register.php?id=<?php echo $row['id']; ?>" class="btn-approve">Register</a>
            
            <a href="?delete_id=<?php echo $row['id']; ?>" 
               class="btn-delete" 
               onclick="return confirm('Are you sure you want to delete this request?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
