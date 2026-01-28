<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: edit_tender.php
* Version: 1.0.2 (Currency Update Fix)
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']); 

if (!isset($_GET['edit_id']) || empty($_GET['edit_id'])) {
    header("Location: tender_management.php");
    exit;
}

$id = intval($_GET['edit_id']);
$message = "";
$error = "";

if (isset($_POST['update_tender'])) {
    $tender_company_id = intval($_POST['tender_company_id']);
    $tender_name       = mysqli_real_escape_string($conn, $_POST['tender_name']);
    $tender_ref_no     = mysqli_real_escape_string($conn, $_POST['tender_ref_no']);
    $published_date    = mysqli_real_escape_string($conn, $_POST['published_date']);
    $submitted_date    = mysqli_real_escape_string($conn, $_POST['submitted_date']);
    $tender_status     = mysqli_real_escape_string($conn, $_POST['tender_status']);
    $quoted_price      = floatval($_POST['quoted_price']);
    $currency          = mysqli_real_escape_string($conn, $_POST['currency']); 
    $tender_result     = mysqli_real_escape_string($conn, $_POST['tender_result']);
    $brand             = mysqli_real_escape_string($conn, $_POST['brand']);
    $remarks           = mysqli_real_escape_string($conn, $_POST['remarks']);

    $sql = "UPDATE tenders SET 
            tender_company_id = '$tender_company_id',
            tender_name = '$tender_name',
            tender_ref_no = '$tender_ref_no',
            published_date = '$published_date',
            submitted_date = '$submitted_date',
            tender_status = '$tender_status',
            quoted_price = '$quoted_price',
            currency = '$currency', 
            tender_result = '$tender_result',
            brand = '$brand',
            remarks = '$remarks'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Tender updated successfully!'); window.location.href='tender_management.php';</script>";
        exit;
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}

$query = "SELECT * FROM tenders WHERE id = $id";
$result = mysqli_query($conn, $query);
$tender = mysqli_fetch_assoc($result);

if (!$tender) {
    echo "Tender not found!";
    exit;
}

$companies_result = mysqli_query($conn, "SELECT id, company_name FROM tender_companies ORDER BY company_name ASC");

