<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: global_search.php
* Project: Tender Management System
* Description: Global search with one-line advanced search, dark mode, and responsive UI.
* Version: 1.1.1
* Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor', 'Reviewer', 'Vendor']); 

$search_results = [];
$search_type = "";

/* Fetch companies for dropdown */
$companies_result = mysqli_query($conn, "SELECT * FROM tender_companies ORDER BY company_name ASC");

if (isset($_POST['search'])) {
    $company_id = intval($_POST['company_id'] ?? 0);
    $tender_name = trim($_POST['tender_name'] ?? '');
    $tender_ref_no = trim($_POST['tender_ref_no'] ?? '');
    $tender_status = trim($_POST['tender_status'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $global_text = trim($_POST['global_text'] ?? '');

    if ($global_text != "") {
        $search_type = "global";
        $global_safe = mysqli_real_escape_string($conn, $global_text);
        $sql = "SELECT t.*, c.company_name 
                FROM tenders t 
                LEFT JOIN tender_companies c ON t.tender_company_id = c.id
                WHERE t.tender_name LIKE '%$global_safe%' 
                   OR t.tender_ref_no LIKE '%$global_safe%'
                   OR t.tender_status LIKE '%$global_safe%'
                   OR t.brand LIKE '%$global_safe%'
                   OR t.tender_participate_company LIKE '%$global_safe%'
                   OR c.company_name LIKE '%$global_safe%'
                ORDER BY t.id DESC";
    } else {
        $search_type = "advanced";
        $conditions = [];
        if ($company_id > 0) $conditions[] = "t.tender_company_id = $company_id";
        if ($tender_name != "") $conditions[] = "t.tender_name LIKE '%".mysqli_real_escape_string($conn, $tender_name)."%'";
        if ($tender_ref_no != "") $conditions[] = "t.tender_ref_no LIKE '%".mysqli_real_escape_string($conn, $tender_ref_no)."%'";
        if ($tender_status != "") $conditions[] = "t.tender_status LIKE '%".mysqli_real_escape_string($conn, $tender_status)."%'";
        if ($brand != "") $conditions[] = "t.brand LIKE '%".mysqli_real_escape_string($conn, $brand)."%'";
        
        $sql = "SELECT t.*, c.company_name FROM tenders t LEFT JOIN tender_companies c ON t.tender_company_id = c.id";
        if (count($conditions) > 0) { $sql .= " WHERE " . implode(" AND ", $conditions); }
        $sql .= " ORDER BY t.id DESC";
    }

    $search_results = mysqli_query($conn, $sql);

    // Logging search history
    $user_id = $_SESSION['user_id'] ?? 0;
    if ($user_id) {
        $search_parts = [];
        if (!empty($global_text)) { $search_parts[] = "Global Search: " . $global_text; } 
        else {
            if ($company_id > 0) $search_parts[] = "Company ID: $company_id";
            if ($tender_name != "") $search_parts[] = "Tender Name: $tender_name";
            if ($tender_ref_no != "") $search_parts[] = "Ref: $tender_ref_no";
        }
        if (!empty($search_parts)) {
            $search_query = mysqli_real_escape_string($conn, implode(" | ", $search_parts));
            mysqli_query($conn, "INSERT INTO search_history (user_id, search_query) VALUES ($user_id, '$search_query')");
        }
    }
}
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<style>
    :root {
        --bg-color: #f4f7f6;
        --card-bg: #ffffff;
        --text-color: #333;
        --primary-color: #009879;
        --accent-color: #46B5D3;
        --border-color: #ddd;
        --input-bg: #fff;
    }

    body.dark-theme {
        --bg-color: #121212;
        --card-bg: #1e1e1e;
        --text-color: #e0e0e0;
        --border-color: #333;
        --input-bg: #2d2d2d;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        font-family: 'Segoe UI', sans-serif;
        transition: 0.3s;
    }

    .search-wrapper {
        max-width: 1250px;
        margin: 0 auto;
    }

    .header-section {
        text-align: center;
        margin-bottom: 30px;
    }

    .header-section h1 {
        color: var(--primary-color);
        margin: 0;
    }

    .search-card {
        background: var(--card-bg);
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid var(--border-color);
    }

    /* One Line Advanced Search Style */
    .advanced-row-single {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }

    .single-input-group {
        flex: 1;
        min-width: 187px;
    }

    .single-input-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--primary-color);
    }

    .single-input-group input, 
    .single-input-group select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--input-bg);
        color: var(--text-color);
        outline: none;
    }

    .btn-search {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
        height: 40px;
    }

    .btn-search:hover { opacity: 0.9; transform: translateY(-2px); }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 30px 0;
        color: #888;
    }
    .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid var(--border-color); }
    .divider span { padding: 0 15px; font-weight: bold; font-size: 12px; }

    .global-bar-container {
        display: flex;
        gap: 10px;
        background: var(--input-bg);
        padding: 8px;
        border-radius: 50px;
        border: 2px solid var(--primary-color);
        max-width: 700px;
        margin: 0 auto;
        margin-top: 97PX;
    }

    .global-bar-container input {
        flex: 1;
        border: none;
        background: transparent;
        padding-left: 15px;
        color: var(--text-color);
        outline: none;
    }

    /* Table Styles */
    .table-container {
        margin-top: 40px;
        overflow-x: auto;
        background: var(--card-bg);
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    table { width: 100%; border-collapse: collapse; min-width: 900px; }
    th { background: var(--primary-color); color: white; padding: 15px; text-align: left; }
    td { padding: 12px 15px; border-bottom: 1px solid var(--border-color); }
    tr:hover { background: rgba(0,152,121,0.05); }

    .view-btn {
        text-decoration: none;
        color: var(--primary-color);
        font-weight: bold;
        border: 1px solid var(--primary-color);
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 13px;
        transition: 0.3s;
    }
    .view-btn:hover { background: var(--primary-color); color: white; }
    @media (max-width: 768px) {
        .single-input-group { min-width: 100%; }
        .btn-search { width: 100%; }
    }
</style>


<div class="search-wrapper">
    <div class="header-section">
        <h1>Global Tender Search</h1>
        <p>Advanced filtering and global data lookup</p>
    </div>

    <div class="search-card">
        <form method="post" action="">
            <div class="advanced-row-single">
                <div class="single-input-group">
                    <label>Tender Company</label>
                    <select name="company_id">
                        <option value="0">All Companies</option>
                        <?php 
                        mysqli_data_seek($companies_result, 0);
                        while($company = mysqli_fetch_assoc($companies_result)) { ?>
                            <option value="<?php echo $company['id']; ?>"><?php echo htmlspecialchars($company['company_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="single-input-group">
                    <label>Tender Name</label>
                    <input type="text" name="tender_name" placeholder="Name...">
                </div>
                <div class="single-input-group">
                    <label>Ref No</label>
                    <input type="text" name="tender_ref_no" placeholder="Ref...">
                </div>
                <div class="single-input-group">
                    <label>Status</label>
                    <input type="text" name="tender_status" placeholder="Status...">
                </div>
                <div class="single-input-group">
                    <label>Brand</label>
                    <input type="text" name="brand" placeholder="Brand...">
                </div>
                <div class="single-input-group" style="flex: 0;">
                    <button type="submit" name="search" class="btn-search">Search</button>
                </div>
            </div>

            <div class="divider"><span>OR GLOBAL SEARCH</span></div>

            <div class="global-bar-container">
                <input type="text" name="global_text" placeholder="Type anything to search across all fields...">
                <button type="submit" name="search" class="btn-search" style="border-radius: 50px;">🔍 Search</button>
            </div>
        </form>
    </div>

    <?php if (isset($_POST['search'])) { ?>
        <div class="header-section" style="margin-top: 40px; margin-bottom: 10px;">
            <h3>Search Results (<?php echo mysqli_num_rows($search_results); ?>)</h3>
        </div>

        <div class="table-container">
            <?php if (mysqli_num_rows($search_results) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Company</th>
                            <th>Tender Name</th>
                            <th>Ref No</th>
                            <th>Published</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sl = 1;
                        while($row = mysqli_fetch_assoc($search_results)) { ?>
                        <tr>
                            <td><?php echo $sl++; ?></td>
                            <td style="font-weight: 600;"><?php echo htmlspecialchars($row['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['tender_name']); ?></td>
                            <td><code><?php echo htmlspecialchars($row['tender_ref_no']); ?></code></td>
                            <td><?php echo $row['published_date']; ?></td>
                            <td><?php echo $row['submitted_date']; ?></td>
                            <td><?php echo $row['tender_status']; ?></td>
                            <td style="font-weight: bold; color: var(--primary-color);"><?php echo $row['quoted_price']; ?></td>
                            <td>
                                <a href="view_search_result.php?tender_id=<?php echo $row['id']; ?>" class="view-btn">View More</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div style="padding: 40px; text-align: center; color: #888;">
                    No results found matching your criteria.
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <div style="margin-top: 30px; text-align: center;">
        <a href="../dashboard/dashboard.php" style="color: var(--accent-color); text-decoration: none; font-weight: bold;">← Back to Dashboard</a>
    </div>
</div>

<script>
    function toggleTheme() {
        const body = document.body;
        const btn = document.getElementById('theme-btn');
        body.classList.toggle('dark-theme');
        
        if(body.classList.contains('dark-theme')) {
            btn.innerHTML = '☀️';
            localStorage.setItem('theme', 'dark');
        } else {
            btn.innerHTML = '🌙';
            localStorage.setItem('theme', 'light');
        }
    }

    // Initialize saved theme
    window.onload = () => {
        if(localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-theme');
            document.getElementById('theme-btn').innerHTML = '☀️';
        }
    }
</script>

<?php include "../includes/footer.php"; ?>