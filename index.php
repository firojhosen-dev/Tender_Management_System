<?php
/**
 * Tender Management System - Professional Landing Page
 * Full-Stack PHP Web Developer & UI/UX Designer implementation
 */

// Simulated session and database values
session_start();
$isLoggedIn = isset($_SESSION['user_id']) ? true : false;
$stats = [
    'tenders' => 1250,
    'vendors' => 8400,
    'projects' => 920
];

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
    <link rel="shortcut icon" href="/assets/image/system_logo.png" type="image/x-icon">
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
        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 1.2rem 0;
            transition: var(--transition);
            background: rgba(13, 17, 23, 0); 
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
            padding: 0.5rem 2rem;
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

        /* Statistics */
        .stats-bar {
            background: var(--bg-card);
            padding: 4rem 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            color: var(--primary);
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

        /* Footer */
        /* footer {
            padding: 4rem 0 2rem;
            border-top: 1px solid var(--border);
            margin-top: 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
        } */

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
            .stats-grid { grid-template-columns: 1fr; gap: 2rem; }
            .steps { flex-direction: column; gap: 3rem; }
            .slider-controls { padding: 0 1.5rem; }
            .carousel-container { height: 450px; }
            .slide-content h3 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <header id="header">
        <div class="container nav">
            <!-- <a href="#" class="logo">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                ProTender
            </a> -->
            <ul class="nav-links" style="text-align: center;">
                <li><a href="#home">Home</a></li>
                <li><a href="#demo">System Demo</a></li>
                <li><a href="#tenders">Tenders</a></li>
                <li><a href="#how">How It Works</a></li>
                <li><a href="#about">About</a></li>
            </ul>
            <!-- <div class="nav-auth">
                <?php if ($isLoggedIn): ?>
                    <a href="/dashboard" class="btn btn-primary">Dashboard</a>
                <?php else: ?>
                    <a href="/login" class="nav-links" style="background:none; border:none; padding:0;">Login</a>
                    <a href="/register" class="btn btn-primary">Get Started</a>
                <?php endif; ?>
            </div> -->
            <button class="hamburger">☰</button>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="reveal gradient-text">Modernizing Public Procurement for the Digital Age.</h1>
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
    <div class="stats-bar">
        <div class="container stats-grid">
            <div class="stat-item">
                <h3 class="counter" data-target="<?= $stats['tenders'] ?>">0</h3>
                <p>Live Tenders</p>
            </div>
            <div class="stat-item">
                <h3 class="counter" data-target="<?= $stats['vendors'] ?>">0</h3>
                <p>Trusted Vendors</p>
            </div>
            <div class="stat-item">
                <h3 class="counter" data-target="<?= $stats['projects'] ?>">0</h3>
                <p>Awarded Projects</p>
            </div>
        </div>
    </div>

    <section id="about">
        <div class="container">
            <div style="text-align: center; max-width: 600px; margin: 0 auto 4rem;">
                <h2 class="reveal">Built for Transparency & Security</h2>
                <p class="reveal" style="color: var(--text-muted)">Our platform ensures every step of the procurement process is logged, verifiable, and secure.</p>
            </div>
            
            <div class="features-grid">
                <div class="card reveal">
                    <div class="card-icon">🔒</div>
                    <h3>Secure Publishing</h3>
                    <p>Encrypted document handling and secure submission vaults for all bids.</p>
                </div>
                <div class="card reveal" style="transition-delay: 0.1s;">
                    <div class="card-icon">⚡</div>
                    <h3>Real-time Alerts</h3>
                    <p>Instant notifications for tender amendments, queries, and award results.</p>
                </div>
                <div class="card reveal" style="transition-delay: 0.2s;">
                    <div class="card-icon">📊</div>
                    <h3>Smart Evaluation</h3>
                    <p>Automated scoring and compliance checks to speed up the selection process.</p>
                </div>
            </div>
            <button class="btn btn-primary" style="margin-top: 10px; align-items: center;"><a href="system/about.php" style="text-decoration: none;">Learn More</a></button>
        </div>
    </section>

    <section id="tenders">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
                <h2 class="reveal">Active Opportunities</h2>
                <a href="/tenders" style="color: var(--primary); text-decoration: none;">Browse all →</a>
            </div>
            <div class="tender-table-wrapper reveal">
                <table>
                    <thead>
                        <tr>
                            <th>Tender Description</th>
                            <th>Closing Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($latestTenders as $t): ?>
                        <tr>
                            <td><strong><?= $t['title'] ?></strong></td>
                            <td><?= date('M d, Y', strtotime($t['deadline'])) ?></td>
                            <td><span class="status-badge"><?= $t['status'] ?></span></td>
                            <td><a href="#" class="btn-outline btn" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Details</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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

    <section>
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
                    <h2>T<span>MS</span></h2>
                    <p>Secure, transparent, and efficient tender management for government organizations and private enterprises worldwide.</p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                        <a href="#" class="social-link" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="social-link" aria-label="Discord"><i class="fa-brands fa-discord"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li class="footer_li"><a href="system/about.php" class="footer_a">About Us</a></li><br>
                        <li class="footer_li"><a href="#" class="footer_a">Careers</a></li><br>
                        <li class="footer_li"><a href="#" class="footer_a">Our Team</a></li><br>
                        <li class="footer_li"><a href="#" class="footer_a">Roadmap</a></li><br>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li class="footer_li"><a href="system/documentation.php" class="footer_a">Documentation</a></li><br>
                        <li class="footer_li"><a href="#" class="footer_a">API Reference</a></li><br>
                        <li class="footer_li"><a href="#" class="footer_a">Community Forum</a></li><br>
                        <li class="footer_li"><a href="#" class="footer_a">Blog Posts</a></li><br>
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
                    &copy; <span id="year"></span> TMS  All rights reserved.
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

        // Animated Counters
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const startCounters = (entries, obs) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    const countIt = (counter) => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText;
                        const inc = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(() => countIt(counter), 1);
                        } else {
                            counter.innerText = target.toLocaleString();
                        }
                    }
                    countIt(entry.target);
                    obs.unobserve(entry.target);
                }
            });
        }

        const statsObserver = new IntersectionObserver(startCounters, {threshold: 1.0});
        counters.forEach(c => statsObserver.observe(c));

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
    </script>
</body>
</html>
