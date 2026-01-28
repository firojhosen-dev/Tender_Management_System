<?php
// contact/admin_contact.php

// Simple server-side processing placeholder
$message_sent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // 2. Here you would normally send the email
    // mail("admin@yoursite.com", $subject, $message, "From: $email");

    // 3. Trigger success state
    $message_sent = true;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Support Line</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            /* -- Provided Color Palette -- */
            --primary: #46B5D3;
            --primary-dark: #0D0B63;
            --bg-dark: #160C40;
            --secondary-dark: #151B4D;
            --white: #FFFFFF;
            --gray-light: #E7DFDF;
            --accent-light: #E1F3F3;
            --you_access_icon: #4CAF50;
            --you_not_access_icon: #F44336;

            /* -- Gradients -- */
            --gradient-main: linear-gradient(135deg, var(--primary-dark), var(--bg-dark));
            --gradient-text: linear-gradient(90deg, var(--primary-dark), var(--secondary-dark));
            --gradient-bar: linear-gradient(90deg, var(--primary), var(--secondary-dark));

            /* -- Effects -- */
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.4);
            --neon-glow: 0 0 15px rgba(70, 181, 211, 0.5);
            --shadow: 0 10px 25px rgba(0,0,0,0.1);
            
            /* -- Dynamic Theme Variables (Default to Light logic structure for mapping) -- */
            --app-bg: var(--accent-light);
            --surface: var(--white);
            --text-main: var(--secondary-dark);
            --text-muted: var(--primary-dark);
            --border-color: var(--gray-light);
            --input-bg: var(--white);
            --card-bg: var(--white);
            
            /* Toggle Specifics */
            --toggle-bg: var(--gray-light);
            --toggle-ball: var(--white);
        }

        /* -- Dark Mode Mapping -- */
        [data-theme="dark"] {
            --app-bg: var(--bg-dark);
            --surface: rgba(22, 12, 64, 0.7); /* Glassy dark surface */
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: var(--white);
            --text-muted: var(--gray-light);
            --border-color: rgba(255,255,255,0.1);
            --input-bg: rgba(255,255,255,0.05);
            --shadow: 0 20px 50px rgba(0,0,0,0.5);
            --gradient-text: linear-gradient(90deg, var(--primary), var(--white));
            --card-bg: rgba(255,255,255,0.05);
            
            /* Dark Mode Overrides */
            --gradient-main-bg: var(--gradient-main);
            --toggle-bg: rgba(255,255,255,0.1);
            --toggle-ball: var(--primary);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            background-color: var(--app-bg);
            /* If dark mode, use gradient, else use solid color */
            background-image: var(--gradient-main-bg, none); 
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Floating Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: float 10s infinite ease-in-out;
        }
        .shape-1 {
            width: 300px; height: 300px;
            background: var(--primary);
            top: -10%; left: -10%;
            opacity: 0.4;
        }
        .shape-2 {
            width: 250px; height: 250px;
            background: var(--primary-dark);
            bottom: -10%; right: -10%;
            opacity: 0.6;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 40px); }
        }

        /* Main Card Container */
        .contact-container {
            width: 100%;
            max-width: 950px;
            background: var(--surface);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        /* Left Sidebar */
        .contact-info {
            background: var(--gradient-bar);
            padding: 3rem 2.5rem;
            color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Pattern Overlay on sidebar */
        .contact-info::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.3;
        }

        .info-header h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .info-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .info-details {
            margin-top: 2rem;
            z-index: 1;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .detail-icon {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.1rem;
            transition: 0.3s;
        }
        
        .detail-item:hover .detail-icon {
            background: var(--white);
            color: var(--primary-dark);
            transform: scale(1.1);
        }

        /* Right Form Area */
        .contact-form {
            padding: 3rem;
            position: relative;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .form-header h2 {
            font-size: 2rem;
            background: var(--gradient-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 50px;
            height: 26px;
            background: var(--toggle-bg);
            border-radius: 50px;
            border: 1px solid var(--border-color);
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5px;
        }

        .theme-toggle::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: var(--toggle-ball);
            border-radius: 50%;
            transition: 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        [data-theme="dark"] .theme-toggle::after {
            transform: translateX(24px);
        }

        .theme-toggle i {
            font-size: 0.7rem;
            color: var(--text-muted);
            z-index: 0;
        }

        /* Input Fields */
        .input-box {
            position: relative;
            margin-bottom: 2rem;
        }

        .input-box input, 
        .input-box textarea {
            width: 100%;
            padding: 12px 15px;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            color: var(--text-main);
            font-size: 1rem;
            transition: 0.3s;
        }

        .input-box textarea {
            height: 120px;
            resize: none;
        }

        /* Floating Label Animation */
        .input-box label {
            position: absolute;
            left: 15px;
            top: 12px;
            color: var(--text-muted);
            font-size: 0.95rem;
            pointer-events: none;
            transition: 0.3s ease all;
            background: transparent; 
            padding: 0 5px;
        }

        /* Focus & Valid States */
        .input-box input:focus,
        .input-box textarea:focus {
            border-color: var(--primary);
            box-shadow: var(--neon-glow);
        }

        .input-box input:focus ~ label,
        .input-box input:not(:placeholder-shown) ~ label,
        .input-box textarea:focus ~ label,
        .input-box textarea:not(:placeholder-shown) ~ label {
            top: -10px;
            left: 10px;
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 600;
            background: var(--surface); /* Mask line behind label */
            border-radius: 4px;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--gradient-bar);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(70, 181, 211, 0.4);
        }

        /* Button Ripple Effect */
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        .btn-submit:hover::before {
            left: 100%;
        }

        /* Success Message Overlay */
        .success-overlay {
            position: absolute;
            inset: 0;
            background: var(--surface);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 20;
            opacity: 0;
            visibility: hidden;
            transition: 0.4s;
            text-align: center;
            padding: 2rem;
        }

        .success-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .icon-check {
            font-size: 3rem;
            color: var(--you_access_icon);
            margin-bottom: 1rem;
            animation: popIn 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        @keyframes popIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }
            .contact-info {
                padding: 2rem;
                align-items: center;
                text-align: center;
            }
            .contact-info::before {
                display: none; /* Cleaner look on mobile */
            }
            .form-header h2 {
                font-size: 1.5rem;
            }
            .detail-item {
                flex-direction: column;
                gap: 10px;
            }
            .detail-icon {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="contact-container">
        
        <div class="contact-info">
            <div class="info-header">
                <h3>Admin Portal</h3>
                <p>Restricted access channel. Please use this form for urgent system notifications or administrative queries only.</p>
            </div>
            
            <div class="info-details">
                <div class="detail-item">
                    <div class="detail-icon"><i class="fa-solid fa-lock"></i></div>
                    <span>End-to-End Encrypted</span>
                </div>
                <div class="detail-item">
                    <div class="detail-icon"><i class="fa-solid fa-server"></i></div>
                    <span>Server Status: Online</span>
                </div>
                <div class="detail-item">
                    <div class="detail-icon"><i class="fa-solid fa-user-shield"></i></div>
                    <span>Admin Clearance Required</span>
                </div>
            </div>

            <div style="font-size: 0.8rem; opacity: 0.6; text-align: center;">
                ID: <?php echo uniqid('ADM-'); ?>
            </div>
        </div>

        <div class="contact-form">
            
            <?php if($message_sent): ?>
            <div class="success-overlay active">
                <i class="fa-solid fa-circle-check icon-check"></i>
                <h3 style="color: var(--text-main); margin-bottom: 10px;">Transmission Sent</h3>
                <p style="color: var(--text-muted);">The request has been logged successfully.</p>
                <button onclick="window.location.href='admin_contact.php'" class="btn-submit" style="margin-top: 20px; width: auto; padding: 10px 30px;">
                    Back to Form
                </button>
            </div>
            <?php endif; ?>

            <div class="form-header">
                <h2>Contact Admin</h2>
                <div class="theme-toggle" id="themeToggle" title="Toggle Light/Dark Mode">
                    <i class="fa-solid fa-sun"></i>
                    <i class="fa-solid fa-moon"></i>
                </div>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                
                <div class="input-box">
                    <input type="text" name="name" id="name" placeholder=" " required autocomplete="off">
                    <label for="name">Administrator Name</label>
                </div>

                <div class="input-box">
                    <input type="email" name="email" id="email" placeholder=" " required autocomplete="off">
                    <label for="email">Associated Email</label>
                </div>

                <div class="input-box">
                    <input type="text" name="subject" id="subject" placeholder=" " required autocomplete="off">
                    <label for="subject">Reference / Subject</label>
                </div>

                <div class="input-box">
                    <textarea name="message" id="message" placeholder=" " required></textarea>
                    <label for="message">Message Payload</label>
                </div>

                <button type="submit" class="btn-submit">
                    Send Message <i class="fa-solid fa-paper-plane"></i>
                </button>

            </form>
        </div>
    </div>

    <script>
        // Theme Management Script
        const toggleBtn = document.getElementById('themeToggle');
        const root = document.documentElement;

        // 1. Check Local Storage
        const currentTheme = localStorage.getItem('theme') || 'dark';
        root.setAttribute('data-theme', currentTheme);

        // 2. Toggle Event
        toggleBtn.addEventListener('click', () => {
            const val = root.getAttribute('data-theme');
            const newVal = val === 'dark' ? 'light' : 'dark';
            
            root.setAttribute('data-theme', newVal);
            localStorage.setItem('theme', newVal);
        });
    </script>
</body>
</html>