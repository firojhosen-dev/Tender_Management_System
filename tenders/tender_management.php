<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: tender_management.php
* Version: 2.2.0 (Real-Time Search Added)
===========================================
*/

require_once "../config/database.php";
require_once "../includes/access.php";

// 1. Check Role
checkRole(['Admin']); 

// 2. Handle Delete Logic
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $return_page = isset($_GET['page']) ? $_GET['page'] : 1;
    mysqli_query($conn, "DELETE FROM tenders WHERE id=$id");
    header("Location: tender_management.php?page=$return_page&msg=deleted");
    exit;
}

// =======================================================================
// 3. AJAX SEARCH HANDLER
//    If this block runs, it outputs HTML and stops. It does not load the full page.
// =======================================================================
if (isset($_POST['search_query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search_query']);
    
    // Condition to filter Tenders
    $tender_condition = "";
    if(!empty($search)){
        $tender_condition = " AND (
            t.tender_name LIKE '%$search%' OR 
            t.tender_ref_no LIKE '%$search%' OR 
            t.submitted_date LIKE '%$search%' OR 
            t.tender_status LIKE '%$search%' OR 
            t.quoted_price LIKE '%$search%'
        )";
    }

    // Main Company Query (Find companies that have matching tenders)
    $companies_sql = "SELECT c.* FROM tender_companies c
                      INNER JOIN tenders t ON c.id = t.tender_company_id
                      WHERE 1=1 $tender_condition
                      GROUP BY c.id
                      ORDER BY c.id DESC";
                      // Note: We remove LIMIT during search to show all matches
    
    $companies_result = mysqli_query($conn, $companies_sql);

    // --- Output the Result HTML ---
    if (mysqli_num_rows($companies_result) > 0) {
        while($company = mysqli_fetch_assoc($companies_result)) {
            
            // Inner Query: Fetch Tenders for this company that MATCH the search
            // If search is empty, shows all. If search exists, shows only matches.
            $inner_sql = "SELECT * FROM tenders t 
                          WHERE t.tender_company_id=".$company['id'] . $tender_condition . " 
                          ORDER BY t.id DESC";
                          
            $tenders_result = mysqli_query($conn, $inner_sql);
            $total_tenders = mysqli_num_rows($tenders_result);

            // Get Participate Name
            $first_row = mysqli_fetch_assoc($tenders_result);
            $participate_name = $first_row['tender_participate_company'] ?? 'N/A';
            if($total_tenders > 0) mysqli_data_seek($tenders_result, 0);
            ?>

            <div class="company_card">
                <div class="company_header">
                    <div class="company_info">
                        <h3>Participate Company: <strong><?php echo htmlspecialchars($participate_name); ?></strong></h3>
                        <h3>Tenderer Company: <strong><?php echo htmlspecialchars($company['company_name']); ?></strong></h3>
                    </div>
                    <div class="header_right">
                        <div class="tender-count-badge">Found: <?php echo $total_tenders; ?></div>
                        <div class="company_date">ID: #<?php echo $company['id']; ?></div>
                    </div>
                </div>
                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>S/L</th>
                                <th>Tender Name</th>
                                <th>Ref No</th>
                                <th>Published</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Quoted Price</th>
                                <th>Result</th>
                                <th>Brand</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sl = 1;
                            while($tender = mysqli_fetch_assoc($tenders_result)) { ?>
                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo htmlspecialchars($tender['tender_name']); ?></td>
                                <td><?php echo htmlspecialchars($tender['tender_ref_no']); ?></td>
                                <td><?php echo $tender['published_date']; ?></td>
                                <td><?php echo $tender['submitted_date']; ?></td>
                                <!-- <td><?php echo $tender['tender_status']; ?></td> -->
                                 <td>
    <?php 
        $status = trim($tender['tender_status']);
        $status_class = ($status == 'Submitted') ? 'status-submitted' : 'status-not-submitted';
    ?>
    <span class="status-badge <?php echo $status_class; ?>">
        <?php echo htmlspecialchars($status); ?>
    </span>
</td>
                                <!-- <td><?php echo $tender['quoted_price']; ?></td> -->
                                 <td>
    <?php 
        $formatted_price = number_format($tender['quoted_price'], 2);
        $currency = !empty($tender['currency']) ? $tender['currency'] : 'BDT';
        echo $formatted_price . " " . $currency; 
    ?>
</td>
                                <!-- <td><?php echo htmlspecialchars($tender['tender_result']); ?></td> -->
<td>
    <?php 
        $result = trim($tender['tender_result']);
        if ($result == '1st' || $result == '1-st') {
            echo '<span style="background:#FFD700; color:#000; padding:3px 8px; border-radius:10px; font-weight:bold;">' . htmlspecialchars($result) . '</span>';
        } else {
            echo htmlspecialchars($result);
        }
    ?>
</td>
                                <td><?php echo htmlspecialchars($tender['brand']); ?></td>
                                <td><?php echo htmlspecialchars($tender['remarks']); ?></td>
                                <td class="action-links">
                                    <a href="edit_tender.php?edit_id=<?php echo $tender['id']; ?>" class="edit-link">Edit</a>
                                    <a href="tender_management.php?delete_id=<?php echo $tender['id']; ?>" class="delete-link" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <?php 
        } 
    } else {
        echo "<div class='no_results'>No tenders found matching your search.</div>";
    }
    exit; // STOP script here for AJAX calls
}
// ================= END AJAX HANDLER =================


