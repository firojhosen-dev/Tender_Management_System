<?php
/**
 * footer.php - Tender Management System
 */
$system_name    = "TMS Pro - Tender Management System";
$current_year   = date("Y");
$system_version = "v1.1.2";
$load_time      = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
?>

<style>
    /* --- Sticky Footer Logic --- */
    html, body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* The content-wrapper grows to fill all empty space */
    .content-wrapper {
        flex: 1 0 auto;
        padding: 20px; /* Adjust based on your design */
        margin-top: var(--header-height); /* Space for fixed navbar */
    }

    /* --- Footer Styling --- */
    .tms-footer {
        flex-shrink: 0; /* Prevents footer from being squashed */
        background: var(--surface);
        border-top: 1px solid var(--border-color);
        padding: 1.5rem 0;
        color: var(--text-muted);
        font-size: 0.875rem;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .tms-footer .footer-link {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s ease;
        margin: 0 5px;
    }

    .tms-footer .footer-link:hover {
        color: var(--primary);
    }

    .tms-footer .version-tag {
        background: var(--app-bg);
        border: 1px solid var(--border-color);
        padding: 2px 8px;
        border-radius: 4px;
        font-family: monospace;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.75rem;
    }

    .footer-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 2rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .footer-flex {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }
</style>

</main>

<footer class="tms-footer">
    <div class="footer-flex">
        <div class="footer-left">
            <div>
                &copy; <?php echo $current_year; ?> 
                <span style="color: var(--text-main); font-weight: 700;">
                    <?php echo htmlspecialchars($system_name); ?>
                </span>
                <span class="version-tag ms-2"><?php echo $system_version; ?></span>
            </div>
            <div style="font-size: 0.75rem; margin-top: 5px; opacity: 0.8;">
                Page rendered in <?php echo number_format($load_time, 3); ?> seconds
            </div>
        </div>

        <nav class="footer-right">
            <a href="../system/system_information.php" class="footer-link">System Information</a>
            <a href="../system/documentation.php" class="footer-link">Documentation</a>
            <a href="../vendors/vendor_list.php" class="footer-link">Vendor</a>
            <span style="color: var(--border-color)">|</span>
            <a href="../system/support_desk.php" class="footer-link">Support Desk</a>
            <span style="color: var(--border-color)">|</span>
            <a href="../system/privacy_policy.php" class="footer-link">Privacy Policy</a>
            <!-- <a href="../system/file_feature.php" class="footer-link">File Feature</a> -->
            <a href="../system/readme.php" class="footer-link">README.md</a>
            <a href="#top" class="footer-link" style="margin-left: 15px;">
                <i class="fas fa-chevron-up"></i>
            </a>
        </nav>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Smooth Scroll to Top
        $('a[href="#top"]').on('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
</body>
</html>