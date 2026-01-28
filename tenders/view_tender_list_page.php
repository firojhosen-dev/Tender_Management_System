<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: view_tender_list_page.php
* Project: Tender Management System
* Description:
* This file displays all tenders for a specific tender company.
* The company is selected via GET parameter (company_id).
* Shows company name, description, current date/time, and all tenders.
* Now includes 1st position win count in the header.
* Version: 1.1.0
* Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor', 'Reviewer', 'Vendor']); // All users can access

if (!isset($_GET['company_id'])) {
    echo "<p>Company ID not specified.</p>";
    exit;
}

$company_id = intval($_GET['company_id']);

/* Fetch company info */
$company_result = mysqli_query($conn, "SELECT * FROM tender_companies WHERE id=$company_id LIMIT 1");
if (mysqli_num_rows($company_result) == 0) {
    echo "<p>Company not found.</p>";
    exit;
}

$company = mysqli_fetch_assoc($company_result);

/* --- New Logic: Calculate Total and 1st Wins --- */
$stats_sql = "SELECT 
                COUNT(*) as total, 
                SUM(CASE WHEN tender_result = '1st' OR tender_result = '1-st' THEN 1 ELSE 0 END) as total_first
              FROM tenders 
              WHERE tender_company_id = $company_id";
$stats_query = mysqli_query($conn, $stats_sql);
$stats_data = mysqli_fetch_assoc($stats_query);

$total_tenders = $stats_data['total'];
$total_wins = $stats_data['total_first'] ? $stats_data['total_first'] : 0;

/* Fetch all tenders under this company for the table */
$tenders_result = mysqli_query($conn, 
    "SELECT * FROM tenders 
     WHERE tender_company_id = $company_id 
     ORDER BY id ASC"
);
?>


<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<style>
.all_tender_container{
    padding: 10px;
}
    /* Table styles */
    #tenderTable {
        border-radius: 12px;
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: 'Rajdhani', sans-serif;
    }
    #tenderTable th {
        background-color: #009879;
        color: white;
        text-align: left;
        padding: 12px;
    }
    #tenderTable td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        cursor: pointer; 
    }
    #tenderTable tr:hover { background-color: #f5f5f534; }

    /* Selected row style */
    .selected-row {
        background-color: #e8f5e9 !important; 
    }
    .check-mark {
        color: #2e7d32;
        font-weight: bold;
        margin-right: 5px;
        display: none;
    }
    .selected-row .check-mark {
        display: inline;
    }
