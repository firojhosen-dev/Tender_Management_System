<?php 
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: you_not_access_this_page.php
*    Project: Tender Management System
*    Description:
*        This page is shown when a user tries to access
*        a page without proper permission.
*        Displays a user-friendly Access Denied message
*        along with the blocked page name.
*
*    Version: 1.0.0
*    Author: Tender Management System Team
===========================================
*/

$page = htmlspecialchars($_GET['page'] ?? 'Unknown Page');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | Enterprise Security</title>
    <link rel="shortcut icon" href="assets/image/system_logo.jpg" type="image/x-icon">
<style>
    @import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
:root {
    --bg-color: #f8faff;
    --primary-purple: #9d50bb;
    --primary-blue: #2d3436;
    --accent-orange: #f9ca24;
    --muted-gray: #b2bec3;
    --soft-border: rgba(0, 0, 0, 0.05);
    --monitor-frame: #e0e6ed;
    --grad-purple: linear-gradient(135deg, #6e8efb, #a777e3);
    --grad-orange: linear-gradient(135deg, #f09819, #edde5d);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    background-color: var(--bg-color);
    color: var(--primary-blue);
    height: 100vh;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    position: relative;
    width: 100%;
    max-width: 800px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 20px;
}

/* --- Illustration Components --- */

.illustration-wrapper {
    position: relative;
    width: 100%;
    height: 350px;
    display: flex;
    justify-content: center;
    align-items: flex-end;
    margin-bottom: 40px;
}

/* Monitor */
.monitor {
    width: 420px;
    height: 280px;
    position: relative;
    z-index: 2;
}

.screen {
    width: 100%;
    height: 100%;
    background: white;
    border: 12px solid var(--monitor-frame);
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.screen-header {
    height: 20px;
    background: #f1f3f5;
    display: flex;
    padding: 5px 10px;
    gap: 4px;
}

.screen-header .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--muted-gray);
}

/* Container styling for the monitor header */
.screen-header {
    height: 40px;
    background: #ffffff;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    padding: 0 16px;
    gap: 8px; /* Space between the dots */
    position: relative;
}

/* Individual window control dots */
.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #dfe4ea;
}

/* The address/page name bar styling */
.page_name {
    position: absolute;
    left: 50%;
    transform: translateX(-50%); 
    width: 60%; 
    height: 22px;
    background-color: #f1f2f6; 
    border-radius: 11px; 
    display: flex;
    align-items: center;
    padding: 0 15px;
    border: 1px solid rgba(0, 0, 0, 0.03);
}

/* Text styling inside the page bar */
.page_name p {
    font-size: 10px;
    color: #a4b0be;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; 
    letter-spacing: 0.3px;
}

/* Optional: Slight hover effect on the page name bar */
.page_name:hover {
    background-color: #e9eaee;
    cursor: default;
}

.screen-content {
    position: relative;
    height: calc(100% - 20px);
}

.sidebar {
    position: absolute;
    width: 25%;
    height: 100%;
    background: #f8f9fa;
    border-right: 1px solid #eee;
}
.sidebar-item {
    width: 95px;
    height: 20px;
    background: #f1f3f5;
    border-radius: 5px;
    margin: 3px;
}
.top-bar {
    position: absolute;
    left: 25%;
    width: 75%;
    height: 40px;
    background: white;
    border-bottom: 1px solid #eee;
}


