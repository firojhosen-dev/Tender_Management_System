<?php
// Include database if accessed via AJAX
if (file_exists("../config/database.php")) {
    require_once "../config/database.php";
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query to filter companies based on company name OR related tender names
$sql = "SELECT DISTINCT c.* FROM tender_companies c 
        LEFT JOIN tenders t ON c.id = t.tender_company_id 
        WHERE c.company_name LIKE '%$search%' 
        OR t.tender_name LIKE '%$search%'
        OR t.tender_participate_company LIKE '%$search%'
        ORDER BY c.company_name ASC";

$companies_result = mysqli_query($conn, $sql);

if (mysqli_num_rows($companies_result) > 0) {
    while($company = mysqli_fetch_assoc($companies_result)) { 
        // Get the participating company name
        $p_query = mysqli_query($conn, "SELECT tender_participate_company FROM tenders WHERE tender_company_id=".$company['id']." LIMIT 1");
        $p_data = mysqli_fetch_assoc($p_query);
        ?>

        <div style="border:1px solid #ccc; padding:15px; margin-bottom:20px; border-radius: 8px; background: #fff;">
            <h3 style="text-align: center;">Participate Company Name: <?php echo htmlspecialchars($p_data['tender_participate_company'] ?? 'N/A'); ?></h3>
            <h3 style="text-align: center;">Tenderer Company Name: <?php echo htmlspecialchars($company['company_name']); ?></h3>
            <p style="text-align: center;">Today Date: <?php echo date('Y-m-d'); ?></p>

            <br>
            <h5>Tenders under this company:</h5>

            <?php
            $tenders_result = mysqli_query($conn, "SELECT * FROM tenders WHERE tender_company_id=".$company['id']." ORDER BY id ASC");
            if (mysqli_num_rows($tenders_result) > 0) { ?>
                <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <tr style="background-color: #f2f2f2;">
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
                    <?php 
                    $sl = 1;
                    while($tender = mysqli_fetch_assoc($tenders_result)) { ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo htmlspecialchars($tender['tender_name']); ?></td>
                        <td><?php echo htmlspecialchars($tender['tender_ref_no']); ?></td>
                        <td><?php echo $tender['published_date']; ?></td>
                        <td><?php echo $tender['submitted_date']; ?></td>
                        <td><?php echo $tender['tender_status']; ?></td>
                        <td><?php echo $tender['quoted_price']; ?></td>
                        <td><?php echo htmlspecialchars($tender['tender_result']); ?></td>
                        <td><?php echo htmlspecialchars($tender['brand']); ?></td>
                        <td><?php echo htmlspecialchars($tender['remarks']); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>No tenders available for this company.</p>
            <?php } ?>
        </div>
    <?php } 
} else {
    echo "<p style='text-align:center; padding: 20px;'>No results found for '$search'.</p>";
}
?>