// 4. Regular Page Load (Standard Pagination)
require_once "../includes/header.php";

$results_per_page = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$start_from = ($page - 1) * $results_per_page;

// Count logic for pagination
$count_sql = "SELECT COUNT(DISTINCT tender_company_id) AS total FROM tenders";
$count_query = mysqli_query($conn, $count_sql);
$row_count = mysqli_fetch_assoc($count_query);
$total_companies = $row_count['total'];
$total_pages = ceil($total_companies / $results_per_page);

// Initial Load SQL (Paginated)
$companies_sql = "SELECT c.* FROM tender_companies c
                  INNER JOIN tenders t ON c.id = t.tender_company_id
                  GROUP BY c.id
                  ORDER BY c.id DESC 
                  LIMIT $start_from, $results_per_page";
$companies_result = mysqli_query($conn, $companies_sql);
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<style>
    @import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
    * { font-family: 'Rajdhani', sans-serif; box-sizing: border-box; }
    .main-container { padding: 10px; max-width: 100%; }
    
    /* Top Bar & Search */
    .top-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    /* Search Input Styling */
    .search-box-container {
        position: relative;
        flex-grow: 1;
        max-width: 400px;
    }
    #search_input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 20px;
        outline: none;
        transition: border 0.3s;
        font-size: 1rem;
    }
    #search_input:focus { border-color: #009879; box-shadow: 0 0 5px rgba(0,152,121,0.3); }
    .search-loader {
        position: absolute; right: 15px; top: 12px;
        display: none; color: #009879; font-weight: bold; font-size: 0.8rem;
    }

    .add-btn {
        background-color: #009879; color: white; padding: 10px 20px;
        text-decoration: none; border-radius: 5px; font-weight: 600;
    }
    .add-btn:hover { background-color: #007f65; }

    /* Card & Table Styles */
    .company_card { border: 1px solid #ccc; border-radius: 8px; margin-bottom: 30px; background-color: #E1F3F3; box-shadow: 0 2px 5px rgba(0,0,0,0.1); overflow: hidden; }
    .company_header { background-color: #f1f8f8; padding: 15px; border-bottom: 2px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center; }
    .company_info h3 { margin: 5px 0; font-size: 1.1rem; color: #160C40; }
    .header_right { text-align: right; }
    .tender-count-badge { display: inline-block; background-color: #ff9800; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.9rem; font-weight: bold; }
    .company_date { font-size: 0.85rem; color: #666; margin-top: 5px; }
    .table-container { overflow-x: auto; padding: 10px; background-color: white; }
    .styled-table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
    .styled-table th { background-color: #009879; color: white; text-align: left; padding: 12px; }
    .styled-table td { padding: 10px 12px; border-bottom: 1px solid #ddd; }
    .styled-table tr:hover { background-color: #f5f5f5; }
    .action-links a { text-decoration: none; font-weight: bold; margin: 0 5px; }
    .edit-link { color: #2196F3; } 
    .delete-link { color: #F44336; }
.styled-table td:nth-child(6) {
    font-weight: 600;
    color: #333;
    white-space: nowrap;
}

.currency-usd {
    color: #0D0B63; 
    font-weight: bold;
    background: #e1f3f3;
    padding: 2px 6px;
    border-radius: 4px;
}

.currency-bdt {
    color: #009879;
    font-weight: bold;
    background: #e8f5e9;
    padding: 2px 6px;
    border-radius: 4px;
}

.price-amount {
    font-weight: 600;
    color: #333;
}

.status-badge {
    font-weight: bold;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.85rem;
    display: inline-block;
    text-align: center;
    min-width: 90px;
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
.action-links {
    white-space: nowrap; 
    text-align: center;  
    vertical-align: middle;
}

.btn-action {
    display: inline-block; 
    margin: 2px 4px;   
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none !important;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.edit-link {
    background-color: #2196F3;
    color: white !important;
}

.delete-link {
    background-color: #f44336;
    color: white !important;
}
    /* Pagination */
    .pagination { display: flex; justify-content: center; margin-top: 30px; margin-bottom: 50px; gap: 5px; }
    .pagination a { color: #333; padding: 8px 16px; text-decoration: none; border: 1px solid #ddd; background-color: white; border-radius: 4px; }
    .pagination a.active { background-color: #009879; color: white; border: 1px solid #009879; }
    
    .no_results { text-align: center; font-size: 1.2rem; color: #666; padding: 40px; }
</style>

<div class="main-container">

    <div class="top-action-bar">
        <h3>Tender Management</h3>
        
        <div class="search-box-container">
            <input type="text" id="search_input" placeholder="Search Name, Ref, Price, Status...">
            <span class="search-loader">Searching...</span>
        </div>

        <a href="add_tender.php" class="add-btn">+ Add New Tender</a>
    </div>

    <div id="results_area">
        <?php 
        // --- DEFAULT VIEW (Paginated) ---
        if (mysqli_num_rows($companies_result) > 0) {
            while($company = mysqli_fetch_assoc($companies_result)) { 
                $tenders_sql = "SELECT * FROM tenders WHERE tender_company_id=".$company['id']." ORDER BY id DESC";
                $tenders_result = mysqli_query($conn, $tenders_sql);
                $total_tenders = mysqli_num_rows($tenders_result);
                $first_row = mysqli_fetch_assoc($tenders_result);
                $participate_name = $first_row['tender_participate_company'] ?? 'N/A';
                if($total_tenders > 0) mysqli_data_seek($tenders_result, 0);
        ?>

        <div class="company_card" style="overflow-x: auto;">
            <div class="company_header">
                <div class="company_info">
                    <h3>Participate Company: <strong><?php echo htmlspecialchars($participate_name); ?></strong></h3>
                    <h3>Tenderer Company: <strong><?php echo htmlspecialchars($company['company_name']); ?></strong></h3>
                </div>
                <div class="header_right">
                    <div class="tender-count-badge">Total: <?php echo $total_tenders; ?></div>
                    <div class="company_date">ID: #<?php echo $company['id']; ?></div>
                </div>
            </div>
            <div class="table-container">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Tender Name</th>
                            <th>Ref No</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th>Quoted Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sl = 1;
                        while($tender = mysqli_fetch_assoc($tenders_result)) { ?>
                        <tr>
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo htmlspecialchars($tender['tender_name']); ?></td>
                            <td><?php echo htmlspecialchars($tender['tender_ref_no']); ?></td>
                            <td><?php echo $tender['submitted_date']; ?></td>
                            <td>
                                <?php 
                                    $status = trim($tender['tender_status']);
                                    $status_class = ($status == 'Submitted') ? 'status-submitted' : 'status-not-submitted';
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                    $formatted_price = number_format($tender['quoted_price'], 2);
                                    $currency = !empty($tender['currency']) ? $tender['currency'] : 'BDT';
                                    $currency_class = ($currency == 'USD') ? 'currency-usd' : 'currency-bdt';
                                ?>
                                <span class="price-amount"><?php echo $formatted_price; ?></span> 
                                <span class="<?php echo $currency_class; ?>"><?php echo $currency; ?></span>
                            </td>
                            <td class="action-links">
                                <a href="edit_tender.php?edit_id=<?php echo $tender['id']; ?>" class="btn-action edit-link">
                                    Edit
                                </a>
                                <a href="tender_management.php?delete_id=<?php echo $tender['id']; ?>&page=<?php echo $page; ?>" class="btn-action delete-link" onclick="return confirm('Are you sure you want to delete this tender?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php 
            }
        } else {
            echo "<p class='no_results'>No Data Found.</p>";
        }
        ?>

        <div class="pagination" id="default_pagination">
            <?php if($page > 1): ?>
                <a href="?page=<?php echo $page-1; ?>">&laquo; Prev</a>
            <?php endif; ?>
            <?php
            $range = 2; 
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == 1 || $i == $total_pages || ($i >= $page - $range && $i <= $page + $range)) {
                    $active = ($i == $page) ? 'class="active"' : '';
                    echo "<a href='?page=$i' $active>$i</a>";
                } elseif ($i == $page - $range - 1 || $i == $page + $range + 1) {
                    echo "<span>...</span>";
                }
            }
            ?>
            <?php if($page < $total_pages): ?>
                <a href="?page=<?php echo $page+1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div> </div>

<script>
$(document).ready(function(){
    let timer;
    const waitTime = 300; // 300 milliseconds

    $('#search_input').on('keyup', function(){
        let query = $(this).val();
        
        // Show loader
        $('.search-loader').show();

        // Clear previous timer
        clearTimeout(timer);

        // Set new timer
        timer = setTimeout(function(){
            
            if(query.length > 0) {
                // Hide pagination during search
                $('#default_pagination').hide();

                $.ajax({
                    url: 'tender_management.php', // Request sends to same file
                    method: 'POST',
                    data: { search_query: query },
                    success: function(response){
                        $('#results_area').html(response);
                        $('.search-loader').hide();
                    }
                });
            } else {
                window.location.href = "tender_management.php"; 
            }
        }, waitTime);
    });
});
</script>

</body>
</html>