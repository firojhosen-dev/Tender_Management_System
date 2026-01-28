<?php
require_once "../includes/header.php";
require_once "../config/database.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

//* Profile Update Logic
if (isset($_POST['save_settings'])) {
    //* Basic & Contact
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    
    //* Organization & Social
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $supervisor = mysqli_real_escape_string($conn, $_POST['supervisor']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $company_id = mysqli_real_escape_string($conn, $_POST['company_id']);
    $fb_url = mysqli_real_escape_string($conn, $_POST['fb_url']);
    $ln_url = mysqli_real_escape_string($conn, $_POST['ln_url']);
    $tw_url = mysqli_real_escape_string($conn, $_POST['tw_url']);
    $gh_url = mysqli_real_escape_string($conn, $_POST['gh_url']);

    //* Professional & Emergency
    $years_of_exp = mysqli_real_escape_string($conn, $_POST['years_of_exp']);
    $core_skills = mysqli_real_escape_string($conn, $_POST['core_skills']);
    $e_contact_name = mysqli_real_escape_string($conn, $_POST['emergency_contact_name']);
    $e_contact_phone = mysqli_real_escape_string($conn, $_POST['emergency_contact_phone']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);

    //* Image Upload
    $image_update = "";
    if (!empty($_FILES['profile_pic']['name'])) {
        $img_name = time() . '_' . $_FILES['profile_pic']['name'];
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], "../assets/uploads/profiles/" . $img_name)) {
            $image_update = ", profile_picture = '$img_name'";
            $_SESSION['profile_pic'] = $img_name;
        }
    }

    $update_query = "UPDATE users SET 
        full_name = '$full_name', 
        gender = '$gender', 
        dob = '$dob', 
        mobile = '$mobile', 
        address = '$address', 
        bio = '$bio', 
        employee_id = '$employee_id', 
        supervisor = '$supervisor',
        department = '$department',
        designation = '$designation',
        company_name = '$company_name',
        company_id = '$company_id',
        fb_url = '$fb_url', 
        ln_url = '$ln_url', 
        tw_url = '$tw_url', 
        gh_url = '$gh_url',
        years_of_exp = '$years_of_exp',
        core_skills = '$core_skills', 
        emergency_contact_name = '$e_contact_name', 
        emergency_contact_phone = '$e_contact_phone', 
        blood_group = '$blood_group'
        $image_update 
        WHERE id = $user_id";

    if (mysqli_query($conn, $update_query)) {
        $success_msg = "Profile updated successfully!";
    } else {
        $error_msg = "Update failed: " . mysqli_error($conn);
    }
}

