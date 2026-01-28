
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS | Project Documentation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    
    <style>
        /* --- CSS VARIABLES (Strict adherence to project colors) --- */
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
            --code-bg: #1e293b;
            --code-text: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
            --code-bg: #020617;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; transition: background 0.3s ease, color 0.3s ease; }
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            padding: 40px 20px;
            line-height: 1.6;
        }

        /* --- Scrollbar --- */
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; border: 2px solid var(--bg-body); }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        /* --- Layout --- */
        .container { max-width: 1100px; margin: 0 auto; }
        
        .readme-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 50px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        /* --- Typography --- */
        h1 { font-size: 2.5rem; margin-bottom: 10px; color: var(--primary); display: flex; align-items: center; gap: 15px; }
        h2 { font-size: 1.5rem; margin-top: 40px; margin-bottom: 20px; border-bottom: 2px solid var(--border); padding-bottom: 10px; color: var(--text-main); }
        h3 { font-size: 1.1rem; margin-top: 0; margin-bottom: 10px; color: var(--primary); font-weight: 700; }
        p, li { color: var(--text-muted); font-size: 0.95rem; margin-bottom: 10px; }
        
        strong { color: var(--text-main); font-weight: 700; }

        /* --- Badges --- */
        .badge-group { display: flex; gap: 10px; margin-top: 15px; margin-bottom: 30px; }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; color: white; }

        /* --- Feature Grid --- */
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .feature-item { 
            background: rgba(67, 97, 238, 0.03); 
            padding: 20px; 
            border-radius: 12px; 
            border: 1px solid var(--border); 
        }
        .feature-item ul { margin-left: 20px; margin-bottom: 0; }

        /* --- Code Blocks --- */
        pre {
            background: var(--code-bg);
            color: var(--code-text);
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            margin-bottom: 20px;
            border-left: 5px solid var(--primary);
            position: relative;
        }

        code { font-family: 'Courier New', monospace; }
        p code, li code {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        /* --- Tables --- */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; min-width: 600px; }
        th, td { padding: 12px 15px; border: 1px solid var(--border); text-align: left; }
        th { background: rgba(67, 97, 238, 0.08); text-align: center; color: var(--primary); font-weight: 700; font-size: 0.9rem; }
        td { color: var(--text-muted); font-size: 0.9rem; text-align: center; }
        tr:nth-child(even) { background: rgba(0,0,0,0.02); }

        /* --- Color Palette Visualizer --- */
        .color-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 15px; margin-bottom: 30px; }
        .color-box {
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--border);
            background: var(--bg-card);
            box-shadow: var(--shadow);
        }
        .swatch { width: 100%; height: 45px; border-radius: 8px; margin-bottom: 10px; border: 1px solid rgba(0,0,0,0.1); }
        .color-name { font-size: 0.85rem; font-weight: 700; display: block; color: var(--text-main); }
        .color-hex { font-size: 0.75rem; color: var(--text-muted); font-family: monospace; display: block; margin-top: 2px; }

        /* --- Theme Toggle & Copy Btn --- */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 50%;
            z-index: 100;
            box-shadow: var(--shadow);
            color: var(--text-main);
        }
        .you_access_this { color: var(--success);
    font-size: 30px;
text-align: center; }
        .you_not_access_this { color: var(--danger); font-size: 30px;}
        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            font-size: 0.7rem;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: 0.2s;
        }
        .copy-btn:hover { background: var(--primary); border-color: var(--primary); }

        @media (max-width: 768px) {
            .readme-card { padding: 25px; }
            h1 { font-size: 1.8rem; flex-direction: column; align-items: flex-start; }
            .badge-group { flex-wrap: wrap; }
        }
    </style>
