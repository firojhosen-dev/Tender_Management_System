<?php 
require_once "../includes/access.php";

checkRole(['Admin', 'Tender Creator', 'Auditor', 'Reviewer', 'Vendor']); // All users can access
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS | Support Desk</title>
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
            --input-bg: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
            --input-bg: #0f172a;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; transition: background 0.3s ease; }
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            padding: 40px 20px;
        }

        /* --- Custom Scrollbar --- */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; border: 2px solid var(--bg-body); }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        .container { max-width: 1200px; margin: 0 auto; }

        /* --- Header Section --- */
        .support-header { text-align: center; margin-bottom: 50px; }
        .support-header h1 { font-size: 2.5rem; margin-bottom: 10px; }
        .support-header p { color: var(--text-muted); }

        /* --- Grid Layout --- */
        .support-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        .card {
            background: var(--bg-card);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        /* --- Knowledge Base --- */
        .faq-item { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--border); cursor: pointer; }
        .faq-item h5 { margin-bottom: 8px; color: var(--primary); display: flex; align-items: center; gap: 10px; }
        .faq-item p { font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; }

        /* --- Form Styling --- */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600; }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--input-bg);
            color: var(--text-main);
            outline: none;
        }
        .form-control:focus { border-color: var(--primary); }
        
        .btn-submit {
            background: var(--primary);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
        }

        /* --- Contact Info Grid --- */
        .contact-methods {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .method-card { text-align: center; padding: 20px; background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border); }
        .method-card i { font-size: 1.5rem; color: var(--primary); margin-bottom: 10px; }

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

        @media (max-width: 900px) {
            .support-grid { grid-template-columns: 1fr; }
            .contact-methods { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body data-theme="light">

    <div class="theme-toggle" id="themeBtn"><i class="fas fa-moon"></i></div>

    <div class="container">
        <header class="support-header">
            <h1>Support Desk</h1>
            <p>How can we help you with the Tender Management System today?</p>
        </header>

        <div class="support-grid">
            <div class="card">
                <h3 style="margin-bottom: 25px;"><i class="fas fa-book-open"></i> Quick FAQ</h3>
                
                <div class="faq-item">
                    <h5><i class="fas fa-question-circle"></i> How to reset my password?</h5>
                    <p>Go to the login page and click 'Forgot Password'. A reset link will be sent to your registered email.</p>
                </div>

                <div class="faq-item">
                    <h5><i class="fas fa-question-circle"></i> Can I edit a submitted bid?</h5>
                    <p>Bids can only be edited before the tender deadline. Once the deadline passes, the bid is locked for review.</p>
                </div>

                <div class="faq-item">
                    <h5><i class="fas fa-question-circle"></i> System says "Unauthorized"?</h5>
                    <p>Ensure you are logged in with the correct role (Vendor or Admin). Try clearing your browser cache.</p>
                </div>
                
                <a href="documentation.php" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">View Full Documentation →</a>
            </div>

            <div class="card">
                <h3 style="margin-bottom: 25px;"><i class="fas fa-ticket-alt"></i> Raise a Support Ticket</h3>
                <form action="process_ticket.php" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Ariful Islam" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Issue Category</label>
                        <select name="category" class="form-control">
                            <option>Technical Issue</option>
                            <option>Account Access</option>
                            <option>Billing/Tender Fees</option>
                            <option>General Inquiry</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Message / Description</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Describe your issue in detail..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Submit Ticket</button>
                </form>
            </div>
        </div>

        <div class="contact-methods">
            <div class="method-card">
                <i class="fas fa-envelope"></i>
                <h4>Email Us</h4>
                <p style="color: var(--text-muted); font-size: 0.8rem;">support@tms-pro.com</p>
            </div>
            <div class="method-card">
                <i class="fas fa-phone-alt"></i>
                <h4>Call Support</h4>
                <p style="color: var(--text-muted); font-size: 0.8rem;">+880 1234 567 890</p>
            </div>
            <div class="method-card">
                <i class="fas fa-comments"></i>
                <h4>Live Chat</h4>
                <p style="color: var(--text-muted); font-size: 0.8rem;">Available 9AM - 6PM</p>
            </div>
        </div>

        <footer style="text-align: center; margin-top: 50px; color: var(--text-muted); font-size: 0.8rem;">
            &copy; 2026 TMS Support Center | Priority Support for Registered Vendors
        </footer>
    </div>

    <script>
        // Theme Toggle Logic
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