/* Container for action buttons */
    .action-bar {
        display: flex;
        flex-wrap: wrap; 
        align-items: center;
        justify-content: center; 
        gap: 10px;
        margin: 20px 0;
        padding: 15px;
        background: #3206f708;
        border-radius: 8px;
    }

    /* Action buttons and search input */
    .action-bar button, 
    .action-bar .search-input {
        height: 40px;
        box-sizing: border-box; 
        padding: 0 15px;
        font-size: 14px;
        display: flex;
        align-items: center;
        border-radius: 4px;
        border: none;
    }

    /* Search input */
    .action-bar .search-input {
        width: 460px;
        border: 1px solid #009879;
        outline: none;
    }

    /* Button styles */
    .btn-full-page { background: #2196F3; color: white; cursor: pointer; }
    .btn-full-table { background: #4CAF50; color: white; cursor: pointer; }
    .btn-selected { background: #FF9800; color: white; cursor: pointer; }

    .action-bar button:hover { opacity: 0.9; }


/* Top content container */
.top_content_count_and_info_company {
    display: flex;
    flex-direction: row; 
    flex-wrap: nowrap;
    align-items: center;
    width: 100%;
    margin-bottom: 30px;
}
.left_side_top_content_company_info {
    flex: 0 0 85%;
    max-width: 85%;
    text-align: left;
}
.left_side_top_content_company_info h1, 
.left_side_top_content_company_info h2, 
.left_side_top_content_company_info p {
    text-align: left !important;
    margin: 5px 0;
}

.left_side_top_content_company_info h2 {
    font-size: 2rem;
    /* color: #333; */
}

/* Right side tender count */
.tight_side_top_content_tender_count {
    flex: 0 0 15%;
    max-width: 15%;
    text-align: right;
    display: flex;
    flex-direction: column;
    align-items: flex-end; 
}

.tight_side_top_content_tender_count::before {
    content: "Total Tender";
    display: block;
    font-size: 1.2rem;
    color: #666;
}

.tight_side_top_content_tender_count,
.tender_count_number {
    font-size: 130px;
    color: #007bff;
    margin: 0;
    line-height: 1;
}

/* --- New Style for 1st Place Count on this page --- */
.tender-win-count {
    background: #02eb25;
    color: #000;
    padding: 5px 20px;
    border-radius: 20px;
    font-size: 1.5rem; /* Larger font for this page */
    margin-top: 10px;
    font-weight: bold;
    border: 2px solid #00c91e;
    box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    display: inline-block;
    text-align: center;
}

/* Table responsive container */
.table-responsive-container {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin-top: 20px;
    border-radius: 8px; 
}

#tenderTable {
    min-width: 1000px;
    width: 100%;
    border-collapse: collapse;
}

.table-responsive-container::-webkit-scrollbar {
    height: 8px;
}
.table-responsive-container::-webkit-scrollbar-thumb {
    background: #009879;
    border-radius: 10px;
}
/* Currency Styles */
.currency-usd {
    color: #0D0B63; 
    font-weight: bold;
    background: #e1f3f3;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    border: 1px solid rgba(13, 11, 99, 0.2);
}

.currency-bdt {
    color: #009879;
    font-weight: bold;
    background: #e8f5e9;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    border: 1px solid rgba(0, 152, 121, 0.2);
}

.price-amount {
    font-weight: 700;
    color: #160C40;
    margin-right: 4px;
}
/* Status Badge Styles */
.status-badge {
    font-weight: bold;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.85rem;
    display: inline-block;
    text-align: center;
    min-width: 100px;
}

.status-submitted {
    background-color: #e8f5e9;
    color: #2e7d32;
    border: 1px solid #c8e6c9;
}

.status-not-submitted {
    background-color: #ffebee;
    color: #c62828;
    border: 1px solid #ffcdd2;
}

.result-badge {
    font-weight: bold;
    padding: 3px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    display: inline-block;
}

.result-1st {
    background-color: #02eb25; 
    color: #000;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    border: 1px solid #02eb16;
}

.result-others {
    color: #555;
}
/* * Responsive - Mobile view */
@media (max-width: 768px) {
    .top_content_count_and_info_company {
        flex-wrap: wrap;
    }
    .left_side_top_content_company_info, 
    .tight_side_top_content_tender_count {
        flex: 0 0 100%;
        max-width: 100%;
        text-align: center;
        align-items: center;
    }
    .left_side_top_content_company_info h2, 
    .left_side_top_content_company_info p {
        text-align: center !important;
    }
}

/* * --- Custom Scrollbar Styling --- */
::-webkit-scrollbar {
    width: 12px;            
    height: 12px;           
}
::-webkit-scrollbar-track {
    background: var(--bg-dark, #160C40); 
    border-radius: 10px;
}
::-webkit-scrollbar-thumb {
    background: var(--primary, #46B5D3); 
    border-radius: 10px;
    border: 3px solid var(--bg-dark, #160C40);
}
::-webkit-scrollbar-thumb:hover {
    background: var(--you_access_icon, #4CAF50); 
}

* {
    scrollbar-width: thin;
    scrollbar-color: var(--primary, #46B5D3) var(--bg-dark, #160C40);
}


</style>

<div class="all_tender_container">
    <?php 
    //* Finding the name of the participating company from that company's first tender
    $p_query = mysqli_query($conn, "SELECT tender_participate_company FROM tenders WHERE tender_company_id=".$company['id']." LIMIT 1");
    $p_data = mysqli_fetch_assoc($p_query);
?>
    <div class="top_content_count_and_info_company">
        <div class="left_side_top_content_company_info">
            <h2>Participate Company Name: <?php echo htmlspecialchars($p_data['tender_participate_company'] ?? 'N/A'); ?></h2>
            <h2>Tender List for Company: <?php echo htmlspecialchars($company['company_name']); ?></h2>
            <p>Description: <?php echo htmlspecialchars($company['description']); ?></p>
            <p>Today Date: <?php echo date('Y-m-d'); ?></p>
        </div>
        
        <div class="tight_side_top_content_tender_count">
            <h2 id="tender-count" class="tender_count_number"><?php echo $total_tenders; ?></h2>
            
            <?php if($total_wins > 0): ?>
                <div class="tender-win-count" title="Total 1st Place Wins">
                    1st: <?php echo $total_wins; ?>
                </div>
            <?php else: ?>
                 <div class="tender-win-count" style="background:#ddd; color:#555;" title="No Wins Yet">
                    1st: 0
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="action-bar">
    <button onclick="exportFullPage()" class="btn-full-page">Full Page Export</button>
    <button onclick="exportTable('tenderTable')" class="btn-full-table">Full Table Export</button>
    <button onclick="exportSelected()" class="btn-selected">Export Selected Items</button>
    
    <input type="text" id="searchInput" class="search-input" placeholder="Search by SL, Name, Ref No, Status, Price, Brand...">
</div>
<div class="table-responsive-container">
    <table border="1" cellpadding="10" cellspacing="0" width="100%" id="tenderTable">
        <thead>
            <tr>
                <th>S/L</th>
                <th>Tender Name</th>
                <th>Tender Ref No</th>
                <th>Published Date</th>
                <th>Submitted Date</th>
                <th>Tender Status</th>
                <th>Quoted Price</th>
                <th>Tender Result</th>
                <th>Brand</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody id="tenderBody">
            <?php 
            $sl = 1;
            while($row = mysqli_fetch_assoc($tenders_result)) { ?>
            <tr onclick="toggleSelect(this)">
                <td>
                    <span class="check-mark">✓</span> 
                    <span class="sl-text"><?php echo $sl++; ?></span>
                </td>
                <td><?php echo htmlspecialchars($row['tender_name']); ?></td>
                <td><?php echo htmlspecialchars($row['tender_ref_no']); ?></td>
                <td><?php echo $row['published_date']; ?></td>
                <td><?php echo $row['submitted_date']; ?></td>
                <td>
    <?php 
        $status = $row['tender_status'];
        
        $status_class = ($status == 'Submitted') ? 'status-submitted' : 'status-not-submitted';
    ?>
    <span class="status-badge <?php echo $status_class; ?>">
        <?php echo htmlspecialchars($status); ?>
    </span>
</td>
                <td>
    <?php 
        $formatted_price = number_format($row['quoted_price'], 2);
        $currency = !empty($row['currency']) ? $row['currency'] : 'BDT';
        
        $currency_class = ($currency == 'USD') ? 'currency-usd' : 'currency-bdt';
    ?>
    <span class="price-amount"><?php echo $formatted_price; ?></span> 
    <span class="<?php echo $currency_class; ?>"><?php echo $currency; ?></span>
</td>


               <td>
    <?php 
        $result = trim($row['tender_result']);
        
        if ($result == '1st' || $result == '1-st') {
            echo '<span class="result-badge result-1st">' . htmlspecialchars($result) . '</span>';
        } else {
            echo '<span class="result-others">' . htmlspecialchars($result) . '</span>';
        }
    ?>
</td>


                <td><?php echo htmlspecialchars($row['brand']); ?></td>
                <td><?php echo htmlspecialchars($row['remarks']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</div>

<script>
// * --- 1. Selection logic ---
function toggleSelect(row) {
    row.classList.toggle('selected-row');
}

// * --- 2. Real time search (300 milliseconds delay)
let timeout = null;
document.getElementById('searchInput').addEventListener('keyup', function() {
    clearTimeout(timeout);
    const searchValue = this.value.toLowerCase();
    
    timeout = setTimeout(function() {
        const rows = document.querySelectorAll('#tenderBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    }, 300);
});

// * ---3. Export functions---

function generateExcel(htmlContent, fileName) {
    const template = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head><meta charset="UTF-8"><style>table{border-collapse:collapse;} th{background:#009879;color:white;} td,th{border:1px solid #000;padding:5px;}</style></head>
        <body>${htmlContent}</body></html>`;
    const blob = new Blob(['\ufeff', template], { type: 'application/vnd.ms-excel' });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = fileName + '.xls';
    link.click();
}

function exportFullPage() {
    const content = document.body.cloneNode(true);
    content.querySelectorAll('button, input, .check-mark').forEach(el => el.remove());
    generateExcel(content.innerHTML, 'Full_Page_Report');
}

function exportTable(tableID) {
    const table = document.getElementById(tableID).cloneNode(true);
    // * Remove check marks during export
    table.querySelectorAll('.check-mark').forEach(el => el.remove());
    generateExcel(table.outerHTML, 'Full_Table_Data');
}

function exportSelected() {
    const selectedRows = document.querySelectorAll('.selected-row');
    if (selectedRows.length === 0) {
        alert("Please select the item by clicking on the row in the table!");
        return;
    }

    let tempTable = document.createElement("table");
    let header = document.querySelector("#tenderTable thead").cloneNode(true);
    tempTable.appendChild(header);

    let tbody = document.createElement("tbody");
    selectedRows.forEach(row => {
        let rowClone = row.cloneNode(true);
        rowClone.querySelectorAll('.check-mark').forEach(el => el.remove());
        tbody.appendChild(rowClone);
    });
    tempTable.appendChild(tbody);

    generateExcel(tempTable.outerHTML, 'Selected_Tenders');
}

// * --- 4. Animated tender count ---
document.addEventListener("DOMContentLoaded", () => {
    const counterElement = document.getElementById('tender-count');
    const targetValue = parseInt(counterElement.innerText); // Total tenders
    let startValue = 0;
    
    // * Animation speed up by reducing duration (500 milliseconds = 0.5 seconds)
    const duration = 500; 
    
    // * Timing of each step
    const stepTime = targetValue > 0 ? Math.max(duration / targetValue, 10) : 0;

    if (targetValue > 0) {
        const timer = setInterval(() => {
            // * If the number of tenders is very large, more than one will be added at a time to speed up the process.
            const increment = Math.ceil(targetValue / (duration / 20)); 
            startValue += increment;

            if (startValue >= targetValue) {
                counterElement.innerText = targetValue;
                clearInterval(timer);
            } else {
                counterElement.innerText = startValue;
            }
        }, 20); // * Will update every 20 milliseconds.
    }
});
</script>

<?php require_once "../includes/footer.php"; ?>