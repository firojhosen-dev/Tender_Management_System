<?php

/**
 * Tender Management System - Professional Landing Page
 * Full-Stack PHP Web Developer & UI/UX Designer implementation
 */
require_once "config/database.php"; 

// 1. Statistics for the "Key Metrics" section
$tender_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tenders"))['total'] ?? 0;
$company_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tender_companies"))['total'] ?? 0;
$win_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tenders WHERE tender_result IN ('1st', '1-st')"))['total'] ?? 0;

// 2. Companies with tender counts
$companies_sql = "SELECT c.company_name, COUNT(t.id) as total_tenders 
                  FROM tender_companies c 
                  LEFT JOIN tenders t ON c.id = t.tender_company_id 
                  GROUP BY c.id 
                  ORDER BY total_tenders DESC";
$companies_result = mysqli_query($conn, $companies_sql);

//Just for the demo, we will fetch the 4 most recent tenders to display in the "Latest Tenders" section
$recent_tenders_sql = "SELECT t.*, c.company_name 
                       FROM tenders t 
                       LEFT JOIN tender_companies c ON t.tender_company_id = c.id 
                       ORDER BY t.id DESC LIMIT 4";
$recent_tenders_result = mysqli_query($conn, $recent_tenders_sql);

// Sample data for latest tenders
$latestTenders = [
    ['title' => 'Smart City Infrastructure - Phase 2', 'deadline' => '2026-02-15', 'status' => 'Open'],
    ['title' => 'Renewable Energy Grid Expansion', 'deadline' => '2026-03-01', 'status' => 'Open'],
    ['title' => 'National Highway Digitalization', 'deadline' => '2026-02-20', 'status' => 'Open'],
];