$fetch = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$u = mysqli_fetch_assoc($fetch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .settings-card { max-width: 1000px; margin: 40px auto; background: #fff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); font-family: 'Rajdhani', sans-serif; }
        .settings-header { background: #1a237e; padding: 20px; color: #fff; border-radius: 15px 15px 0 0; text-align: center; }
        
        /* ট্যাব স্টাইল */
        .tab-menu { display: flex; background: #f5f5f5; border-bottom: 1px solid #ddd; }
        .tab-link { padding: 15px 20px; cursor: pointer; border: none; background: none; font-weight: 600; color: #555; transition: 0.3s; }
        .tab-link.active { background: #fff; color: #1a237e; border-bottom: 3px solid #1a237e; }
        
        .tab-content { display: none; padding: 30px; }
        .tab-content.active { display: block; }

        .upload-box { text-align: center; margin-bottom: 25px; position: relative; }
        .upload-box img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #1a237e; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: inherit; }
        .full-width { grid-column: span 2; }
        
        .footer-actions { padding: 20px 30px; background: #f9f9f9; text-align: right; border-radius: 0 0 15px 15px; }
        .btn-save { background: #1a237e; color: #fff; border: none; padding: 12px 30px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; }
        .btn-save:hover { background: #0d1440; }
        .alert { margin: 20px; padding: 15px; border-radius: 5px; text-align: center; }
    </style>
</head>
<body>

<div class="settings-card">
    <div class="settings-header">
        <h2><i class="fas fa-user-edit"></i> Complete Profile Settings</h2>
    </div>

    <?php if($success_msg) echo "<div class='alert' style='background:#d4edda; color:#155724;'>$success_msg</div>"; ?>
    <?php if($error_msg) echo "<div class='alert' style='background:#f8d7da; color:#721c24;'>$error_msg</div>"; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="tab-menu">
            <button type="button" class="tab-link active" onclick="openTab(event, 'basic')">Basic & Bio</button>
            <button type="button" class="tab-link" onclick="openTab(event, 'contact')">Contact & Social</button>
            <button type="button" class="tab-link" onclick="openTab(event, 'org')">Organization</button>
            <button type="button" class="tab-link" onclick="openTab(event, 'expert')">Expertise & Emergency</button>
        </div>

        <div id="basic" class="tab-content active">
            <div class="upload-box">
                <img src="../assets/uploads/profiles/<?= $u['profile_picture'] ?? 'default.png' ?>" id="preview">
                <input type="file" name="profile_pic" onchange="showPreview(event)" style="margin-top: 10px;">
            </div>
            <div class="form-grid">
                <div class="form-group"><label>Full Name</label><input type="text" name="full_name" value="<?= $u['full_name'] ?? '' ?>"></div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="Male" <?= ($u['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= ($u['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="form-group"><label>Date of Birth</label><input type="date" name="dob" value="<?= $u['dob'] ?? '' ?>"></div>
                <div class="form-group full-width"><label>Short Bio</label><textarea name="bio"><?= $u['bio'] ?? '' ?></textarea></div>
            </div>
        </div>

        <div id="contact" class="tab-content">
            <div class="form-grid">
                <div class="form-group"><label>Mobile</label><input type="text" name="mobile" value="<?= $u['mobile'] ?? '' ?>"></div>
                <div class="form-group"><label>Address</label><input type="text" name="address" value="<?= $u['address'] ?? '' ?>"></div>
                <div class="form-group"><label>Facebook URL</label><input type="text" name="fb_url" value="<?= $u['fb_url'] ?? '' ?>"></div>
                <div class="form-group"><label>LinkedIn URL</label><input type="text" name="ln_url" value="<?= $u['ln_url'] ?? '' ?>"></div>
                <div class="form-group"><label>Twitter URL</label><input type="text" name="tw_url" value="<?= $u['tw_url'] ?? '' ?>"></div>
                <div class="form-group"><label>GitHub URL</label><input type="text" name="gh_url" value="<?= $u['gh_url'] ?? '' ?>"></div>
            </div>
        </div>

        <div id="org" class="tab-content">
            <div class="form-grid">
                <div class="form-group"><label>Department</label><input type="text" name="department" value="<?= $u['department'] ?? '' ?>"></div>
                <div class="form-group"><label>Designation</label><input type="text" name="designation" value="<?= $u['designation'] ?? '' ?>"></div>
                <div class="form-group"><label>Supervisor</label><input type="text" name="supervisor" value="<?= $u['supervisor'] ?? '' ?>"></div>
                <div class="form-group"><label>Company Name</label><input type="text" name="company_name" value="<?= $u['company_name'] ?? '' ?>"></div>
                <div class="form-group"><label>Reg Number</label><input type="text" name="company_id" value="<?= $u['company_id'] ?? '' ?>"></div>
                <div class="form-group"><label>Employee ID</label><input type="text" name="employee_id" value="<?= $u['employee_id'] ?? '' ?>"></div>
            </div>
        </div>

        <div id="expert" class="tab-content">
            <div class="form-grid">
                <div class="form-group"><label>Years of Experience</label><input type="number" name="years_of_exp" value="<?= $u['years_of_exp'] ?? '' ?>"></div>
                <div class="form-group"><label>Core Skills (Comma separated)</label><input type="text" name="core_skills" value="<?= $u['core_skills'] ?? '' ?>"></div>
                <div class="form-group"><label>Emergency Contact Name</label><input type="text" name="emergency_contact_name" value="<?= $u['emergency_contact_name'] ?? '' ?>"></div>
                <div class="form-group"><label>Emergency Phone</label><input type="text" name="emergency_contact_phone" value="<?= $u['emergency_contact_phone'] ?? '' ?>"></div>
                <div class="form-group"><label>Blood Group</label><input type="text" name="blood_group" value="<?= $u['blood_group'] ?? '' ?>"></div>
            </div>
        </div>

        <div class="footer-actions">
            <a href="user_profile_information.php" style="margin-right: 15px; text-decoration: none; color: #666;">Back to Profile</a>
            <button type="submit" name="save_settings" class="btn-save">Update Profile</button>
        </div>
    </form>
</div>

<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; }
        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) { tablinks[i].className = tablinks[i].className.replace(" active", ""); }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("preview");
            preview.src = src;
        }
    }
</script>
</body>
</html>
