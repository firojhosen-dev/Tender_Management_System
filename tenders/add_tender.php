<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: add_tender.php
* Project: Tender Management System
* Description: Updated with Currency Selection (BDT/USD)
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor']); 
$message = "";

/* Fetch all tender companies for dropdown */
$companies_result = mysqli_query($conn, "SELECT * FROM tender_companies ORDER BY company_name ASC");

/* Handle form submission */
if (isset($_POST['add_tender'])) {
    $tender_company_id = intval($_POST['tender_company_id']);
    $tender_participate_company = trim($_POST['tender_participate_company']);
    $tender_name = trim($_POST['tender_name']);
    $tender_ref_no = trim($_POST['tender_ref_no']);
    $published_date = $_POST['published_date'];
    $submitted_date = $_POST['submitted_date'];
    $tender_status = $_POST['tender_status'];
    $quoted_price = $_POST['quoted_price'];
    $currency = $_POST['currency']; 
    $tender_result = trim($_POST['tender_result']);
    $brand = trim($_POST['brand']);
    $remarks = trim($_POST['remarks']);
    $created_by = $_SESSION['user_id'];

    if ($tender_company_id == 0 || $tender_participate_company == "" || $tender_name == "" || $tender_ref_no == "") {
        $message = "Please fill in all required fields (including Tender Ref No).";
    } else {
        $check_ref_query = "SELECT tender_ref_no FROM tenders WHERE tender_ref_no = '$tender_ref_no' LIMIT 1";
        $check_result = mysqli_query($conn, $check_ref_query);

        if (mysqli_num_rows($check_result) > 0) {
            $message = "Error: This tender has been added before. Please add another new tender. You are trying to use the same Tender Ref No. twice. Please use a different Tender Ref No.";
        } else {
            $sql = "INSERT INTO tenders 
            (tender_company_id, tender_participate_company, tender_name, tender_ref_no, published_date, submitted_date, tender_status, quoted_price, currency, tender_result, brand, remarks, created_by)
            VALUES
            ($tender_company_id, '$tender_participate_company', '$tender_name', '$tender_ref_no', '$published_date', '$submitted_date', '$tender_status', '$quoted_price', '$currency', '$tender_result', '$brand', '$remarks', $created_by)";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Tender added successfully!";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Tender</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <style>
        :root {
            --primary: #46B5D3;
            --primary-dark: #0D0B63;
            --bg-dark: #160C40;
            --secondary-dark: #151B4D;
            --white: #FFFFFF;
            --gray-light: #E7DFDF;
            --accent-light: #E1F3F3;
            
            --app-bg: var(--accent-light);
            --surface: var(--white);
            --text-main: var(--secondary-dark);
            --border-color: var(--gray-light);
            --input-bg: var(--white);
            --shadow: 0 10px 30px rgba(13, 11, 99, 0.1);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            --app-bg: var(--bg-dark);
            --surface: var(--secondary-dark);
            --text-main: var(--white);
            --border-color: rgba(255,255,255,0.1);
            --input-bg: rgba(255,255,255,0.05);
            --shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        body {
            background-color: var(--app-bg);
            color: var(--text-main);
            font-family: 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            transition: var(--transition);
        }

        .container {
            background: var(--surface);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 850px;
            padding: 40px;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            position: relative;
            margin: 80px 10px 40px 10px;
        }

        h3 {
            font-size: 2rem;
            margin-bottom: 30px;
            background: linear-gradient(90deg, var(--primary), #82e9ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .tender-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group { display: flex; flex-direction: column; }
        .full-width { grid-column: span 2; }

        label {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--primary);
        }

        input, select, textarea {
            padding: 12px 16px;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            background: var(--input-bg);
            color: var(--text-main);
            font-size: 1rem;
            transition: var(--transition);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(70, 181, 211, 0.2);
        }

        /* Currency Input Group */
        .currency-group {
            display: flex;
            gap: 0;
        }
        .currency-group select {
            border-radius: 12px 0 0 12px;
            border-right: none;
            width: 100px;
            background: var(--primary);
            color: white;
            cursor: pointer;
        }
        .currency-group input {
            border-radius: 0 12px 12px 0;
            flex: 1;
        }

        .highlight-field input, .highlight-field .currency-group {
            border-left: 5px solid var(--primary);
        }

        .theme-switch {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            background: var(--primary-dark);
            color: white;
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 0.8rem;
            border: none;
        }

        .btn-submit {
            grid-column: span 2;
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 20px;
            transition: transform 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(70, 181, 211, 0.4);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 730px) {
            .tender-grid { grid-template-columns: 1fr; }
            .full-width, .btn-submit { grid-column: span 1; }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--secondary-dark); }
        ::-webkit-scrollbar-thumb { 
            background: var(--primary); 
            border-radius: 10px; 
            border: 2px solid var(--secondary-dark);
        }
    </style>
</head>
<body>

<div class="container">
    <button class="theme-switch" onclick="toggleTheme()">🌓 Toggle Mode</button>

    <h3>Add New Tender</h3>

    <?php if ($message != ""): ?>
        <p style="color: <?php echo strpos($message, 'Error') === false ? '#4CAF50' : '#f44336'; ?>; font-weight:bold;">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    <form method="post">
        <div class="tender-grid">
            <div class="form-group full-width highlight-field">
                <label>Tender Participate Company Name</label>
                <input type="text" name="tender_participate_company" placeholder="Enter participating name" required>
            </div>

            <div class="form-group highlight-field">
                <label>Select Tender Issuing Company</label>
                <select name="tender_company_id" required>
                    <option value="0">-- Select Company --</option>
                    <?php while($company = mysqli_fetch_assoc($companies_result)) { ?>
                        <option value="<?php echo $company['id']; ?>"><?php echo htmlspecialchars($company['company_name']); ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group highlight-field">
                <label>Tender Name</label>
                <input type="text" name="tender_name" placeholder="Project Title" required>
            </div>

            <div class="form-group highlight-field">
                <label>Quoted Price</label>
                <div class="currency-group">
                    <select name="currency">
                        <option value="BDT">BDT (৳)</option>
                        <option value="USD">USD ($)</option>
                    </select>
                    <input type="number" step="0.01" name="quoted_price" placeholder="0.00">
                </div>
            </div>

            <div class="form-group highlight-field">
                <label>Published Date</label>
                <input type="date" name="published_date">
            </div>

            <div class="form-group highlight-field">
                <label>Submitted Date</label>
                <input type="date" name="submitted_date">
            </div>

            <div class="form-group">
                <label>Tender Ref No</label>
                <input type="text" name="tender_ref_no">
            </div>

            <div class="form-group">
                <label>Tender Status</label>
                <select name="tender_status">
                    <option value="Submitted">Submitted</option>
                    <option value="Not Submitted">Not Submitted</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tender Result</label>
                <input type="text" name="tender_result">
            </div>

            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand">
            </div>

            <div class="form-group full-width">
                <label>Remarks</label>
                <textarea name="remarks" rows="3"></textarea>
            </div>

            <button type="submit" name="add_tender" class="btn-submit">Add Tender to Database</button>
        </div>
    </form>

    <a href="tender_management.php" class="back-link">← Back to Tender Management</a>
</div>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', newTheme);
    }
</script>

</body>
</html>