</head>
<body data-theme="light">

    <div class="theme-toggle" id="themeBtn" title="Toggle Dark Mode"><i class="fas fa-moon"></i></div>

    <div class="container">
        <div class="readme-card">
            
            <header>
                <h1><i class="fas fa-file-contract"></i> Tender Management System</h1>
                <p>A complete <strong>Tender Management System</strong> built using <strong>PHP, MySQL, HTML, CSS, and JavaScript</strong>. This system helps organizations manage tenders, companies, vendors, users, documents, reports, and approvals efficiently with role-based access control.</p>
                
                <div class="badge-group">
                    <span class="badge" style="background:var(--primary);">v2.1.0</span>
                    <span class="badge" style="background:var(--success);">PHP 8+</span>
                    <span class="badge" style="background:#1e293b;">MySQLi</span>
                    <span class="badge" style="background:var(--warning); color: #000;">RBAC Secured</span>
                </div>
            </header>

            <h2>🚀 Features Overview</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <h3><i class="fas fa-lock"></i> Auth & Security</h3>
                    <ul>
                        <li>Secure login & logout system</li>
                        <li>Password hashing (bcrypt)</li>
                        <li>Session-based authentication</li>
                        <li><strong>RBAC</strong> (Role-Based Access Control)</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3><i class="fas fa-users"></i> User Management</h3>
                    <ul>
                        <li>Add, edit, delete users</li>
                        <li>Roles: Admin, Auditor, Reviewer, Creator, Vendor</li>
                        <li>Account status (Active/Suspended)</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3><i class="fas fa-building"></i> Company Mgmt</h3>
                    <ul>
                        <li>Add/List tender companies</li>
                        <li><strong>Duplicate name prevention</strong></li>
                        <li>Detailed company profiles</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3><i class="fas fa-file-signature"></i> Tender Operations</h3>
                    <ul>
                        <li>Create & Assign tenders</li>
                        <li>Status tracking & Deadlines</li>
                        <li>Document upload management</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3><i class="fas fa-chart-pie"></i> Dashboard & Reports</h3>
                    <ul>
                        <li>Visual stats widgets</li>
                        <li>PDF/Excel ready report structure</li>
                        <li>Vendor participation logs</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3><i class="fas fa-palette"></i> UI/UX Design</h3>
                    <ul>
                        <li><strong>Glassmorphism</strong> aesthetics</li>
                        <li>Dark & Light mode support</li>
                        <li>Responsive Mobile/Desktop view</li>
                    </ul>
                </div>
            </div>

            <h2>🎨 Design System & Color Palette</h2>
            <p>The project uses a strict color palette. Do not use colors outside this list.</p>
            <div class="color-grid">
                <div class="color-box">
                    <div class="swatch" style="background: #4361ee;"></div>
                    <span class="color-name">Primary Blue</span>
                    <span class="color-hex">#4361ee</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #f0f2f5;"></div>
                    <span class="color-name">Body BG (Light)</span>
                    <span class="color-hex">#f0f2f5</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #ffffff; border:1px solid #dee2e6;"></div>
                    <span class="color-name">Card BG (Light)</span>
                    <span class="color-hex">#ffffff</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #1e293b;"></div>
                    <span class="color-name">Text Main</span>
                    <span class="color-hex">#1e293b</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #64748b;"></div>
                    <span class="color-name">Text Muted</span>
                    <span class="color-hex">#64748b</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #2ecc71;"></div>
                    <span class="color-name">Success Green</span>
                    <span class="color-hex">#2ecc71</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #f1c40f;"></div>
                    <span class="color-name">Warning Yellow</span>
                    <span class="color-hex">#f1c40f</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #e74c3c;"></div>
                    <span class="color-name">Danger Red</span>
                    <span class="color-hex">#e74c3c</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #0f172a;"></div>
                    <span class="color-name">Body BG (Dark)</span>
                    <span class="color-hex">#0f172a</span>
                </div>
                <div class="color-box">
                    <div class="swatch" style="background: #1e293b;"></div>
                    <span class="color-name">Card BG (Dark)</span>
                    <span class="color-hex">#1e293b</span>
                </div>
            </div>

            <h2>🛠️ Technology Stack</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr><th width="20%">Layer</th><th>Technology</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Backend</strong></td><td>PHP (Procedural / MySQLi)</td></tr>
                        <tr><td><strong>Database</strong></td><td>MySQL</td></tr>
                        <tr><td><strong>Frontend</strong></td><td>HTML5, CSS3, JavaScript</td></tr>
                        <tr><td><strong>UI Design</strong></td><td>Custom CSS (Glassmorphism), FontAwesome</td></tr>
                        <tr><td><strong>Security</strong></td><td>Prepared statements, RBAC, Input Sanitization</td></tr>
                    </tbody>
                </table>
            </div>

            <h2>📂 Project Structure</h2>
            <pre><button class="copy-btn" onclick="copyCode(this)">Copy</button><code>tender-management-system/
