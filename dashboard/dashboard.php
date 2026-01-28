<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: dashboard.php
*    Project: Tender Management System
*    Description:
*        This file represents the main dashboard after login.
*        It provides a summary view and quick navigation
*        to core modules such as tender companies, tenders,
*        and global search.
*
*    Version: 1.0.0
*    Author: Tender Management System Team
?    Developer Contact:
*        - Name: Firoj Hosen
*        - Email: firojdeveloper@gmail.com
*
*    Created Date and Time: 2026-01-18
*    Last Updated: 2026-01-18
*    License: Proprietary (Internal Use Only)
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor', 'Reviewer', 'Vendor']);


// *Total count for Status Overview
$tender_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tenders"))['total'] ?? 0;
$company_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tender_companies"))['total'] ?? 0;
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'] ?? 0;

$total_overview = $tender_count + $company_count + $user_count;

// পুরো সিস্টেমে কতগুলো টেন্ডারে ১ম (1st) হওয়া হয়েছে তা গণনা করা
$total_wins_sql = "SELECT COUNT(*) as all_wins 
                   FROM tenders 
                   WHERE tender_result = '1st' OR tender_result = '1-st'";

$total_wins_query = mysqli_query($conn, $total_wins_sql);
$total_wins_data = mysqli_fetch_assoc($total_wins_query);

$overall_system_wins = $total_wins_data['all_wins'] ?? 0;

//* 1. Calculating the total price from the database
$total_bdt_res = mysqli_query($conn, "SELECT SUM(quoted_price) as total FROM tenders WHERE currency = 'BDT' OR currency = '' OR currency IS NULL");
$total_usd_res = mysqli_query($conn, "SELECT SUM(quoted_price) as total FROM tenders WHERE currency = 'USD'");

$total_bdt = mysqli_fetch_assoc($total_bdt_res)['total'] ?? 0;
$total_usd = mysqli_fetch_assoc($total_usd_res)['total'] ?? 0;

//* 2. Function to convert numbers to words
if (!function_exists('numberToWords')) {
    function numberToWords($num) {
        $num = str_replace(array(',', ' '), '', trim($num));
        if(! (int) $num) return 'Zero';

        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );

        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = str_pad($num, $max_length, "0", STR_PAD_LEFT);
        $num_levels = str_split($num, 3);

        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } 
        
        return ucwords(implode(' ', $words));
    }
}


// *Percentage calculation for SVG donut charts
$p1 = ($total_overview > 0) ? ($tender_count / $total_overview) * 100 : 0;
$p2 = ($total_overview > 0) ? ($company_count / $total_overview) * 100 : 0;
$p3 = ($total_overview > 0) ? ($user_count / $total_overview) * 100 : 0;

// *Participation Trend Data Preparation
$days_list = [];
$tender_trend = [];
$company_trend = [];

for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $day_name = date('D', strtotime($date))[0]; // S, M, T, W...
    $days_list[] = $day_name;

    // *How many tenders are added per day (assuming you have a 'created_at' column in your table)
    $t_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tenders WHERE DATE(created_at) = '$date'");
    $tender_trend[] = mysqli_fetch_assoc($t_res)['total'] ?? 0;

    // *How many companies are added per day
    $c_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tender_companies WHERE DATE(created_at) = '$date'");
    $company_trend[] = mysqli_fetch_assoc($c_res)['total'] ?? 0;
}

// *Finding the maximum value to determine the height of the chart
$max_val = max(max($tender_trend), max($company_trend), 1); 

//? User Activity Tracer Chart Start

// *1. Get today's date
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// *2. Define roles (this is a fix for the error)
$role_name = ['Admin', 'Auditor', 'Reviewer', 'Tender Creator', 'Vendor'];

// *3. Fetch activity data from the database
$active_data = array_fill_keys($role_name, 0); 

