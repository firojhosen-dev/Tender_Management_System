<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: view_search_result.php
* Project: Tender Management System
* Description: Display tender details with Dark/Light mode and responsive design.
* Version: 1.1.0
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor', 'Reviewer', 'Vendor']); 

if (!isset($_GET['tender_id'])) {
    echo "<div class='error-msg'>Invalid request.</div>";
    exit;
}

$tender_id = intval($_GET['tender_id']);

/* Fetch tender details with company info */
$sql = "SELECT t.*, c.id as company_id, c.company_name 
        FROM tenders t 
        LEFT JOIN tender_companies c ON t.tender_company_id = c.id
        WHERE t.id = $tender_id
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<div class='error-msg'>Tender not found.</div>";
    exit;
}

$tender = mysqli_fetch_assoc($result);
$company_id = $tender['company_id'];
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<style>
    :root {
        --bg-color: #f4f7f6;
        --card-bg: #ffffff;
        --text-color: #333;
        --primary-color: #009879;
        --secondary-color: #46B5D3;
        --border-color: #ddd;
        --label-bg: #f9f9f9;
    }

    @media (prefers-color-scheme: dark) {
        :root {
            --bg-color: #1a1a1a;
            --card-bg: #2d2d2d;
            --text-color: #e0e0e0;
            --border-color: #444;
            --label-bg: #383838;
        }
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
        transition: all 0.3s ease;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .tender-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .card-header {
        background: var(--primary-color);
        color: white;
        padding: 20px;
        text-align: center;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.5rem;
        letter-spacing: 1px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr;
    }

    .detail-row {
        display: flex;
        flex-wrap: wrap;
        border-bottom: 1px solid var(--border-color);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .label {
        flex: 1 1 250px;
        background: var(--label-bg);
        padding: 15px 20px;
        font-weight: 600;
        color: var(--primary-color);
    }

    .value {
        flex: 2 1 300px;
        padding: 15px 20px;
        word-break: break-word;
    }

    .button-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 30px;
        justify-content: center;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: transform 0.2s, opacity 0.2s;
        display: inline-block;
        text-align: center;
    }

    .btn:active {
        transform: scale(0.95);
    }

    .btn-original {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-back {
        background-color: var(--secondary-color);
        color: white;
    }

    .error-msg {
        text-align: center;
        color: #ff4444;
        margin-top: 50px;
        font-size: 1.2rem;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .label {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .value {
            padding: 10px 20px;
        }
        .btn {
            width: 100%;
        }
    }
</style>

<div class="container">
    <div class="tender-card">
        <div class="card-header">
            <h3>Tender Detailed View</h3>
        </div>
        
        <div class="details-grid">
            <div class="detail-row">
                <div class="label">Participate Company</div>
                <div class="value"><?php echo htmlspecialchars($tender['tender_participate_company']); ?></div>
            </div>
            
            <div class="detail-row">
                <div class="label">Tenderer Company Name</div>
                <div class="value"><?php echo htmlspecialchars($tender['company_name']); ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Tender Name</div>
                <div class="value"><?php echo htmlspecialchars($tender['tender_name']); ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Ref No</div>
                <div class="value"><?php echo htmlspecialchars($tender['tender_ref_no']); ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Published Date</div>
                <div class="value"><?php echo $tender['published_date']; ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Submitted Date</div>
                <div class="value"><?php echo $tender['submitted_date']; ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Status</div>
                <div class="value" style="font-weight: bold;"><?php echo $tender['tender_status']; ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Quoted Price</div>
                <div class="value" style="color: var(--primary-color); font-weight: bold;"><?php echo $tender['quoted_price']; ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Tender Result</div>
                <div class="value"><?php echo htmlspecialchars($tender['tender_result']); ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Brand</div>
                <div class="value"><?php echo htmlspecialchars($tender['brand']); ?></div>
            </div>

            <div class="detail-row">
                <div class="label">Remarks</div>
                <div class="value"><?php echo nl2br(htmlspecialchars($tender['remarks'])); ?></div>
            </div>
        </div>
    </div>

    <div class="button-group">
        <a href="view_all_tender_list.php#company_<?php echo $company_id; ?>" class="btn btn-original">
            🚀 Go to Original File
        </a>
        
        <a href="global_search.php" class="btn btn-back">
            ⬅ Back to Search
        </a>
    </div>
</div>

</body>
</html>