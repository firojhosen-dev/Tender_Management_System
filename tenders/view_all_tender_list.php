<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: view_all_tender_list.php
* Project: Tender Management System
* Description:
* This file lists all tender companies and their tenders.
* Each company is shown in a card format with its name,
* description, and buttons: View Tender List | Edit | Delete.
* All tenders under each company are displayed in a table.
* Includes logic to count Total tenders and 1st position wins.
*
* Version: 1.1.0 (Updated)
* Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor', 'Reviewer', 'Vendor']); // All users can access

/* Handle company delete */
if (isset($_GET['delete_company_id'])) {
    $company_id = intval($_GET['delete_company_id']);
    mysqli_query($conn, "DELETE FROM tender_companies WHERE id=$company_id");
    mysqli_query($conn, "DELETE FROM tenders WHERE tender_company_id=$company_id"); // Delete related tenders
    header("Location: view_all_tender_list.php");
    exit;
}

/* --- Pagination Logic Start --- */
$limit = 5; // Page Limit
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$count_res = mysqli_query($conn, "SELECT COUNT(DISTINCT tender_company_id) as total FROM tenders");
$total_companies = mysqli_fetch_assoc($count_res)['total'];
$total_pages = ceil($total_companies / $limit);
/* --- Pagination Logic End --- */

/* Fetch companies that HAVE tenders with Pagination */
$sql = "SELECT c.* FROM tender_companies c 
        WHERE EXISTS (SELECT 1 FROM tenders t WHERE t.tender_company_id = c.id) 
        ORDER BY c.company_name ASC LIMIT $limit OFFSET $offset";
$companies_result = mysqli_query($conn, $sql);
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<style>
.company_card{
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 5px;
    margin-bottom: 30px;
    background-color: #E1F3F3;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin: 5px;
} 
.company_header{
    background-color: #f9f9f900;
    padding: 15px;
    border-bottom: 2px solid #e0e0e0;
    margin-bottom: 10px;
}
.table-container {
    overflow-x: auto;
    margin: 20px 0;
    font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}
.styled-table {
    border-collapse: collapse;
    width: 100%;
    background-color: #ffffff00;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    overflow: hidden; 
}
#tenderTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
.no_tender_this_table {
    text-align: center;
    font-size: 1rem;
    color: #f00000;
}
h2{ text-align: center; margin-bottom: 15px; }
h3, p { text-align: center; }

/* --- New Styles for Search and Pagination --- */
.search-box {
    text-align: center;
    margin: 20px 0;
}
#tenderSearch {
    width: 60%;
    padding: 12px;
    border-radius: 25px;
    border: 2px solid #009879;
    outline: none;
}
.tender-count {
    background: #009879;
    color: white;
    padding: 2px 10px;
    border-radius: 15px;
    font-size: 0.9rem;
    margin-left: 10px;
}
/* New style for 1st Place Count */
.tender-win-count {
    background: #02eb25;
    color: #000;
    padding: 2px 10px;
    border-radius: 15px;
    font-size: 0.9rem;
    margin-left: 5px;
    font-weight: bold;
    border: 1px solid #00c91e;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination-container {
    text-align: center;
    margin: 30px 0;
}
.pagination-container a {
    display: inline-block;
    padding: 8px 16px;
    border: 1px solid #009879;
    color: #009879;
    text-decoration: none;
    margin: 0 4px;
    border-radius: 4px;
}
.pagination-container a.active {
    background-color: #009879;
    color: white;
}

.currency-usd, .currency-bdt {
    font-weight: bold;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    display: inline-block;
    margin-left: 4px;
}

.currency-usd {
    color: #0D0B63; 
    background-color: #e1f3f3;
    border: 1px solid rgba(13, 11, 99, 0.2);
}

.currency-bdt {
    color: #009879;
    background-color: #e8f5e9;
    border: 1px solid rgba(0, 152, 121, 0.2);
}

.price-amount {
    font-weight: 600;
    color: #333;
}

.search-price {
    white-space: nowrap;
}

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
    background-color: #02eb25 !important; 
    color: #000 !important; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    border: 1px solid #02eb16;
}

.result-others {
    color: #555;
}
</style>

<div class="all_tender_container">
<h2>All Tender Companies and Their Tenders</h2>

<div class="search-box">
    <input type="text" id="tenderSearch" placeholder="Search by Name, Ref, Date, Status or Price...">
</div>

<div style="text-align: center;">
    <button onclick="exportAllTablesToExcel('all_tenders_report')" style="margin-bottom: 20px; padding: 10px;">Export All Tables to One Excel</button>
</div>