?> 
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <style>
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
        /* --- CSS VARIABLES & THEMES --- */
        :root {
            /* -- Provided Color Palette -- */
            --primary: #46B5D3;
            --primary-dark: #0D0B63;
            --bg-dark: #160C40;
            --secondary-dark: #151B4D;
            --white: #FFFFFF;
            --gray-light: #E7DFDF;
            --accent-light: #E1F3F3;
            
            /* -- Dynamic Mapping -- */
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
                    font-family: 'Rajdhani', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* --- Container & Glassmorphism --- */
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
            margin: 80px 0px 10px 0px;
        }

        h3 {
            font-size: 2rem;
            margin-bottom: 30px;
            background: linear-gradient(90deg, var(--primary), #82e9ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        /* --- Grid Layout for 12 Fields --- */
        .tender-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .full-width { grid-column: span 2; }

        /* --- Stylized Input Fields --- */
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

        /* --- Highlighted 6 Beautiful Fields (Visual Emphasis) --- */
        .highlight-field input {
            border-left: 5px solid var(--primary);
        }

        /* --- Theme Toggle Animation --- */
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

        /* --- Buttons --- */
        .btn-submit {
            display: inline-block;
            width: 100%;
            text-align: center;
            background: var(--primary);
            color: var(--white);
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 20px;
        }
.btn-cancel {
            display: inline-block;
            text-align: center;
            background: #ccc;
            color: #333;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: var(--neon-glow);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
/* Desktop/Tablet: Switch to 2 columns */
@media (min-width: 721px) {
    .tender-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .full-width { grid-column: span 2; }
    .container { padding: 45px; }
}
@media (min-width: 768px) {
    .theme-switch {
        top: 20px;
        right: 20px;
    }
}
@media (min-width: 768px) {
    .btn-submit {
        grid-column: span 2;
        font-size: 1.1rem;
    }
}
@media (max-width: 730px) {
            .tender-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .btn-submit { grid-column: span 1; }
        }
        @media (max-width: 600px) {
            .tender-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .btn-submit { grid-column: span 1; }
        }

/* Container or Body styling */
:root {
    --primary: #46B5D3;
    --primary-dark: #0D0B63;
    --bg-dark: #160C40;
    --secondary-dark: #151B4D;
    --white: #FFFFFF;
    --gray-light: #E7DFDF;
    --accent-light: #E1F3F3;
}

/* 1. Firefox Support */
* {
    scrollbar-width: thin;
    scrollbar-color: var(--primary) var(--secondary-dark);
}

/* 2. Chrome, Edge, and Safari Support */
/* The width of the entire scrollbar */
::-webkit-scrollbar {
    width: 10px;
    height: 10px; /* For horizontal scrollbars */
}

/* The track (background) of the scrollbar */
::-webkit-scrollbar-track {
    background: var(--secondary-dark);
    border-radius: 10px;
}

/* The draggable scrolling handle */
::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 10px;
    border: 2px solid var(--secondary-dark); /* Creates a padding effect */
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: var(--accent-light);
}
    </style>

<div class="container">
    <h2>Edit Tender Details</h2>
    
    <?php if($error) { echo "<p class='error-msg'>$error</p>"; } ?>

    <form method="POST" action="">
        <div class="tender-grid">
        <div class="form-group highlight-field">
            <label for="tender_company_id">Tender Company Name</label>
            <select name="tender_company_id" id="tender_company_id" class="form-control" required>
                <option value="">Select Company</option>
                <?php while($comp = mysqli_fetch_assoc($companies_result)) { ?>
                    <option value="<?php echo $comp['id']; ?>" 
                        <?php echo ($comp['id'] == $tender['tender_company_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($comp['company_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group highlight-field">
            <label for="tender_name">Tender Name</label>
            <input type="text" name="tender_name" id="tender_name" class="form-control" 
                   value="<?php echo htmlspecialchars($tender['tender_name']); ?>" required>
        </div>

        <div class="form-group highlight-field">
            <label for="tender_ref_no">Tender Ref No</label>
            <input type="text" name="tender_ref_no" id="tender_ref_no" class="form-control" 
                   value="<?php echo htmlspecialchars($tender['tender_ref_no']); ?>">
        </div>

            <div class="form-group highlight-field">
                <label for="published_date">Published Date</label>
                <input type="date" name="published_date" id="published_date" class="form-control" 
                       value="<?php echo $tender['published_date']; ?>">
            </div>
            <div class="form-group highlight-field">
                <label for="submitted_date">Submitted Date</label>
                <input type="date" name="submitted_date" id="submitted_date" class="form-control" 
                       value="<?php echo $tender['submitted_date']; ?>">
            </div>

        <div class="form-group highlight-field">
            <label for="tender_status">Tender Status</label>
            <select name="tender_status" id="tender_status" class="form-control">
                <option value="Participating" <?php echo ($tender['tender_status'] == 'Participating') ? 'selected' : ''; ?>>Participating</option>
                <option value="Submitted" <?php echo ($tender['tender_status'] == 'Submitted') ? 'selected' : ''; ?>>Submitted</option>
                <option value="Won" <?php echo ($tender['tender_status'] == 'Won') ? 'selected' : ''; ?>>Won</option>
                <option value="Lost" <?php echo ($tender['tender_status'] == 'Lost') ? 'selected' : ''; ?>>Lost</option>
                <option value="Cancelled" <?php echo ($tender['tender_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>

        <!-- <div class="form-group highlight-field">
            <label for="quoted_price">Quoted Price</label>
            <input type="number" step="0.01" name="quoted_price" id="quoted_price" class="form-control" 
                   value="<?php echo $tender['quoted_price']; ?>">
        </div> -->

        <div class="form-group">
                <label>Quoted Price & Currency</label>
                <div class="currency-input-group">
                    <select name="currency">
                        <option value="BDT" <?php echo ($tender['currency'] == 'BDT') ? 'selected' : ''; ?>>BDT</option>
                        <option value="USD" <?php echo ($tender['currency'] == 'USD') ? 'selected' : ''; ?>>USD</option>
                    </select>
                    <input type="number" step="0.01" name="quoted_price" value="<?php echo $tender['quoted_price']; ?>">
                </div>
            </div>

        <div class="form-group highlight-field">
            <label for="brand">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" 
                   value="<?php echo htmlspecialchars($tender['brand']); ?>">
        </div>

        <div class="form-group highlight-field">
            <label for="tender_result">Tender Result</label>
            <input type="text" name="tender_result" id="tender_result" class="form-control" 
                   value="<?php echo htmlspecialchars($tender['tender_result']); ?>" placeholder="e.g. PO Received, Pending">
        </div>

        <div class="form-group highlight-field">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" id="remarks" rows="3" class="form-control"><?php echo htmlspecialchars($tender['remarks']); ?></textarea>
        </div>

        <button type="submit" name="update_tender" class="btn-submit">Update Tender</button>
        <a href="tender_management.php" class="btn-cancel">Cancel</a>
        </div>
    </form>

</div>

</body>
</html>