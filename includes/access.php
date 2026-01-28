<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
* Filename: access.php
* Description:
* Handles role-based access control.
* Redirects unauthorized users to a
* friendly Access Denied page.
*
* Version: 2.1.0 (Fixed Header Issue)
===========================================
*/

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check role permission for a page
 *
 * @param array $allowed_roles
 */
function checkRole(array $allowed_roles = [])
{
    // If role not set OR role not allowed
    if (
        !isset($_SESSION['role_name']) ||
        !in_array($_SESSION['role_name'], $allowed_roles)
    ) {
        // Detect current page path
        $requested_page = basename($_SERVER['PHP_SELF']);
        $redirect_url = "../you_not_access_this_page.php?page=" . urlencode($requested_page);

        // Check if headers are already sent
        if (!headers_sent()) {
            // Standard PHP Redirect
            header("Location: " . $redirect_url);
            exit;
        } else {
            // Fallback: JavaScript Redirect (If HTML already loaded)
            echo "<script type='text/javascript'>";
            echo "window.location.href = '" . $redirect_url . "';";
            echo "</script>";
            // Fallback for non-JS browsers
            echo "<noscript><meta http-equiv='refresh' content='0;url=" . $redirect_url . "'></noscript>";
            exit;
        }
    }
}
?>