<?php while($company = mysqli_fetch_assoc($companies_result)) { ?>

<div class="company_card">
    <div class="company_header">
    <?php 
        $p_query = mysqli_query($conn, "SELECT tender_participate_company FROM tenders WHERE tender_company_id=".$company['id']." LIMIT 1");
        $p_data = mysqli_fetch_assoc($p_query);
        
        // 2. Count Tenders AND 1st Position Wins
        // Using Conditional Aggregation to count 1st/1-st
        $count_sql = "SELECT 
                        COUNT(*) as total, 
                        SUM(CASE WHEN tender_result = '1st' OR tender_result = '1-st' THEN 1 ELSE 0 END) as total_first
                      FROM tenders 
                      WHERE tender_company_id=".$company['id'];
        
        $count_query = mysqli_query($conn, $count_sql);
        $count_data = mysqli_fetch_assoc($count_query);

        // Ensure we don't display NULL if 0
        $total_wins = $count_data['total_first'] ? $count_data['total_first'] : 0;
    ?>
    <h3>Participate Company Name: <?php echo htmlspecialchars($p_data['tender_participate_company'] ?? 'N/A'); ?></h3>
    <h3>
        Tenderer Company Name: <?php echo htmlspecialchars($company['company_name'] ?? 'N/A'); ?>
        <span class="tender-count">Total: <?php echo $count_data['total']; ?></span>
        <span class="tender-win-count">1st: <?php echo $total_wins; ?></span>
    </h3>
    <p>Today Date: <?php echo date('Y-m-d'); ?></p>
</div>

<div class="table-container">
    <h2>Tender List</h2>
    <?php
    $tenders_result = mysqli_query($conn, "SELECT * FROM tenders WHERE tender_company_id=".$company['id']." ORDER BY id ASC");
    if (mysqli_num_rows($tenders_result) > 0) { ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%" class="styled-table" id="tenderTable">
            <thead>
                <tr>
                    <th>S/L</th>
                    <th>Tender Name</th>
                    <th>Ref No</th>
                    <th>Published Date</th>
                    <th>Submitted Date</th>
                    <th>Status</th>
                    <th>Quoted Price</th>
                    <th>Result</th>
                    <th>Brand</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody class="tender-tbody">
            <?php $sl = 1;
            while($tender = mysqli_fetch_assoc($tenders_result)) { ?>
            <tr class="tender-row">
                <td><?php echo $sl++; ?></td>
                <td class="search-name"><?php echo htmlspecialchars($tender['tender_name']); ?></td>
                <td class="search-ref"><?php echo htmlspecialchars($tender['tender_ref_no']); ?></td>
                <td><?php echo $tender['published_date']; ?></td>
                <td class="search-date"><?php echo $tender['submitted_date']; ?></td>
                
                <td>
                    <?php 
                        $status = $tender['tender_status']; 
                        $status_class = ($status == 'Submitted') ? 'status-submitted' : 'status-not-submitted';
                    ?>
                    <span class="status-badge <?php echo $status_class; ?>">
                        <?php echo htmlspecialchars($status); ?>
                    </span>
                </td>

                <td class="search-price">
                    <?php 
                        $formatted_price = number_format($tender['quoted_price'], 2);
                        $currency = !empty($tender['currency']) ? $tender['currency'] : 'BDT';
                        $currency_class = ($currency == 'USD') ? 'currency-usd' : 'currency-bdt';
                    ?>
                    <span class="price-amount"><?php echo $formatted_price; ?></span> 
                    <span class="<?php echo $currency_class; ?>"><?php echo $currency; ?></span>
                </td>

                <td>
                    <?php 
                        $result = trim($tender['tender_result']); 
                        if ($result == '1st' || $result == '1-st') {
                            echo '<span class="result-badge result-1st">' . htmlspecialchars($result) . '</span>';
                        } else {
                            echo '<span class="result-others">' . htmlspecialchars($result) . '</span>';
                        }
                    ?>
                </td>

                <td><?php echo htmlspecialchars($tender['brand']); ?></td>
                <td><?php echo htmlspecialchars($tender['remarks']); ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="no_tender_this_table">No tenders available for this company.</p>
    <?php } ?>
</div>
</div>

<?php } ?>

<div class="pagination-container">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

</div>

<script>
/* Real-time Search with 300ms delay */
let searchTimer;
document.getElementById('tenderSearch').addEventListener('input', function() {
    clearTimeout(searchTimer);
    let filter = this.value.toLowerCase();
    
    searchTimer = setTimeout(() => {
        let cards = document.querySelectorAll('.company_card');
        
        cards.forEach(card => {
            let rows = card.querySelectorAll('.tender-row');
            let hasMatch = false;
            
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = "";
                    hasMatch = true;
                } else {
                    row.style.display = "none";
                }
            });
            
            // Hide company card if no tenders match
            card.style.display = hasMatch ? "" : "none";
        });
    }, 300);
});

/* Export to Excel function */
function exportAllTablesToExcel(filename = ''){
    var dataType = 'application/vnd.ms-excel';
    var tables = document.querySelectorAll("table");
    var fullHTML = "";

    tables.forEach(function(table) {
        fullHTML += table.outerHTML + "<br><br>"; 
    });

    var filename = filename ? filename + '.xls' : 'all_data.xls';
    var downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);

    var excelTemplate = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head><meta charset="UTF-8"></head>
        <body>${fullHTML}</body>
        </html>`;

    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', excelTemplate], { type: dataType });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = 'data:' + dataType + ', ' + encodeURIComponent(excelTemplate);
        downloadLink.download = filename;
        downloadLink.click();
    }
}
</script>
</body>
</html>