<?php
/**
 * Tender Management System - Professional Landing Page
 * Full-Stack PHP Web Developer & UI/UX Designer implementation
 */

// Simulated session and database values (In a real app, include your db_config.php)
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTender | Advanced Tender Management System</title>
<link rel="shortcut icon" href="/assets/image/system_logo.png" type="image/x-icon">

    <style>
        :root {
            --bg-dark: #0a0c10;
            --bg-card: #161b22;
            --primary: #2f81f7;
            --primary-glow: rgba(47, 129, 247, 0.4);
            --text-main: #f0f6fc;
            --text-muted: #8b949e;
            --accent: #238636;
            --border: #30363d;
            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
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
        h1, h2, h3 { font-weight: 700; letter-spacing: -0.02em; }
        .gradient-text {
            background: linear-gradient(90deg, #fff, #2f81f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Layout Components */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        section { padding: 100px 0; }

        /* Header & Navigation */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 1.5rem 0;
            transition: var(--transition);
        }

        header.scrolled {
            background: rgba(10, 12, 16, 0.8);
            backdrop-filter: blur(12px);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .nav-links a:hover { color: var(--primary); }

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
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 0 15px var(--primary-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px var(--primary-glow);
        }

        .btn-outline {
            border: 1px solid var(--border);
            color: var(--text-main);
        }

        .btn-outline:hover { background: var(--border); }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: -20%;
            right: -10%;
            width: 60%;
            height: 100%;
            background: radial-gradient(circle, rgba(47, 129, 247, 0.15) 0%, transparent 70%);
            z-index: -1;
            filter: blur(80px);
        }

        .hero-content { max-width: 700px; }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: 1s all ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

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
        footer {
            padding: 4rem 0 2rem;
            border-top: 1px solid var(--border);
            margin-top: 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .nav-links, .nav-auth { display: none; }
            .hamburger { display: block; }
            .stats-grid { grid-template-columns: 1fr; gap: 2rem; }
            .steps { flex-direction: column; gap: 3rem; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header id="header">
        <div class="container nav">
            <a href="#" class="logo">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                ProTender
            </a>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#tenders">Tenders</a></li>
                <li><a href="#how">How It Works</a></li>
                <li><a href="#about">About</a></li>
            </ul>
            <div class="nav-auth">
                <?php if ($isLoggedIn): ?>
                    <a href="/dashboard" class="btn btn-primary">Dashboard</a>
                <?php else: ?>
                    <a href="/login" class="nav-links">Login</a>
                    <a href="/register" class="btn btn-primary">Register</a>
                <?php endif; ?>
            </div>
            <button class="hamburger">☰</button>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="reveal gradient-text">Modernizing Public Procurement for the Digital Age.</h1>
                <p class="reveal" style="transition-delay: 0.2s;">Secure, transparent, and efficient tender management for government organizations and private enterprises worldwide.</p>
                <div class="reveal" style="transition-delay: 0.4s; display: flex; gap: 1rem;">
                    <a href="#tenders" class="btn btn-primary">View Open Tenders</a>
                    <a href="/register" class="btn btn-outline">Register as Vendor</a>
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
                    Join thousands of verified vendors already using ProTender to grow their business through government contracts.
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="/register" class="btn btn-primary">Create Account</a>
                    <a href="/contact" class="btn btn-outline">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="#" class="logo" style="margin-bottom: 1.5rem;">ProTender</a>
                    <p style="color: var(--text-muted); max-width: 300px;">The industry standard in digital procurement and tender lifecycle management.</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 1.5rem;">Quick Links</h4>
                    <ul style="list-style: none; line-height: 2;">
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">Help Center</a></li>
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">Privacy Policy</a></li>
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom: 1.5rem;">Contact</h4>
                    <p style="color: var(--text-muted);">support@protender.gov</p>
                    <p style="color: var(--text-muted);">+1 (555) 123-4567</p>
                </div>
            </div>
            <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--border); text-align: center; color: var(--text-muted); font-size: 0.9rem;">
                © 2026 ProTender Management System. Version 4.2.0-stable
            </div>
        </div>
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

        // Mobile Menu Toggle
        const burger = document.querySelector('.hamburger');
        burger.addEventListener('click', () => {
            alert('Mobile navigation menu would toggle here.');
            // Implementation: toggle a 'mobile-active' class on the .nav-links
        });
    </script>
</body>
</html>