/* Left Section: Logo and System Title */
.top_bar_left_company_info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.company_logo {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    background: var(--primary-purple, #9d50bb); /* Fallback color */
    object-fit: cover;
}

.company_name {
    font-size: 13px;
    font-weight: 600;
    color: #a6d0dc;
    letter-spacing: -0.2px;
}

/* Character-specific adjustment: If images fail to load */
img {
    font-size: 0; 
}
.grid-cards {
    position: absolute;
    top: 50px;
    left: 30%;
    width: 65%;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.card {
    width: 45%;
    height: 40px;
    background: #f1f3f5;
    border-radius: 4px;
}

.monitor-neck {
    width: 40px;
    height: 30px;
    background: var(--monitor-frame);
    margin: 0 auto;
}

.monitor-base {
    width: 120px;
    height: 8px;
    background: var(--monitor-frame);
    margin: 0 auto;
    border-radius: 4px 4px 0 0;
}

/* Warning Triangle */
.warning-triangle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-left: 50px solid transparent;
    border-right: 50px solid transparent;
    border-bottom: 85px solid var(--primary-purple);
    display: flex;
    justify-content: center;
}

.warning-triangle::after {
    content: '';
    position: absolute;
    top: 10px;
    left: -40px;
    border-left: 40px solid transparent;
    border-right: 40px solid transparent;
    border-bottom: 68px solid white;
}

.exclamation {
    position: absolute;
    top: 35px;
    color: var(--primary-purple);
    font-weight: bold;
    font-size: 32px;
    z-index: 5;
}

/* Lock */
.lock-container {
    position: absolute;
    left: 140px;
    bottom: 80px;
    z-index: 10;
    animation: float 3s ease-in-out infinite;
}

.lock-shackle {
    width: 40px;
    height: 40px;
    border: 8px solid var(--accent-orange);
    border-bottom: none;
    border-radius: 20px 20px 0 0;
    margin: 0 auto -5px;
}

.lock-body {
    width: 70px;
    height: 60px;
    background: var(--grad-orange);
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.keyhole {
    width: 12px;
    height: 12px;
    background: white;
    border-radius: 50%;
}

/* Human Character */
.character {
    position: absolute;
    right: 80px;
    bottom: 0;
    width: 80px;
    height: 150px;
    z-index: 5;
}

.head {
    width: 25px;
    height: 25px;
    background: #ffdbac;
    border-radius: 50%;
    margin: 0 auto;
}

.torso {
    width: 35px;
    height: 50px;
    background: #ff00ab;
    border-radius: 10px;
    margin: 2px auto;
}

.legs { display: flex; justify-content: space-around; padding: 0 15px; }
.leg-left, .leg-right { width: 10px; height: 50px; background: #2d3436; }

.arms { position: absolute; top: 30px; width: 100%; display: flex; justify-content: space-between; }
.arm-left, .arm-right {
    width: 30px;
    height: 10px;
    background: #ff00ab;
    border-radius: 5px;
}
.arm-left { transform: rotate(-45deg); }
.arm-right { transform: rotate(45deg); }

/* Decoration */
.folder {
    position: absolute;
    right: 180px;
    bottom: 20px;
    width: 60px;
    height: 45px;
    background: var(--grad-orange);
    border-radius: 4px;
    z-index: 1111;
}
.folder-tab-bg {
    position: absolute;
    top: -10px;
    left: 0;
    width: 100%;
    height: 15px;
    background: #edd98f;
    border-radius: 4px 4px 0 0;
    z-index: 1110;
}
.key {
    position: absolute;
    left: 150px;
    bottom: 20px;
    display: flex;
    align-items: center;
}

.key-ring {
    width: 25px;
    height: 25px;
    border: 4px solid var(--primary-purple);
    border-radius: 50%;
    z-index: 1111;
}

.key-shaft {
    width: 40px;
    height: 4px;
    background: var(--primary-purple);
    z-index: 1111;
}

/* --- Text & UI --- */

.content {
    z-index: 10;
}

.main-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: #d1d8e0;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 10px;
}

.subtitle {
    font-size: 1.1rem;
    color: #7f8c8d;
    line-height: 1.6;
    margin-bottom: 30px;
}

.btn-primary {
    background: var(--grad-purple);
    color: white;
    border: none;
    padding: 14px 32px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    margin-right: 20px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(110, 142, 251, 0.3);
}

.link-secondary {
    color: var(--primary-purple);
    text-decoration: none;
    font-weight: 600;
}

/* --- Animations --- */

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.char-question-mark {
    position: absolute;
    top: -20px;
    font-weight: bold;
    color: var(--primary-purple);
    animation: float 2s ease-in-out infinite;
}
.q1 { left: 10px; }
.q2 { right: 10px; animation-delay: 0.5s; }

/* Responsive */
@media (max-width: 600px) {
    .monitor { width: 300px; height: 200px; }
    .character { display: none; }
    .main-title { font-size: 2rem; }
    .lock-container { left: 40%; }
}


/* Container to hold everything */
.bg_text {
    position: relative;
    width: 100%;
    max-width: 1200px;
    height: 600px; /* Adjust based on your illustration height */
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: visible;
}

/* Base style for the large background numbers */
.bg_left_text, 
.bg_right_text {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1; /* Sits behind the monitor */
}

.bg_left_text h1, 
.bg_right_text h1 {
    font-size: 30rem; /* Massive size for the background */
    font-weight: 900;
    color: #ced6e0; /* Light gray to match your 'Access Denied' text */
    opacity: 0.3; /* Subtle background effect */
    line-height: 1;
    margin: 0;
    user-select: none;
    animation: floatingNumbers 6s ease-in-out infinite;
}
.bg_right_text h1 {
    animation-delay: 3s;
}

/* --- The Animation Keyframes --- */
@keyframes floatingNumbers {
    0% {
        transform: translateY(0px) scale(1);
        opacity: 0.2;
    }
    50% {
        /* Moves up slightly and becomes a bit more visible */
        transform: translateY(-20px) scale(1.02);
        opacity: 0.3;
        filter: blur(2px); /* Adds a nice depth-of-field effect */
    }
    100% {
        transform: translateY(0px) scale(1);
        opacity: 0.2;
    }
}

/* Smooth out the motion for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
    .bg_left_text h1, 
    .bg_right_text h1 {
        animation: none;
    }
}
/* Position "4" to the left */
.bg_left_text {
    left: 1%;
}

/* Position "3" to the right */
.bg_right_text {
    right: 1%;
}

/* Middle content where your monitor sits */
.middle_content {
    position: relative;
    z-index: 10; /* Sits on top of the numbers */
    width: 100%;
    display: flex;
    justify-content: center;
}

/* --- Responsive Design --- */

@media (max-width: 1024px) {
    .bg_left_text h1, 
    .bg_right_text h1 {
        font-size: 15rem; /* Shrink numbers for tablets */
    }
}

@media (max-width: 768px) {
    /* On mobile, numbers often look better hidden or centered behind */
    .bg_left_text, 
    .bg_right_text {
        opacity: 0.15;
    }
    .bg_left_text h1, 
    .bg_right_text h1 {
        font-size: 10rem;
    }
    .bg_left_text { left: 2%; }
    .bg_right_text { right: 2%; }
}

@media (max-width: 480px) {
    .bg_text {
        height: auto;
    }
    /* Hide background numbers on very small screens to avoid clutter */
    .bg_left_text, .bg_right_text {
        display: none;
    }
}
</style>
</head>
<body>
<div class="container">
    <div class="bg_text">
        <div class="bg_left_text">
            <h1>4 </h1>
        </div>

        <div class="middle_content">
<main class="container">
        <div class="decor-cloud cloud-1"></div>
        <div class="decor-cloud cloud-2"></div>
        <div class="decor-leaf leaf-left"></div>
        <div class="decor-leaf leaf-right"></div>

        <div class="illustration-wrapper">
            
            <div class="dotted-path">
                <div class="arrowhead"></div>
            </div>

            <div class="monitor">
                <div class="screen">
                    <div class="screen-header">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="page_name">
                            <p>https://tms.com/<?php echo $page; ?></p>
                        </div>
                    </div>
                    <div class="screen-content">
                        <div class="sidebar">
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                        </div>
                        <div class="top-bar">
                            <div class="top_bar_left_company_info">
                                <img class="company_logo" src="assets/image/system_logo.jpg" alt="System Logo">
                                <span class="company_name">Tender Management System</span>
                            </div>
                        </div>
                        <div class="grid-cards">
                            <div class="card"></div>
                            <div class="card"></div>
                            <div class="card"></div>
                            <div class="card"></div>
                            <div class="card"></div>
                            <div class="card"></div>
                        </div>
                        <div class="warning-triangle">
                            <div class="exclamation">!</div>
                        </div>
                    </div>
                </div>
                <div class="monitor-neck"></div>
                <div class="monitor-base"></div>
            </div>

            <div class="lock-container">
                <div class="lock-shackle"></div>
                <div class="lock-body">
                    <div class="keyhole"></div>
                </div>
            </div>

            <div class="folder">
                <div class="folder-tab-bg"></div>
                <div class="folder-tab"></div>
            </div>
            <div class="key">
                <div class="key-ring"></div>
                <div class="key-shaft"></div>
            </div>

            <div class="character">
                <div class="char-question-mark q1">?</div>
                <div class="char-question-mark q2">!</div>
                <div class="head"></div>
                <div class="arms">
                    <div class="arm-left"></div>
                    <div class="arm-right"></div>
                </div>
                <div class="torso"></div>
                <div class="legs">
                    <div class="leg-left"></div>
                    <div class="leg-right"></div>
                </div>
            </div>
        </div>

        <section class="content">
            <h1 class="main-title">Access Denied</h1>
            <p class="subtitle">You don't have permission to access this resource.<br>Please contact your administrator.</p>
            
            <div class="button-group">
                <button id="backBtn" class="btn-primary">Go Back</button>
                <a href="contact/request_access.php" class="link-secondary">Request Access</a>
            </div>
        </section>
    </main>
            </div>

        <div class="bg_right_text">
            <h1> 3</h1>
        </div>
    </div>
</div>
    

<script>
/**
 * Professional SaaS Access Control Script
 * Vanilla implementation for Error Page Handling
 */

document.addEventListener('DOMContentLoaded', () => {
    const backButton = document.getElementById('backBtn');

    // Handle 'Go Back' logic
    if (backButton) {
        backButton.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Checks if there's a history to go back to
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Fallback: Redirect to dashboard or home
                window.location.href = '/';
            }
        });
    }

    // Optional: Log the unauthorized attempt for analytics
    console.warn('[Security] Access Denied: User attempted to reach a restricted resource.');
});
</script>
</body>
</html>
  