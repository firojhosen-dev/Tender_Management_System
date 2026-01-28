<?php
function getSetting($key, $default = null) {
    global $conn;
    static $settings = [];

    if (empty($settings)) {
        $result = mysqli_query($conn, "SELECT setting_key, setting_value FROM system_settings");
        while ($row = mysqli_fetch_assoc($result)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    return $settings[$key] ?? $default;
}
