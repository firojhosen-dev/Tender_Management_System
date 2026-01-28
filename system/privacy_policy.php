
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS | Privacy Policy</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --primary: #4361ee;
            --accent: #eff6ff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
            --accent: #1e293b;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
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
            line-height: 1.7;
            display: flex;
            justify-content: center;
            padding: 60px 20px;
        }

        /* --- Custom Scrollbar --- */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; border: 2px solid var(--bg-body); }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        .policy-wrapper {
            max-width: 850px;
            width: 100%;
            background: var(--bg-card);
            padding: 50px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .policy-header {
            text-align: center;
            border-bottom: 2px solid var(--border);
            padding-bottom: 30px;
            margin-bottom: 40px;
        }

        .policy-header h1 { font-size: 2.2rem; color: var(--primary); margin-bottom: 10px; }
        .last-updated { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }

        section { margin-bottom: 35px; }
        h2 { font-size: 1.4rem; margin-bottom: 15px; display: flex; align-items: center; gap: 12px; }
        h2 i { color: var(--primary); font-size: 1.1rem; }

        p { margin-bottom: 15px; font-size: 0.95rem; color: var(--text-muted); }

        ul { list-style: none; margin-bottom: 15px; }
        ul li { 
            position: relative; 
            padding-left: 25px; 
            margin-bottom: 10px; 
            font-size: 0.95rem; 
            color: var(--text-muted);
        }
        ul li::before {
            content: "\f058";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: var(--primary);
        }

        .notice-box {
            background: var(--accent);
            border-left: 4px solid var(--primary);
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .theme-toggle {
            position: fixed;
            top: 25px;
            right: 25px;
            cursor: pointer;
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 50%;
            box-shadow: var(--shadow);
            z-index: 100;
            transition: transform 0.2s ease;
        }
        .theme-toggle:hover { transform: scale(1.1); }

        @media (max-width: 600px) {
            .policy-wrapper { padding: 30px 20px; }
            body { padding: 20px 10px; }
        }
    </style>
</head>
<body data-theme="light">

    <div class="theme-toggle" id="themeBtn"><i class="fas fa-moon"></i></div>

    <div class="policy-wrapper">
        <header class="policy-header">
            <h1>Privacy Policy</h1>
            <p class="last-updated">Effective Date: January 20, 2026</p>
        </header>

        <section>
            <h2><i class="fas fa-user-shield"></i> 1. Introduction</h2>
            <p>This Privacy Policy describes how the Tender Management System (TMS) collects, uses, and shares your information when you use our platform for tender submission, vendor management, or administrative purposes.</p>
        </section>

        <section>
            <h2><i class="fas fa-database"></i> 2. Information We Collect</h2>
            <p>To provide a secure bidding environment, we collect the following data:</p>
            <ul>
                <li><strong>Account Information:</strong> Name, email, company registration details, and contact numbers.</li>
                <li><strong>Tender Data:</strong> Project specifications, bidding documents, and quoted prices.</li>
                <li><strong>Technical Logs:</strong> IP addresses, browser types, and timestamp of bids (for audit trails).</li>
            </ul>
        </section>

        <section>
            <h2><i class="fas fa-eye-slash"></i> 3. Data Confidentiality</h2>
            <p>Our "Eye Toggle" feature ensures that sensitive financial data, such as Quoted Prices and Brand specifications, are only visible to authorized personnel with the correct clearance levels.</p>
            <div class="notice-box">
                <strong>Important:</strong> Your bidding documents are encrypted at rest and are only decrypted during the official Tender Opening period.
            </div>
        </section>

        <section>
            <h2><i class="fas fa-share-nodes"></i> 4. Sharing of Information</h2>
            <p>We do not sell your data. Information is only shared with:</p>
            <ul>
                <li>Authenticated Tender Managers for bid evaluation.</li>
                <li>System Administrators for technical support.</li>
                <li>Legal authorities if required by law for auditing purposes.</li>
            </ul>
        </section>

        <section>
            <h2><i class="fas fa-lock"></i> 5. Data Security</h2>
            <p>We implement industry-standard security measures, including SSL encryption and multi-factor authentication, to protect against unauthorized access or alteration of bidding data.</p>
        </section>

        <section>
            <h2><i class="fas fa-envelope-open-text"></i> 6. Contact Us</h2>
            <p>If you have questions regarding this policy or your data rights, please contact our Data Protection Officer:</p>
            <p style="font-weight: 600; color: var(--primary);">Email: privacy@tms-system.com</p>
        </section>

        <footer style="text-align: center; padding-top: 30px; border-top: 1px solid var(--border); margin-top: 20px;">
            <a href="dashboard.php" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">Back to Dashboard</a>
        </footer>
    </div>

    <script>
        const themeBtn = document.getElementById('themeBtn');
        const body = document.body;

        themeBtn.addEventListener('click', () => {
            const isDark = body.getAttribute('data-theme') === 'dark';
            body.setAttribute('data-theme', isDark ? 'light' : 'dark');
            themeBtn.innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
        });
    </script>
</body>
</html>