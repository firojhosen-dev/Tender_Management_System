<?php
require_once __DIR__ . "/database.php";

function getSetting($key)
{
    global $conn;
    $key = mysqli_real_escape_string($conn, $key);

    $result = mysqli_query(
        $conn,
        "SELECT setting_value FROM system_settings WHERE setting_key='$key' LIMIT 1"
    );

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['setting_value'];
    }

    return null;
}
