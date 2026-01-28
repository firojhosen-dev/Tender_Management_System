<?php 
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor', 'Reviewer', 'Vendor']); // All users can access
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS | System Documentation</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --primary: #4361ee;
            --border: #e2e8f0;
            --code-bg: #f1f5f9;
        }

        [data-theme="dark"] {
            --bg-body: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
            --code-bg: #2d3748;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
        body {
                    font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* --- Custom Scrollbar --- */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        /* --- Sidebar Navigation --- */
        .sidebar {
            width: 280px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar h2 { font-size: 1.2rem; margin-bottom: 2rem; color: var(--primary); }
        .nav-group { margin-bottom: 1.5rem; }
        .nav-group-title { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; display: block; }
        .nav-link { 
            display: block; 
            padding: 8px 12px; 
            color: var(--text-main); 
            text-decoration: none; 
            font-size: 0.9rem; 
            border-radius: 6px;
            margin-bottom: 4px;
            transition: 0.2s;
        }
        .nav-link:hover { background: var(--code-bg); color: var(--primary); }
        .nav-link.active { background: var(--primary); color: white; }

        /* --- Main Content Area --- */
        .doc-content {
            flex: 1;
            padding: 3rem 5%;
            overflow-y: auto;
            scroll-behavior: smooth;
        }

        section { margin-bottom: 4rem; max-width: 900px; }
        h1 { font-size: 2.5rem; margin-bottom: 1rem; }
        h3 { margin: 2rem 0 1rem; color: var(--primary); }
        p { line-height: 1.7; color: var(--text-muted); margin-bottom: 1rem; }

        .code-block {
            background: var(--code-bg);
            padding: 1.5rem;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            margin: 1rem 0;
            overflow-x: auto;
            border-left: 4px solid var(--primary);
        }

        .info-box {
            background: rgba(67, 97, 238, 0.1);
            border-left: 4px solid var(--primary);
            padding: 1rem;
            margin: 1.5rem 0;
            border-radius: 4px;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 10px;
            border-radius: 50%;
            z-index: 100;
        }

        @media (max-width: 768px) {
            .sidebar { display: none; }
        }
    </style>
</head>
<body data-theme="light">

    <div class="theme-toggle" id="themeBtn"><i class="fas fa-moon"></i></div>

    <aside class="sidebar">
        <h2>TMS Docs</h2>
        <div class="nav-group">
            <span class="nav-group-title">Introduction</span>
            <a href="#about" class="nav-link">About TMS</a>
            <a href="#installation" class="nav-link">Installation</a>
        </div>
        <div class="nav-group">
            <span class="nav-group-title">Core Features</span>
            <a href="#search" class="nav-link">Global Search</a>
            <a href="#tenders" class="nav-link">Managing Tenders</a>
            <a href="#vendors" class="nav-link">Vendor Portal</a>
        </div>
        <div class="nav-group">
            <span class="nav-group-title">Development</span>
            <a href="#database" class="nav-link">Database Schema</a>
            <a href="#api" class="nav-link">API Reference</a>
        </div>
    </aside>

    <main class="doc-content">
        <section id="about">
            <h1>System Documentation</h1>
            <p>Welcome to the official documentation for the Tender Management System (TMS). This guide covers everything from initial setup to advanced feature management.</p>
            <div class="info-box">
                <strong>Current Version:</strong> 2.1.0 (Stable)
            </div>
        </section>

        <section id="installation">
            <h3>Installation Guide</h3>
            <p>To get the TMS running locally or on a server, follow these steps:</p>
            <ol style="margin-left: 20px; color: var(--text-muted);">
                <li>Upload the project files to your PHP server (XAMPP/WAMP/CPanel).</li>
                <li>Import the <code>database.sql</code> file into your MySQL database.</li>
                <li>Update <code>config/db_config.php</code> with your credentials:</li>
            </ol>
            <div class="code-block">
                $host = "localhost";<br>
                $user = "root";<br>
                $pass = "password";<br>
                $dbname = "tms_db";
            </div>
        </section>

        <section id="search">
            <h3>Global & Advanced Search</h3>
            <p>The Search module allows users to filter tenders based on Company, Name, Status, and Brand. The <strong>Global Search</strong> bar uses a unified query to scan all table columns simultaneously.</p>
            <div class="info-box">
                Tip: Use the "Eye" icons to toggle visibility of sensitive quoted prices.
            </div>
        </section>

        <section id="database">
            <h3>Database Schema</h3>
            <p>The system relies on a relational database structure designed for high-concurrency bidding.</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid var(--border);">
                        <th style="padding: 10px;">Table</th>
                        <th style="padding: 10px;">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid var(--border);"><code>tenders</code></td>
                        <td style="padding: 10px; border-bottom: 1px solid var(--border);">Core tender details and deadlines.</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid var(--border);"><code>companies</code></td>
                        <td style="padding: 10px; border-bottom: 1px solid var(--border);">List of global tender publishers.</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid var(--border);"><code>submissions</code></td>
                        <td style="padding: 10px; border-bottom: 1px solid var(--border);">Vendor bids and quoted prices.</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="api">
            <h3>API Integration</h3>
            <p>Fetch tender data in JSON format for external mobile apps or third-party integrations.</p>
            <div class="code-block">
                GET /api/get_tenders.php?status=active
            </div>
        </section>

        <footer style="margin-top: 5rem; color: var(--text-muted); font-size: 0.8rem;">
            &copy; 2026 TMS Documentation Panel | Generated for Firoj Hosen (Web Developer)
        </footer>
    </main>

    <script>
        // Theme Toggle Logic
        const themeBtn = document.getElementById('themeBtn');
        const body = document.body;

        themeBtn.addEventListener('click', () => {
            const isDark = body.getAttribute('data-theme') === 'dark';
            body.setAttribute('data-theme', isDark ? 'light' : 'dark');
            themeBtn.innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
        });

        // Simple Active Link Highlighting
        const links = document.querySelectorAll('.nav-link');
        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>