// DATA FOR THE NEW DEMO SLIDER
$demoSlides = [
    [
        'image' => 'assets/image/SystemDemoImage/main_dashboard.png',
        'title' => 'System Main Dashboard Page',
        'desc' => 'The central hub providing a real-time overview of active tenders, recent company registrations, and key performance metrics through interactive widgets and data visualizations.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/system_information.png',
        'title' => 'System Information Page',
        'desc' => 'Displays technical details regarding the application environment, including server status, software versions, and database connectivity to ensure optimal system health.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/system_settings.png',
        'title' => 'System Settings Page',
        'desc' => 'Allows administrators to configure global parameters, such as currency formats, notification triggers, and system-wide security protocols to tailor the platform to organizational needs.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/readme.png',
        'title' => 'README.md Page',
        'desc' => 'Provides essential project documentation, including installation guides, dependency lists, and architectural overviews to assist developers in maintaining and scaling the application.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/add_tender.png',
        'title' => 'Add Tender Page',
        'desc' => 'A dedicated interface for administrators to input new procurement opportunities, specifying details like deadlines, requirements, and budget constraints for public or private viewing.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/all_tender_list_page.png',
        'title' => 'All Tender List Page:',
        'desc' => 'A comprehensive view of all active tenders, allowing administrators to manage and filter procurement opportunities by status, deadline, or category.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/all_tender_management.png',
        'title' => 'All Tender Management Page',
        'desc' => 'A high-level administrative view for monitoring the lifecycle of all tenders, allowing for status updates, bulk actions, and oversight of procurement timelines.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/tender_edit.png',
        'title' => 'Tender Edit Page',
        'desc' => 'A modification portal where existing tender details can be updated or corrected to ensure information accuracy throughout the bidding process.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/tender_list_page.png',
        'title' => 'Tender List Page',
        'desc' => 'A streamlined view focused on active bidding opportunities, categorized by industry or urgency to help users find relevant projects quickly.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/add_company.png',
        'title' => 'Add Company Page',
        'desc' => 'A registration form for adding new corporate entities to the system, capturing vital data such as business licenses, contact info, and industry focus.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/company_list.png',
        'title' => 'Company List Page',
        'desc' => 'A public or semi-private directory of all registered firms, allowing users to browse potential partners or competitors within the ecosystem.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/company_management.png',
        'title' => 'Company Management Page',
        'desc' => 'An administrative tool for verifying, editing, or suspending company profiles to maintain a high standard of business integrity on the platform.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/user_list.png',
        'title' => 'Users List Page',
        'desc' => 'A centralized database of all registered accounts, enabling administrators to manage roles, permissions, and account details for every system participant.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/user_block_list.png',
        'title' => 'Users Block List Page',
        'desc' => 'A security-focused interface for managing restricted accounts, allowing admins to ban or reinstate users who violate platform policies.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/register.png',
        'title' => 'Register Page',
        'desc' => 'The entry point for new users to create accounts, featuring secure input fields for personal and professional credentials to join the system.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/login.png',
        'title' => 'Login Page',
        'desc' => 'A secure authentication gateway requiring verified credentials to grant users access to their personalized dashboards and sensitive data.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/user_profile.png',
        'title' => 'User Profile Page',
        'desc' => 'A personal space for users to view their activity history, saved tenders, and current status within the management system.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/user_profile_settings.png',
        'title' => 'User Profile Settings Page',
        'desc' => 'Allows individuals to update their personal information, change passwords, and manage notification preferences to customize their user experience.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/documentation_page.png',
        'title' => 'Documentation Page',
        'desc' => 'A library of user manuals and API guides designed to help both end-users and technical staff navigate the system various features.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/global_search.png',
        'title' => 'Global Search Page',
        'desc' => 'A powerful search engine that indexes the entire platform, allowing users to find tenders, companies, or documents using keywords and tags.'
    ],
    [
        'image' => 'assets/image/SystemDemoImage/support_disk.png',
        'title' => 'Support Desk Page',
        'desc' => 'A communication portal where users can submit help tickets, report bugs, or seek assistance from the systems technical support team.'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTender | Advanced Tender Management System</title>
    <link rel="shortcut icon" href="assets/image/system_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    @import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
        :root {
            --bg-dark: #0d1117;
            --bg-card: #161b22;
            --primary: #2f81f7;
            --primary-hover: #58a6ff;
            --primary-glow: rgba(47, 129, 247, 0.4);
            --text-main: #f0f6fc;
            --text-muted: #8b949e;
            --accent: #238636;
            --border: #30363d;
            --font-main: 'Rajdhani', sans-serif;
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
            font-family: 'Rajdhani', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: var(--font-main);
            line-height: 1.6;
            overflow-x: hidden;
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Typography */
        h1, h2, h3, h4 { font-weight: 700; letter-spacing: -0.02em; }
        
        .gradient-text {
            background: linear-gradient(135deg, #ffffff 0%, #2f81f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(47, 129, 247, 0.3);
        }

        /* Layout Components */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        section { padding: 100px 0; }

        /* --- 1. ENHANCED HEADER --- */
.header-container {
    display: flex;
    justify-content: center; 
    padding: 20px;
    position: fixed;
    top: 0px;  
    left: 50%;    
    transform: translateX(-50%);
    z-index: 1000;
    width: auto; 
}

.navbar {
    display: flex;
    align-items: center;
    gap: 30px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);          
    padding: 10px 25px;
    border-radius: 50px;                 
    border: 1px solid rgba(255, 255, 255, 0.1);
    white-space: nowrap;                
}

.logo {
    display: flex;
    align-items: center;
    color: #fff;
    font-weight: bold;
}
.logo img{
    width: 70px;
    height: 70px;
    border: 3px dotted var(--primary);
    border-radius: 50%;
}
.nav-links {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.nav-links li a {
    text-decoration: none;
    color: #a0a0a0;
    font-size: 14px;
    transition: 0.3s;
}

.nav-links li a:hover {
    color: #fff;
}
@media (max-width: 895px) {
    .nav-links{
        display: none;
    }
    .header-container {
        width: 90%; 
        top: 10px;
    }
    .navbar {
        padding: 10px 20px;
    }
}
@media (max-width: 768px) {
    .header-container {
        width: 90%; 
        top: 10px;
    }
    .navbar {
        padding: 10px 20px;
    }
}
        header.scrolled {
            background: rgba(13, 17, 23, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 800;
            text-decoration: none;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }
        
        .logo svg {
            filter: drop-shadow(0 0 5px var(--primary));
        }

        .nav-links {
            display: flex;
            text-align: center;
            gap: 2.5rem;
            list-style: none;
            background: rgba(255,255,255,0.03);
            padding: 1rem;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
            transition: var(--transition);
            position: relative;
            text-align: center;
        }
.nav-link, li, a{
    text-align: center;
}
        .nav-links a:hover { color: #fff; }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0%;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        .nav-links a:hover::after { width: 100%; }

        .nav-auth {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Buttons */
        .btn {
            padding: 0.8rem 1.8rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-block;
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 0 20px rgba(47, 129, 247, 0.3);
            border: 1px solid transparent;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 0 35px rgba(47, 129, 247, 0.6);
        }

        .btn-outline {
            border: 1px solid var(--border);
            color: var(--text-main);
            background: transparent;
        }

        .btn-outline:hover { 
            border-color: var(--text-main);
            background: rgba(255,255,255,0.05);
        }

        /* --- 2. BEAUTIFUL HERO SECTION --- */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px; /* Offset fixed header */
        }

        .hero-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            background: 
                radial-gradient(circle at 15% 50%, rgba(47, 129, 247, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 85% 30%, rgba(35, 134, 54, 0.1) 0%, transparent 50%);
            z-index: -1;
            filter: blur(60px);
        }

        /* Grid pattern overlay */
        .hero::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 100%);
        }

        .hero-content { 
            max-width: 800px; 
            margin: 0 auto;
            text-align: center;
        }

        .hero h1 {
            font-size: clamp(3rem, 6vw, 5rem);
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero p {
            font-size: 1.35rem;
            color: var(--text-muted);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: 1s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- 3. NEW SYSTEM DEMO SLIDER SECTION --- */
        .demo-section {
            padding: 80px 0;
            position: relative;
            background: linear-gradient(to bottom, var(--bg-dark), var(--bg-card));
            overflow: hidden;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            max-width: 1000px; /* Aspect ratio control */
            height: 600px; /* Fixed height for consistency */
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border);
            background: #000;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.8s ease-in-out, visibility 0.8s;
        }

        .slide.active {
            opacity: 1;
            visibility: visible;
            z-index: 10;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Subtle zoom effect on image when active */
            transform: scale(1.05);
            transition: transform 6s ease;
        }

        .slide.active img {
            transform: scale(1); /* Zooms out slowly */
        }

        .slide-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.7) 50%, transparent 100%);
            padding: 4rem 3rem 6rem; /* Extra bottom padding for controls */
            z-index: 20;
        }

        .slide-content h3 {
            font-size: 2rem;
            color: #fff;
            margin-bottom: 0.5rem;
            transform: translateY(20px);
            opacity: 0;
        }

        .slide-content p {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.8);
            max-width: 700px;
            transform: translateY(20px);
            opacity: 0;
        }

        /* Animation for text when slide becomes active */
        .slide.active .slide-content h3 {
            animation: slideUpFade 0.8s ease forwards 0.3s;
        }

        .slide.active .slide-content p {
            animation: slideUpFade 0.8s ease forwards 0.5s;
        }

        @keyframes slideUpFade {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Slider Controls */
        .slider-controls {
            position: absolute;
            bottom: 25px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 3rem;
            z-index: 30;
        }

        .dots-wrapper {
            display: flex;
            gap: 10px;
        }

        .dot {
            width: 10px;
            height: 10px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
        }

        .dot.active {
            background: var(--primary);
            width: 30px; /* Stretch effect */
            border-radius: 10px;
        }

        .nav-arrows {
            display: flex;
            gap: 1rem;
        }

        .arrow-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(5px);
            transition: all 0.3s;
        }

        .arrow-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* --- END NEW CSS --- */


        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 2.5rem;
            border-radius: 16px;
            transition: var(--transition);
        }

        .card:hover {
            border-color: var(--primary);
            transform: translateY(-10px);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: rgba(47, 129, 247, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        /* How It Works */
        .steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 4rem;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
            padding: 0 1rem;
            z-index: 1;
        }

        .step-num {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-weight: bold;
        }

        /* Stats Section */
        .stat_container_main{
            padding: 20px;
            background: var(--bg);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }
        .stat-card {
            background: var(--bg);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-bottom: 5px solid var(--primary);
        }
        .stat-card h2 { font-size: 100px;  color: var(--primary); }
        .stat-card p { font-weight: bold; color: var(--secondary); text-transform: uppercase; }

        /* All Companies Section */
        .section-title { text-align: center; margin-bottom: 30px; color: var(--secondary); }
        
        .company-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .company-pill {
            /* background: var(--primary); */
            border-top: 5px solid  #0D0B63;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-align: center;
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        .company-pill:hover { transform: scale(1.1); background: var(--primary-hover); }
        .company-pill .name { font-size: 0.9rem; font-weight: 500; }
        .company-pill .count { font-size: 0.7rem; opacity: 0.8; }

        /* Responsive Mobile Settings */
        @media (max-width: 600px) {
            .stats-grid{
            grid-template-columns: repeat(auto-fit, minmax(150px, 2fr));
            }
            .stat-card h2 { font-size: 7rem; }
            .company-pill { padding: 8px 15px; }
        }
        /* Tender Table */
        .tender-table-wrapper {
            overflow-x: auto;
            margin-top: 3rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-card);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 1.2rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th { background: rgba(255, 255, 255, 0.05); color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            background: rgba(35, 134, 54, 0.2);
            color: #3fb950;
        }

        /* CTA Section */
        .cta-box {
            background: linear-gradient(135deg, #1e232b 0%, #0a0c10 100%);
            padding: 5rem;
            border-radius: 24px;
            text-align: center;
            border: 1px solid var(--border);
        }

        /* --- Footer Styles --- */
        .footer {
            background-color: var(--bg-card);
            border-top: 1px solid var(--border);
            padding: 4rem 2rem 0;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Glow Effect Background */
        .footer::before {
            content: '';
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 50%;
            background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
            opacity: 0.15;
            pointer-events: none;
            z-index: 0;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Main Grid Layout */
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        /* Brand Section */
        .footer-brand h2 {
            color: var(--text-main);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-brand h2 span {
            color: var(--primary);
        }

        .footer-brand p {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        /* Social Icons */
        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-dark);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px var(--primary-glow);
        }

        /* Footer Links Sections */
        .footer-section h3 {
            color: var(--text-main);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links, .footer_li{
            margin-bottom: 0.8rem;
        }

        .footer-links, .footer_li, .footer_a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            transition: var(--transition);
            display: inline-block;
        }

        .footer-links, .footer_a:hover {
            color: var(--primary-hover);
            transform: translateX(5px);
        }

        /* Newsletter Section */
        .newsletter-form {
            position: relative;
            margin-top: 1rem;
        }

        .input-group {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .newsletter-input {
            width: 100%;
            padding: 12px 16px;
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-main);
            font-family: var(--font-main);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .newsletter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        .newsletter-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-main);
        }

        .newsletter-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        /* Footer Bottom */
        .footer-bottom {
            border-top: 1px solid var(--border);
            padding: 2rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .copyright {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .legal-links {
            display: flex;
            gap: 1.5rem;
        }

        .legal-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .legal-links a:hover {
            color: var(--primary-hover);
        }

        /* Scroll To Top Button */
        #scrollTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 45px;
            height: 45px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: var(--transition);
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        #scrollTopBtn.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        #scrollTopBtn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .cta-box{
                padding: 10px;
            }
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
            
            .footer-brand, .newsletter-wrapper {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-brand, .newsletter-wrapper {
                grid-column: span 1;
            }

            .social-links {
                justify-content: center;
            }

            .footer-links a:hover {
                transform: translateX(0) scale(1.05); /* Different animation for mobile */
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
        /* Footer End */
        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
        }

        
/* --- Custom Scrollbar Styling --- */

/* 1. The entire scrollbar width */
::-webkit-scrollbar {
    width: 10px;               /* Width for vertical scrollbar */
    height: 10px;              /* Height for horizontal scrollbar */
}

/* 2. The Track (the background of the scrollbar) */
::-webkit-scrollbar-track {
    background: var(--bg-body); /* Matches your page background */
    border-radius: 10px;
}

/* 3. The Thumb (the draggable part) */
::-webkit-scrollbar-thumb {
    background: #cbd5e1;       /* Light grey thumb */
    border-radius: 10px;
    border: 2px solid var(--bg-body); /* Creates a padding effect around the thumb */
    transition: background 0.3s ease;
}

/* 4. Thumb hover effect */
::-webkit-scrollbar-thumb:hover {
    background: var(--primary); /* Changes to your primary blue on hover */
}

/* 5. Dark Mode specific scrollbar */
[data-theme="dark"] ::-webkit-scrollbar-thumb {
    background: #475569;       /* Darker grey for dark mode */
    border: 2px solid var(--bg-body);
}

[data-theme="dark"] ::-webkit-scrollbar-thumb:hover {
    background: var(--primary); /* Keep blue highlight in dark mode */
}

/* --- Firefox Support (Limited styling) --- */
* {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

.activity-feed::-webkit-scrollbar {
    width: 6px; /* Thinner scrollbar for small panels */
}

.activity-feed::-webkit-scrollbar-thumb {
    background: var(--border);
}
        @media (max-width: 768px) {
            .nav-links, .nav-auth { display: none; }
            .hamburger { display: block; }
            .stats-grid { grid-template-columns: 2fr; gap: 2rem; }
            .steps { flex-direction: column; gap: 3rem; }
            .slider-controls { padding: 0 1.5rem; }
            .carousel-container { height: 450px; }
            .slide-content h3 { font-size: 1.5rem; }
        }
/* about section style start */

        /* --- CSS VARIABLES (Strictly as requested) --- */
        :root {
            --bg-dark: #0d1117;
            --bg-card: #161b22;
            --primary: #2f81f7;
            --primary-hover: #58a6ff;
            --primary-glow: rgba(47, 129, 247, 0.4);
            --text-main: #f0f6fc;
            --text-muted: #8b949e;
            --accent: #238636;
            --border: #30363d;
            --font-stack: 'Rajdhani', sans-serif;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        ul {
            list-style: none;
        }

        /* --- LAYOUT UTILITIES --- */
        .about_container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .about_section_main {
            padding: 4rem 0;
            border-bottom: 1px solid var(--border);
        }

        .about_section_main:last-child {
            border-bottom: none;
        }

        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }

        /* --- ANIMATIONS --- */
        .about_reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }

        .about_reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- HERO SECTION --- */
        .about_hero {
            text-align: center;
            padding: 6rem 20px;
            background: radial-gradient(circle at top center, #1f293a 0%, var(--bg-dark) 70%);
        }

        .about_hero h1 {
            font-size: 3rem;
            background: linear-gradient(120deg, var(--text-main), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .about_hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        /* --- CARDS DESIGN --- */
        .about_card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .about_card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 10px 30px -10px var(--primary-glow);
        }

        .card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .about_card h3 {
            color: var(--primary-hover);
        }

        /* --- MISSION & OBJECTIVES --- */
        .mission-box {
            border-left: 4px solid var(--accent);
        }

        .obj-list li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.8rem;
            color: var(--text-muted);
        }

        .obj-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--accent);
            font-weight: bold;
        }

        /* --- TECH STACK BADGES --- */
        .tech-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .badge {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--primary-hover);
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .badge:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 0 15px var(--primary-glow);
        }

        /* --- FOOTER CTA --- */
        .about_cta_section {
            text-align: center;
            background: linear-gradient(180deg, var(--bg-dark) 0%, #101620 100%);
        }
        /* --- RESPONSIVE ADJUSTMENTS --- */
        @media (max-width: 992px) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .about_hero h1 { font-size: 2.2rem; }
        }
/* about section style end */
    </style>
</head>
<body>

    <header class="header-container">
    <nav class="navbar">
        <div class="logo">
            <img src="assets/image/logo.png" alt="TMS">
            <spa style="font-size: 50px; color:#4361ee;">T<span style="color: #238636;">M</span><span style="color: #f1c40f;">S</span></spa>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#demo">System Demo</a></li>
            <li><a href="#recent_tenders">Tenders</a></li>
            <li><a href="#company_list">Company List</a></li>
            <li><a href="#how">How It Works</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#start_now">Start Now</a></li>
            <li><a href="auth/login.php">Login</a></li>
        </ul>
            <button class="hamburger">☰</button>
    </nav>
</header>
    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="reveal gradient-text" style="margin-top: 50px;">Modernizing Public Procurement for the Digital Age.</h1>
                <p class="reveal" style="transition-delay: 0.2s;">Secure, transparent, and efficient tender management for government organizations and private enterprises worldwide.</p>
                <div class="reveal" style="transition-delay: 0.4s; display: flex; gap: 1rem; justify-content: center;">
                    <a href="system/documentation.php" class="btn btn-primary">View Documentation</a>
                    <a href="auth/login.php" class="btn btn-outline">Login</a>
                </div>
            </div>
        </div>
    </section>

    <section id="demo" class="demo-section">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="gradient-text">System Interface Tour</h2>
                <p style="color: var(--text-muted)">Experience the power and simplicity of the ProTender platform.</p>
            </div>

            <div class="carousel-container reveal">
                <?php foreach($demoSlides as $index => $slide): ?>
                <div class="slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                    <img src="<?= $slide['image'] ?>" alt="<?= $slide['title'] ?>">
                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h3><?= $slide['title'] ?></h3>
                            <p><?= $slide['desc'] ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="slider-controls">
                    <div class="dots-wrapper">
                        <?php foreach($demoSlides as $index => $slide): ?>
                        <div class="dot <?= $index === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $index ?>)"></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="nav-arrows">
                        <div class="arrow-btn" onclick="prevSlide()">&#10094;</div>
                        <div class="arrow-btn" onclick="nextSlide()">&#10095;</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Stat Section -->
<div class="stat_container_main">
    <div class="stats-grid">
        <div class="stat-card">
            <p>Total Tenders</p>
            <h2 class="count-up" data-target="<?php echo $tender_count; ?>">0</h2>
        </div>
        <div class="stat-card" style="border-bottom-color: var(--secondary);">
            <p>Total Companies</p>
            <h2 class="count-up" data-target="<?php echo $company_count; ?>">0</h2>
        </div>
        <div class="stat-card" style="border-bottom-color: var(--accent);">
            <p>Total Wins (1st)</p>
            <h2 class="count-up" data-target="<?php echo $win_count; ?>">0</h2>
        </div>
    </div>
<section id="company_list">
<!-- Company Section -->
    <h1 class="section-title">All Companies</h1>
    <div class="company-container">
        <?php while($row = mysqli_fetch_assoc($companies_result)): 
            $extra_size = min($row['total_tenders'] * 2, 50); 
            $font_scale = 1 + ($row['total_tenders'] * 0.02);
        ?>
            <div class="company-pill">
                <span class="name"><?php echo htmlspecialchars($row['company_name']); ?></span>
                <span class="count">Tenders: <?php echo $row['total_tenders']; ?></span>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</section>
    <section id="about">
    <section class="about_hero">
        <div class="about_container about_reveal">
            <h1>Tender Management System <span style="color: #2f81f7;">About</span></h1>
            <p>
                A comprehensive, secure, and scalable web-based application designed to streamline the entire tender lifecycle. We digitize and automate creation, evaluation, and approval processes to ensure transparency and efficiency.
            </p>
        </div>
    </section>

    <section class="about_section_main">
        <div class="about_container grid grid-2">
            <div class="about_card mission-box about_reveal">
                <span class="card-icon">🎯</span>
                <h3>Our Mission</h3>
                <p>To provide organizations with a reliable and intelligent platform that simplifies tender operations, improves decision-making, and ensures fair competition among vendors. TMS aims to enhance operational efficiency while maintaining transparency and accountability in procurement processes.</p>
            </div>
            <div class="about_card about_reveal">
                <span class="card-icon">🚀</span>
                <h3>Key Objectives</h3>
                <ul class="obj-list">
                    <li>Digitize the end-to-end tender management workflow</li>
                    <li>Ensure role-based access and data security</li>
                    <li>Improve collaboration between admins, auditors, and vendors</li>
                    <li>Maintain accurate records and audit trails</li>
                    <li>Reduce processing time and operational cost</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="about_section_main">
        <div class="about_container">
            <h2 style="text-align: center; margin-bottom: 3rem;" class="about_reveal">🔑 Core Features Overview</h2>
            <div class="grid grid-3">
                <div class="about_card about_reveal">
                    <h3>Secure Access</h3>
                    <p>Robust user authentication and granular role-based access control to ensure the right people have the right data.</p>
                </div>
                <div class="about_card about_reveal">
                    <h3>Workflow Automation</h3>
                    <p>Complete company and tender management with built-in approval workflows to eliminate manual bottlenecks.</p>
                </div>
                <div class="about_card about_reveal">
                    <h3>Vendor Hub</h3>
                    <p>Streamlined vendor registration, verification, and performance tracking in a single centralized portal.</p>
                </div>
                <div class="about_card revabout_revealeal">
                    <h3>Evaluation System</h3>
                    <p>Structured review, evaluation, and approval systems to ensure fair and competitive bidding processes.</p>
                </div>
                <div class="about_card about_reveal">
                    <h3>Support & Tickets</h3>
                    <p>Integrated support ticket system and process management to handle inquiries and issues efficiently.</p>
                </div>
                <div class="about_card about_reveal">
                    <h3>Analytics</h3>
                    <p>Real-time dashboards and reporting tools offering deep insights into procurement performance.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about_section_main" style="background-color: #0f131a;">
        <div class="about_container grid grid-2">
            <div class="about_reveal">
                <h2>🧠 System Design Philosophy</h2>
                <p>TMS is designed with a user-centric approach, focusing on clarity, simplicity, and performance. The system follows modular architecture principles, allowing each module—tenders, vendors, users, reports—to function independently while remaining seamlessly connected.</p>
                <p>The interface is modern, responsive, and optimized for daily office use, ensuring smooth navigation even for non-technical users.</p>
            </div>
            <div class="about_card about_reveal" style="border-color: var(--primary-glow);">
                <h2>🔐 Security & Compliance</h2>
                <p>Security is our core priority. We ensure sensitive procurement data remains protected via:</p>
                <ul class="obj-list">
                    <li>Role-based access control</li>
                    <li>Secure session management</li>
                    <li>Activity logging & audit readiness</li>
                    <li>Controlled data modification permissions</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="about_section_main">
        <div class="about_container grid grid-2">
            <div class="about_card about_reveal">
                <span class="card-icon">📊</span>
                <h3>Transparency & Accountability</h3>
                <p>TMS promotes transparency by maintaining a complete digital record of every tender action—from creation to final approval. All activities are traceable, ensuring accountability and simplifying internal audits.</p>
            </div>
            <div class="about_card about_reveal">
                <span class="card-icon">🌱</span>
                <h3>Scalability & Growth</h3>
                <p>Built to scale with your organization. New modules, integrations, document management features, and analytics dashboards can be added without disrupting existing workflows.</p>
            </div>
        </div>
    </section>

    <section class="about_section_main">
        <div class="about_container" style="text-align: center;">
            <h2 class="about_reveal">🛠 Technology Stack</h2>
            <p class="about_reveal">Built on a robust, modern foundation for performance and reliability.</p>
            <div class="tech-wrapper about_reveal">
                <span class="badge">HTML5</span>
                <span class="badge">CSS3</span>
                <span class="badge">JavaScript</span>
                <span class="badge">PHP</span>
                <span class="badge">MySQL</span>
                <span class="badge">Apache</span>
                <span class="badge">Modular Architecture</span>
            </div>
        </div>
    </section>

    <section class="about_cta_section">
        <div class="about_container about_reveal">
            <h2>💼 Who Can Use This System?</h2>
            <p style="margin-bottom: 2rem;">Government & Private Organizations • Procurement Committees • Enterprises • Educational Projects</p>
            
            <div style="background: var(--bg-card); padding: 2rem; border-radius: 12px; border: 1px solid var(--border); display: inline-block; text-align: left; max-width: 700px;">
                <h3 style="color: var(--text-main);">🌐 Conclusion</h3>
                <p style="margin-bottom: 0;">The Tender Management System is more than just a software solution—it is a complete digital framework for managing tenders with confidence, transparency, and efficiency. Modernize your procurement operations today.</p>
            </div>
        </div>
    </section>

    </section>
<!-- Recent Tender Section -->
<section id="recent_tenders">
<div class="recent-tenders-section" style="margin-top: 60px;">
    <h1 class="section-title">Recently Added Tenders</h1>
    
    <div class="table-responsive" style="overflow-x: auto; background: #0000007a; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse; min-width: 1100px;">
            <thead>
                <tr style="background-color: var(--primary); color: #fff; text-align: left;">
                    <th style="padding: 12px; color: #fff;">S/L</th>
                    <th style="padding: 12px; color: #fff;">Company Name</th>
                    <th style="padding: 12px; color: #fff;">Tender Name</th>
                    <th style="padding: 12px; color: #fff;">Ref No</th>
                    <th style="padding: 12px; color: #fff;">Published Date</th>
                    <th style="padding: 12px; color: #fff;">Status</th>
                    <th style="padding: 12px; color: #fff;">Quoted Price</th>
                    <th style="padding: 12px; color: #fff;">Result</th>
                    <th style="padding: 12px; color: #fff;">Brand</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sl = 1;
                while($row = mysqli_fetch_assoc($recent_tenders_result)): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px;"><?php echo $sl++; ?></td>
                    <td style="padding: 10px; color: var(--secondary); font-weight: bold;">
                        <?php echo htmlspecialchars($row['company_name'] ?? 'N/A'); ?>
                    </td>
                    <td style="padding: 10px; font-weight: 500;"><?php echo htmlspecialchars($row['tender_name']); ?></td>
                    <td style="padding: 10px; font-size: 0.9rem;"><?php echo htmlspecialchars($row['tender_ref_no']); ?></td>
                    <td style="padding: 10px;"><?php echo $row['submitted_date']; ?></td>
                    <td style="padding: 10px;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; background: <?php echo ($row['tender_status'] == 'Submitted') ? '#e8f5e9; color: #2e7d32;' : '#ffebee; color: #c62828;'; ?>">
                            <?php echo $row['tender_status']; ?>
                        </span>
                    </td>
                    <td style="padding: 10px; font-weight: bold;">
                        <?php echo number_format($row['quoted_price'], 2) . " " . ($row['currency'] ?: 'BDT'); ?>
                    </td>
                    <td style="padding: 10px;">
                        <?php if($row['tender_result'] == '1st' || $row['tender_result'] == '1-st'): ?>
                            <span style="background: var(--accent); color: #000; padding: 2px 8px; border-radius: 5px; font-weight: bold;">1st</span>
                        <?php else: ?>
                            <?php echo $row['tender_result']; ?>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 10px;"><?php echo htmlspecialchars($row['brand']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 30px; margin-bottom: 50px;">
        <a href="auth/login.php" style="display: inline-block; padding: 12px 30px; background: var(--primary); color: white; border-radius: 50px; text-decoration: none; font-weight: bold;">View More Tenders</a>
    </div>
</div>
</section>
    <section id="how">
        <div class="container">
            <h2 class="reveal" style="text-align: center; margin-bottom: 4rem;">Simple Procurement Flow</h2>
            <div class="steps">
                <div class="step reveal">
                    <div class="step-num">1</div>
                    <h4>Register</h4>
                    <p>Create your vendor profile and verify credentials.</p>
                </div>
                <div class="step reveal" style="transition-delay: 0.2s;">
                    <div class="step-num">2</div>
                    <h4>Search</h4>
                    <p>Find relevant tenders based on your industry.</p>
                </div>
                <div class="step reveal" style="transition-delay: 0.4s;">
                    <div class="step-num">3</div>
                    <h4>Submit</h4>
                    <p>Upload your proposal through our secure portal.</p>
                </div>
                <div class="step reveal" style="transition-delay: 0.6s;">
                    <div class="step-num">4</div>
                    <h4>Award</h4>
                    <p>Receive notifications on evaluation results.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="start_now">
        <div class="container">
            <div class="cta-box reveal">
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Ready to start bidding?</h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                    Join thousands of verified vendors already using ProTender to grow their business through government contracts.<br>
                    Login to access the system dashboard, contact the admin for any system error, request access for any emergency or to access an important page.
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="contact/admin_contact.php" class="btn btn-outline">Contact Admin</a>
                    <a href="auth/login.php" class="btn btn-primary">Login</a>
                    
                </div>
                <div class="button_request" style="display: flex; margin-top:10px; gap: 1rem; justify-content: center;">
                        <a href="users/request_user_add.php" class="btn btn-primary">Request Register</a>
                    <a href="contact/request_access.php" class="btn btn-outline">Request Access</a>
                    </div>
            </div>
        </div>
    </section>
<!-- Footer Section -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h2> <img src="assets/image/logo.png" alt="Logo" style="width: 50px; height:50px; border: 2px dotted #1602ef; border-radius: 50%;"><spa style="font-size: 50px; color:#4361ee;">T<span style="color: #238636;">M</span><span style="color: #f1c40f;">S</span></spa></h2>
                    <p>Secure, transparent, and efficient tender management for government organizations and private enterprises worldwide.</p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                        <a href="#" class="social-link" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="social-link" aria-label="Discord"><i class="fa-brands fa-discord"></i></a>
                        
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Quick Access</h3>
                    <ul class="footer-links">
                        <li class="footer_li"><a href="#home" class="footer_a">Home</a></li> <br>
                        <li class="footer_li"><a href="#demo" class="footer_a">System Demo</a></li><br>
                        <li class="footer_li"><a href="#recent_tenders" class="footer_a">Tenders</a></li><br>
                        <li class="footer_li"><a href="#company_list" class="footer_a">Company List</a></li><br>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Quick Access</h3>
                    <ul class="footer-links">
                        <li class="footer_li"><a href="system/documentation.php" class="footer_a">Documentation</a></li><br>
                        <li class="footer_li"><a href="#how" class="footer_a">How It Works</a></li><br>
                        <li class="footer_li"><a href="#about" class="footer_a">About</a></li><br>
                        <li class="footer_li"><a href="#start_now" class="footer_a">Start Now</a></li><br>
                        <li class="footer_li"><a href="auth/login.php" class="footer_a">Login</a></li><br>
                    </ul>
                </div>

                <div class="footer-section newsletter-wrapper">
                    <h3>Stay Connected</h3>
                    <p style="color: var(--text-muted); margin-bottom: 1rem; font-size: 0.9rem;">Subscribe to our newsletter for the latest updates and tech news.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <div class="input-group">
                            <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                            <button type="submit" class="newsletter-btn">
                                Subscribe <i class="fa-solid fa-paper-plane" style="margin-left: 5px;"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="copyright">
                    &copy; 2025-<span id="year"></span> TMS  All rights reserved.
                </div>
                <div class="legal-links">
                    <!-- <a href="system/cookie_settings.php">Cookie Settings</a> -->
                    <a href="https://www.linkedin.com/in/firojhossendev">Developed By Firoj Hosen</a>
                    <a href="https://github.com/firojhosen-dev">Follow | GitHub</a>
                    <a href="https://www.linkedin.com/in/firojhossendev">Follow | Linkedin</a>
                    <a href="system/privacy_policy.php">Privacy Policy</a>
                    <a href="system/readme.php">README.md</a>
                    <a href="#"></a>
                </div>
            </div>
        </div>

        <button id="scrollTopBtn" aria-label="Scroll to top">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
    </footer>

    <script>
        // Header Scroll Effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Reveal on Scroll Intersection Observer
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Count Animations
document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.count-up');
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const speed = 100; // Animation speed
                    const increment = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        });
        // --- NEW SLIDER LOGIC ---
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = slides.length;
        let slideInterval;

        function showSlide(index) {
            // Normalize index
            if (index >= totalSlides) currentSlide = 0;
            else if (index < 0) currentSlide = totalSlides - 1;
            else currentSlide = index;

            // Update DOM
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
            resetTimer();
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
            resetTimer();
        }

        function goToSlide(index) {
            showSlide(index);
            resetTimer();
        }

        function resetTimer() {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => showSlide(currentSlide + 1), 5000);
        }

        // Initialize Slider
        if(totalSlides > 0) {
            slideInterval = setInterval(() => showSlide(currentSlide + 1), 5000);
        }

        // Mobile Menu Toggle
        const burger = document.querySelector('.hamburger');
        burger.addEventListener('click', () => {
            alert('Mobile navigation menu would toggle here.');
        });
                // 1. Dynamic Year Update
        document.getElementById('year').textContent = new Date().getFullYear();

        // 2. Scroll to Top Logic
        const scrollTopBtn = document.getElementById('scrollTopBtn');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // 3. Optional: Add a subtle tilt effect to cards on mousemove (Polishing touch)
        const newsletterBtn = document.querySelector('.newsletter-btn');
        newsletterBtn.addEventListener('mousemove', (e) => {
            const rect = newsletterBtn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            newsletterBtn.style.setProperty('--x', x + 'px');
            newsletterBtn.style.setProperty('--y', y + 'px');
        });

        // About Section Start
 document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.about_reveal');

            const revealOnScroll = () => {
                const windowHeight = window.innerHeight;
                const elementVisible = 100;

                reveals.forEach((about_reveal) => {
                    const elementTop = about_reveal.getBoundingClientRect().top;
                    if (elementTop < windowHeight - elementVisible) {
                        about_reveal.classList.add('active');
                    }
                });
            };

            window.addEventListener('scroll', revealOnScroll);
            // Trigger once on load
            revealOnScroll();
        });

        // About Section End
    </script>
</body>
</html>