$log_query = mysqli_query($conn, "SELECT role, SUM(duration_minutes) as total_min 
                FROM activity_logs 
                WHERE created_at = '$selected_date' 
                GROUP BY role");

if ($log_query) {
    while ($row = mysqli_fetch_assoc($log_query)) {
        if (array_key_exists($row['role'], $active_data)) {
            $active_data[$row['role']] = $row['total_min'];
        }
    }
}

// *Maximum value for determining the height of the graph
$max_minutes = max(max($active_data), 1); 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS | Dashboard</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #f0f2f5;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #dee2e6;
            --primary: #4361ee;
            --success: #2ecc71;
            --warning: #f1c40f;
            --danger: #e74c3c;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; transition: background 0.3s ease, color 0.3s ease; }
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            padding-top: 30px;
        }

        .container { width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 20px; }

        /* KPI Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 2rem;
        }

        .card {
            background: var(--bg-card);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: relative;
        }

        .stat-content { display: flex; justify-content: space-between; align-items: center; }
        .icon-box { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; }

        /* Mode Toggle inside a card or absolute */
        .theme-toggle {
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-body);
            border-radius: 50%;
            border: 1px solid var(--border);
        }

        /* Main Grid */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
            margin-bottom: 2rem;
        }
.dashboard-card {
    background: linear-gradient(135deg, #02eb25 0%, #009879 100%);
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: inline-block;
    min-width: 200px;
    margin: 10px;
}

.win-number {
    font-size: 3rem;
    font-weight: bold;
    margin: 0;
}

.dashboard-price-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.price-card {
    flex: 1;
    min-width: 300px;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border-left: 5px solid #009879;
}

.bdt-card { border-left-color: #009879; } 
.usd-card { border-left-color: #0D0B63; }
.bdt_icon_top{
    font-size: 24px;
    color: #009879;
    font-weight: bold;
}

.usd_icon_top{
    font-size: 24px;
    color: #0D0B63;
    font-weight: bold;
}
.card-icon {
    font-size: 40px;
    background: #f4f4f4;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-right: 20px;
    color: #333;
}

.card-info h3 { margin: 0; font-size: 1rem; color: #666; }
.card-info .amount { margin: 5px 0; font-size: 1.8rem; color: #160C40; }
.card-info .in-word { 
    margin: 0; 
    font-size: 0.85rem; 
    color: #555; 
    line-height: 1.4;
    text-transform: capitalize;
}

.price-stats-container {
    display: flex;
    gap: 20px;
    margin: 20px 0;
    /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
}

.stat-card {
    flex: 1;
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    border-top: 5px solid #ccc;
    transition: transform 0.3s ease;
}

.stat-card:hover { transform: translateY(-5px); }

.bdt-theme { border-top-color: #009879; }
.usd-theme { border-top-color: #0D0B63; }

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.currency-label {
    font-size: 0.9rem;
    font-weight: bold;
    color: #666;
    text-transform: uppercase;
}

.stat-header i {
    font-style: normal;
    font-size: 1.5rem;
    font-weight: bold;
    opacity: 0.3;
}

.main-amount {
    font-size: 2.2rem;
    color: #333;
    margin: 5px 0;
}

.word-convert {
    font-size: 0.85rem;
    color: #777;
    background: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    line-height: 1.4;
}


.table-container { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { text-align: left; padding: 12px; color: var(--text-muted); border-bottom: 2px solid var(--border); font-size: 12px; letter-spacing: 0.5px; }
        td { padding: 14px 12px; border-bottom: 1px solid var(--border); font-size: 14px; }

        .badge { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background: rgba(46, 204, 113, 0.15); color: var(--success); }
        .badge-warning { background: rgba(241, 196, 15, 0.15); color: var(--warning); }

        .activity-item { display: flex; gap: 15px; margin-bottom: 20px; }
        .activity-icon { color: var(--primary); font-size: 1.1rem; margin-top: 3px; }


/* --- Custom Scrollbar Styling --- */

::-webkit-scrollbar {
    width: 10px;               
    height: 10px;             
}

::-webkit-scrollbar-track {
    background: var(--bg-body); 
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;       
    border-radius: 10px;
    border: 2px solid var(--bg-body); 
    transition: background 0.3s ease;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary); 
}

[data-theme="dark"] ::-webkit-scrollbar-thumb {
    background: #475569;       
    border: 2px solid var(--bg-body);
}

[data-theme="dark"] ::-webkit-scrollbar-thumb:hover {
    background: var(--primary); 
}

/* --- Firefox Support (Limited styling) --- */
* {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

.activity-feed::-webkit-scrollbar {
    width: 6px; 
}

.activity-feed::-webkit-scrollbar-thumb {
    background: var(--border);
}

.donut-segment {
    cursor: pointer;
    transition: stroke-width 0.3s ease, opacity 0.3s ease;
}
.donut-segment:hover {
    stroke-width: 4;
    opacity: 0.8;
}
#center-label { transition: all 0.3s ease; }

.trend-bar-group {
    transition: transform 0.2s ease, opacity 0.2s ease;
    cursor: pointer;
}
.trend-bar-group:hover {
    transform: scaleX(1.1);
    opacity: 1 !important;
}
.trend-bar-group:hover .bar {
    filter: brightness(1.2);
}


/* Donut chart animation */
@keyframes donut-show {
    from { stroke-dasharray: 0 100; }
}
.donut-segment {
    animation: donut-show 1.5s ease-out forwards;
}

/* Bar chart animation */
@keyframes bar-up {
    from { height: 0; opacity: 0; }
    to { opacity: 1; }
}
.animate-bar {
    animation: bar-up 1s ease-out forwards;
}

/* Bar top text style */
.bar-top-text {
    font-size: 9px;
    font-weight: bold;
    margin-bottom: 2px;
    opacity: 0;
    animation: fadeIn 0.5s forwards 1s; 
}

@keyframes fadeIn {
    to { opacity: 1; }
}

/* User Activity Tracer Chart */

.full-width-card {
    grid-column: 1 / -1; 
    background: var(--bg-card);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    margin-bottom: 2rem;
}

.activity-bar {
    width: 30px;
    background: linear-gradient(to top, var(--primary), #6366f1);
    border-radius: 4px 4px 0 0;
    position: relative;
    transition: all 0.3s ease;
    animation: bar-up 1.2s ease-out forwards;
}

.activity-bar:hover {
    filter: brightness(1.2);
    cursor: pointer;
}

/* Tooltip for hover */
.activity-bar::after {
    content: attr(data-time);
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--text-main);
    color: var(--bg-card);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 10px;
    white-space: nowrap;
    opacity: 0;
    transition: 0.3s;
}

.activity-bar:hover::after {
    opacity: 1;
}


        @media (max-width: 1100px) {
            .main-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
        }

    </style>
</head>
<body data-theme="light">

<div class="container">
    <section class="stats-grid">
        <div class="card" style="border-left: 4px solid var(--primary);">
            <div class="stat-content">
                <div>
                    <p style="color: var(--text-muted); font-size: 12px; font-weight: 700; margin-bottom: 4px;">SYSTEM STATUS</p>
                    <h4 id="currentDateTime" style="margin-bottom: 2px; font-size: 16px;"></h4>
                    <small style="color: var(--success); font-weight: 600;"><i class="fas fa-circle" style="font-size: 8px;"></i> Online</small>
                </div>
                <div class="theme-toggle" id="themeBtn" title="Toggle Dark/Light Mode">
                    <i class="fas fa-moon"></i>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="stat-content">
                <div>
                    <p style="color: var(--text-muted); font-size: 12px; font-weight: 700;">TOTAL TENDERS</p>
                    <h2 style="margin: 5px 0;"><?php echo $tender_count; ?></h2>
                    <small style="color: var(--success); font-weight: 600;"><i class="fas fa-arrow-up"></i> <?php echo $tender_count; ?></small>
                </div>
                <div class="icon-box" style="background: var(--primary);"><i class="fas fa-file-contract"></i></div>
            </div>
        </div>

        <div class="card">
            <div class="stat-content">
                <div>
                    <p style="color: var(--text-muted); font-size: 12px; font-weight: 700;">TOTAL TENDER WIN</p>
                    <h2 style="margin: 5px 0;"><?php echo $overall_system_wins; ?></h2>
                    <small style="color: var(--success); font-weight: 600;"><i class="fas fa-arrow-up"></i> <?php echo $overall_system_wins; ?></small>
                </div>
                <div class="icon-box" style="background: var(--primary);"><i class="fas fa-file-contract"></i></div>
            </div>
        </div>

        <div class="card">
            <div class="stat-content">
                <div>
                    <p style="color: var(--text-muted); font-size: 12px; font-weight: 700;">TOTAL COMPANIES</p>
                    <h2 style="margin: 5px 0;"><?php echo $company_count; ?></h2>
                    <small style="color: var(--success); font-weight: 600;"><i class="fas fa-arrow-up"></i> <?php echo $company_count; ?></small>
                </div>
                <div class="icon-box" style="background: var(--success);"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <!-- <div class="card" style="background: var(--primary); color: white; cursor: pointer;" onclick="alert('Open Create Modal')">
            <div class="stat-content">
                <div>
                    <p style="color: rgba(255,255,255,0.8); font-size: 12px; font-weight: 700;">QUICK ACTION</p>
                    <h4 style="margin: 5px 0; font-weight: 700;">New Tender</h4>
                    <small style="color: rgba(255,255,255,0.9);">Start a new process</small>
                </div>
                <div class="icon-box" style="background: rgba(255,255,255,0.2);"><i class="fas fa-plus"></i></div>
            </div>
        </div> -->
    </section>
<div class="price-stats-container">
    <div class="stat-card bdt-theme">
        <div class="stat-header">
            <span class="currency-label">TOTAL AMOUNT BDT</span>
            <p class="bdt_icon_top">৳</p>
        </div>
        <div class="stat-body">
            <h2 class="main-amount"><?php echo number_format($total_bdt, 2); ?> <span style="color: #2ECC71;">BDT</span></h2>
            <p class="word-convert"><strong>In Word:</strong> <?php echo numberToWords($total_bdt); ?> Taka Only.</p>
        </div>
    </div>

    <div class="stat-card usd-theme">
        <div class="stat-header">
            <span class="currency-label">TOTAL AMOUNT USD</span>
            <p class="usd_icon_top">$</p>
        </div>
        <div class="stat-body">
            <h2 class="main-amount"><?php echo number_format($total_usd, 2); ?> <span style="color: #0D0B63;">USD</span></h2>
            <p class="word-convert"><strong>In Word:</strong> <?php echo numberToWords($total_usd); ?> Dollars Only.</p>
        </div>
    </div>
</div>
<section class="main-grid">
    <div class="card" style="text-align: center;">
    <h4 style="margin-bottom: 20px; font-size: 16px;">Status Overview</h4>
    <div style="position: relative; display: inline-block;">
        <svg width="180" height="180" viewBox="0 0 42 42" class="donut">
            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="var(--border)" stroke-width="3"></circle>
            
            <circle class="donut-segment" cx="21" cy="21" r="15.9155" fill="transparent" stroke="#4361ee" stroke-width="3" 
                    stroke-dasharray="<?php echo $p1; ?> <?php echo (100-$p1); ?>" stroke-dashoffset="25"
                    onmouseover="updateChartLabel('Tenders', '<?php echo $tender_count; ?>', '#4361ee')" 
                    onmouseout="resetChartLabel()"></circle>
            
            <circle class="donut-segment" cx="21" cy="21" r="15.9155" fill="transparent" stroke="#2ecc71" stroke-width="3" 
                    stroke-dasharray="<?php echo $p2; ?> <?php echo (100-$p2); ?>" stroke-dashoffset="<?php echo (25 - $p1); ?>"
                    onmouseover="updateChartLabel('Companies', '<?php echo $company_count; ?>', '#2ecc71')" 
                    onmouseout="resetChartLabel()"></circle>
            
            <circle class="donut-segment" cx="21" cy="21" r="15.9155" fill="transparent" stroke="#f1c40f" stroke-width="3" 
                    stroke-dasharray="<?php echo $p3; ?> <?php echo (100-$p3); ?>" stroke-dashoffset="<?php echo (25 - $p1 - $p2); ?>"
                    onmouseover="updateChartLabel('Users', '<?php echo $user_count; ?>', '#f1c40f')" 
                    onmouseout="resetChartLabel()"></circle>
        </svg>

        <div id="center-label" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); pointer-events: none;">
            <h3 id="chart-value" style="margin: 0;"><?php echo $total_overview; ?></h3>
            <small id="chart-name" style="color: var(--text-muted); font-weight: bold;">Total</small>
        </div>
    </div>
    
    <div style="margin-top: 15px; display: flex; justify-content: center; gap: 10px; font-size: 11px;">
        <span><i class="fas fa-circle" style="color: #4361ee;"></i> Tenders</span>
        <span><i class="fas fa-circle" style="color: #2ecc71;"></i> Companies</span>
        <span><i class="fas fa-circle" style="color: #f1c40f;"></i> Users</span>
    </div>
</div>

    <div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h4 style="font-size: 16px;">Participation Trend (Weekly)</h4>
        <div id="trend-info" style="font-size: 12px; font-weight: bold; color: var(--primary); background: var(--bg-body); padding: 2px 8px; border-radius: 4px; visibility: hidden;">
            Hover over bars
        </div>
    </div>
    
    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 10px; font-size: 10px;">
        <span><i class="fas fa-square" style="color: #4361ee;"></i> Tenders</span>
        <span><i class="fas fa-square" style="color: #2ecc71;"></i> Companies</span>
    </div>

    <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 150px; border-left: 2px solid var(--border); border-bottom: 2px solid var(--border); padding-left: 5px; padding-top: 10px;">
        <?php foreach($days_list as $index => $day): 
            $t_count = $tender_trend[$index];
            $c_count = $company_trend[$index];
            $t_height = ($max_val > 0) ? ($t_count / $max_val) * 100 : 0;
            $c_height = ($max_val > 0) ? ($c_count / $max_val) * 100 : 0;
            
            // *To extract the full name of the day (to show the time on hover)
            $full_day_name = date('l', strtotime("-$index days")); 
        ?>
            <div class="trend-bar-group" 
                 style="display: flex; flex-direction: column; align-items: center; width: 12%; height: 100%; justify-content: flex-end;"
                 onmouseover="showTrendDetail('<?php echo $t_count; ?>', '<?php echo $c_count; ?>')" 
                 onmouseout="hideTrendDetail()">
                
                <div style="display: flex; align-items: flex-end; gap: 2px; width: 100%; height: 100%;">
                    <div class="bar animate-bar" style="flex: 1; background: #4361ee; height: <?php echo $t_height; ?>%; border-radius: 2px 2px 0 0; min-height: <?php echo ($t_count > 0 ? '2px' : '0'); ?>;"></div>
                    <div class="bar animate-bar" style="flex: 1; background: #2ecc71; height: <?php echo $c_height; ?>%; border-radius: 2px 2px 0 0; min-height: <?php echo ($c_count > 0 ? '2px' : '0'); ?>;"></div>
                </div>
                <span style="font-size: 10px; margin-top: 5px; color: var(--text-muted); font-weight: bold;"><?php echo $day; ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</section>
<!-- User Activity Tracer Chart Start-->

<section class="full-width-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h4 style="font-size: 16px;">User Activity Tracker (Daily Roles)</h4>
        <input type="date" value="<?php echo $selected_date; ?>" 
               onchange="window.location.href='dashboard.php?date='+this.value"
               style="padding: 5px; border-radius: 5px; background: var(--bg-body); color: var(--text-main); border: 1px solid var(--border);">
    </div>

    <div style="height: 300px; display: flex; align-items: flex-end; justify-content: space-around; padding-bottom: 40px; border-bottom: 2px solid var(--border); position: relative;">
        
        <?php 
        // *To avoid errors, I am checking whether the variable is an array or not.
        if (isset($role_name) && is_array($role_name)): 
            foreach($role_name as $role): 
                $min = $active_data[$role];
                $height = ($min / $max_minutes) * 100;
                $h = floor($min / 60);
                $m = round($min % 60);
        ?>
            <div style="display: flex; flex-direction: column; align-items: center; width: 15%; height: 100%; justify-content: flex-end;">
                <span class="bar-top-text" style="color: var(--primary); font-size: 10px; margin-bottom: 5px;">
                    <?php echo ($min > 0) ? "{$h}h {$m}m" : "0m"; ?>
                </span>
                <div class="activity-bar animate-bar" 
                     style="height: <?php echo $height; ?>%; width: 45px; background: linear-gradient(to top, #4361ee, #4cc9f0); border-radius: 5px 5px 0 0;">
                </div>
                <span style="font-size: 12px; margin-top: 10px; color: var(--text-muted); font-weight: 600;">
                    <?php echo $role; ?>
                </span>
            </div>
        <?php 
            endforeach; 
        endif; 
        ?>
    </div>
</section>
<!-- User Activity Tracer Chart End -->

    <section class="main-grid" style="grid-template-columns: 2fr 1fr;">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-size: 16px;">Recent Tenders</h4>
                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600;">View All</a>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>TENDER ID</th>
                            <th>TITLE</th>
                            <th>DEADLINE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#T-901</td>
                            <td>Road Construction Sector-B</td>
                            <td>Oct 25, 2026</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td><i class="fas fa-external-link-alt" style="cursor:pointer; color: var(--primary);"></i></td>
                        </tr>
                        <tr>
                            <td>#T-882</td>
                            <td>Hospital Equipment Supply</td>
                            <td>Nov 02, 2026</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td><i class="fas fa-external-link-alt" style="cursor:pointer; color: var(--primary);"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h4 style="margin-bottom: 20px; font-size: 16px;">Recent Activity</h4>
            <div class="activity-feed">
                <div class="activity-item">
                    <i class="fas fa-plus-circle activity-icon"></i>
                    <div>
                        <p style="font-size: 13px;"><strong>Admin</strong> published Tender #901</p>
                        <small style="color: var(--text-muted);">Just now</small>
                    </div>
                </div>
                <div class="activity-item">
                    <i class="fas fa-user-check activity-icon" style="color: var(--success);"></i>
                    <div>
                        <p style="font-size: 13px;"><strong>Vendor:</strong> Rahim applied</p>
                        <small style="color: var(--text-muted);">45 mins ago</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <footer style="text-align: center; padding-bottom: 2rem; color: var(--text-muted); font-size: 12px;">
        TMS Pro Version 2.1.0 &bull; &copy; <?php echo date("Y"); ?>
    </footer> -->
</div>

<script>
    // 1. Theme Toggle
    const themeBtn = document.getElementById('themeBtn');
    const body = document.body;

    themeBtn.addEventListener('click', () => {
        const isDark = body.getAttribute('data-theme') === 'dark';
        body.setAttribute('data-theme', isDark ? 'light' : 'dark');
        themeBtn.innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
    });

    // 2. Real-time Clock
    function updateTime() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
        const dateStr = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' });
        const timeStr = now.toLocaleTimeString('en-US', options);
        document.getElementById('currentDateTime').innerText = dateStr + " | " + timeStr;
    }
    setInterval(updateTime, 1000);
    updateTime();


// *Function to change the information in the middle when hovering
function updateChartLabel(name, value, color) {
    document.getElementById('chart-value').innerText = value;
    document.getElementById('chart-value').style.color = color;
    document.getElementById('chart-name').innerText = name;
    document.getElementById('chart-name').style.color = color;
}

// *Function to reset the information in the middle when mouse leaves
function resetChartLabel() {
    document.getElementById('chart-value').innerText = '<?php echo $total_overview; ?>';
    document.getElementById('chart-value').style.color = 'inherit';
    document.getElementById('chart-name').innerText = 'Total';
    document.getElementById('chart-name').style.color = 'var(--text-muted)';
}

function showTrendDetail(tenders, companies) {
    const infoDiv = document.getElementById('trend-info');
    infoDiv.style.visibility = 'visible';
    infoDiv.innerHTML = `<i class="fas fa-file-contract"></i> ${tenders} Tenders | <i class="fas fa-building"></i> ${companies} Companies`;
}

function hideTrendDetail() {
    const infoDiv = document.getElementById('trend-info');
    infoDiv.style.visibility = 'hidden';
}

// user activity date change handler Demo function

document.getElementById('activityDate').addEventListener('change', function() {
    let selectedDate = this.value;
    alert("Fetching activity data for: " + selectedDate);
    
});


// End of Script
</script>
<?php require_once "../includes/footer.php"; ?>
</body>
</html>
