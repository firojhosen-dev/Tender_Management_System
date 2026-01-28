<?php
if(isset($_POST['submit_request'])){
    // ডাটাবেজ কানেকশন - এখানে 'tms_db' দিন
    $conn = mysqli_connect("localhost", "root", "", "tender_management_system");

    // কানেকশন চেক করা (এটি করলে এরর সহজে ধরা যায়)
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO user_requests (full_name, email, phone, description) 
            VALUES ('$name', '$email', '$phone', '$desc')";
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Request Sent Successfully!');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Access Request</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; padding-top: 50px; }
        .form-container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); width: 400px; }
        .form-container h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 10px; background-color: #28a745; border: none; color: white; font-size: 16px; border-radius: 4px; cursor: pointer; }
        .btn-submit:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Access Request Form</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" required>
        </div>
        <div class="form-group">
            <label>Why do you need access?</label>
            <textarea name="description" rows="4" required></textarea>
        </div>
        <button type="submit" name="submit_request" class="btn-submit">Submit Request</button>
    </form>
</div>

</body>
</html>