├── config/
│   ├── database.php
│   ├── database_create.sql
│   ├── auth.php
│   └── system_settings.php   ← helper file
├── assets/
│   ├── css/
│   │   ├── auth.css
│   │   ├── dashboard.css
│   │   ├── companies.css
│   │   ├── tenders.css
│   │   ├── search.css
│   │   ├── includes.css
│   │   ├── system.css
│   │   ├── profile.css
│   │   ├── includes.css
│   │   ├── reports.css
│   │   └── style.css
│   └── js/
│   │   ├── auth.js
│   │   ├── dashboard.js
│   │   ├── companies.js
│   │   ├── tenders.js
│   │   ├── search.js
│   │   ├── includes.js
│   │   ├── system.js
│   │   ├── profile.js
│   │   ├── includes.js
│   │   ├── reports.js 
│       └── main.js
├── uploads/
│   └── tender_documents/
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── dashboard/
│   └── dashboard.php
├── contact/
│   └── request_access.php
├── companies/
│   ├── add_company.php
│   ├── edit_company.php
│   ├── delete_company.php
│   └── company_list.php
├── tenders/
│   ├── add_tender.php
│   ├── edit_tender.php
│   ├── delete_tender.php
│   ├── tender_management.php
│   ├── view_tender_list_page.php
│   └── view_all_tender_list.php
├── search/
│   ├── global_search.php
│   ├── view_search_result.php
│   └── search_history.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── access.php
├── reports/
│   ├── tender_report.php
│   ├── vendor_report.php
│   ├── user_report.php
│   ├── financial_report.php
│   ├── audit_report.php
│   └── custom_report.php
├── system/
│   ├── system_information.php
│   ├── system_settings_save.php
│   ├── system_settings_reset.php
│   └── system_setting.php
├── profile/
│   ├── user_profile_information.php
│   ├── user_profile_settings.php
│   └── user_profile_save.php
├── you_not_access_this_page.php
├── index.php
└── README.md</code></pre>

            <h2>🔐 Role-Based Access Control (RBAC) Matrix</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>File / Feature</th>
                            <th>Admin</th>
                            <th>Auditor</th>
                            <th>Reviewer</th> 
                            <th>Creator</th>
                            <th>Vendor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Login/Logout</strong></td><td style="text-align: center;"><i class="you_access_this fa-regular fa-circle-check"></i></td><td style="text-align: center;"><i class="you_access_this fa-regular fa-circle-check"></i></td><td style="text-align: center;"><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td></tr>
                        <tr><td><strong>Dashboard Access</strong></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td></tr>
                        <tr><td><strong>Manage Companies</strong></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td></tr>
                        <tr><td><strong>Create Tender</strong></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td></tr>
                        <tr><td><strong>Review Tenders</strong></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td></tr>
                        <tr><td><strong>Global Search</strong></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td></tr>
                        <tr><td><strong>Search History</strong></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td></tr>
                        <tr><td><strong>Reports Module</strong></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_access_this fa-regular fa-circle-check"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td><td><i class="you_not_access_this fa-regular fa-circle-xmark"></i></td></tr>
                    </tbody>
                </table>
            </div>

            <h2>⚙️ Installation Guide</h2>
            
            <h3>1. Setup Database</h3>
            <p>Create a database named <code>tender_management_system</code> and import the SQL file.</p>
            <pre><button class="copy-btn" onclick="copyCode(this)">Copy</button><code>-- In phpMyAdmin or MySQL Workbench
CREATE DATABASE tender_management_system;
-- Import config/database_create.sql</code></pre>

            <h3>2. Configure Connection</h3>
            <p>Edit <code>config/database.php</code> with your local credentials.</p>
            <pre><button class="copy-btn" onclick="copyCode(this)">Copy</button><code>$host = "localhost";
$user = "root";
$pass = "";
$db   = "tender_management_system";

$conn = mysqli_connect($host, $user, $pass, $db);</code></pre>

            <h3>3. Run Project</h3>
            <p>Place the folder in <code>htdocs</code> (XAMPP) and navigate to:</p>
            <pre><button class="copy-btn" onclick="copyCode(this)">Copy</button><code>http://localhost/tender-management-system</code></pre>

            <div style="margin-top: 60px; text-align: center; border-top: 1px solid var(--border); padding-top: 30px;">
                <p>Developed with ❤️ for efficient tender handling and enterprise-grade management.</p>
                <p>For support: <a href="mailto:support@tendermanagementsystem.com" style="color:var(--primary); text-decoration:none; font-weight:700;">support@tendermanagementsystem.com</a></p>
                <small style="color:var(--text-muted);">&copy; <?php echo date("Y"); ?> Tender Management System. All rights reserved.</small>
            </div>
            
        </div>
    </div>

    <script>
        // 1. Theme Toggle Logic
        const themeBtn = document.getElementById('themeBtn');
        const body = document.body;

        themeBtn.addEventListener('click', () => {
            const isDark = body.getAttribute('data-theme') === 'dark';
            body.setAttribute('data-theme', isDark ? 'light' : 'dark');
            themeBtn.innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
            localStorage.setItem('tms-theme', isDark ? 'light' : 'dark');
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('tms-theme');
        if(savedTheme) {
            body.setAttribute('data-theme', savedTheme);
            themeBtn.innerHTML = savedTheme === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        }

        // 2. Copy Code Function
        function copyCode(btn) {
            const codeBlock = btn.nextElementSibling;
            const codeText = codeBlock.innerText;
            
            navigator.clipboard.writeText(codeText).then(() => {
                const originalText = btn.innerText;
                btn.innerText = "Copied!";
                btn.style.background = "var(--success)";
                
                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.style.background = "rgba(255,255,255,0.15)";
                }, 2000);
            });
        }
    </script>
</body>
</html>