<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Tender Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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
            
            /* -- Semantic Mapping (Default/Light) -- */
            --app-bg: var(--accent-light);
            --surface: var(--white);
            --text-main: var(--secondary-dark);
            --text-muted: var(--primary-dark);
            --border-color: var(--gray-light);
            --input-bg: var(--white);
            --card-bg: var(--white);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* -- Dark Mode Mapping -- */
        [data-theme="dark"] {
            --app-bg: var(--bg-dark);
            --background-image: var(--gradient-main);
            --surface: rgba(22, 12, 64, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: var(--white);
            --text-muted: var(--gray-light);
            --border-color: rgba(255,255,255,0.1);
            --input-bg: rgba(255,255,255,0.05);
            --shadow: 0 10px 25px rgba(0,0,0,0.5);
            --gradient-text: linear-gradient(90deg, var(--primary), var(--white));
            --card-bg: rgba(255, 255, 255, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--app-bg);
            background-image: var(--background-image, none);
            background-attachment: fixed;
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            transition: var(--transition);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Theme Toggle --- */
        .theme-switch {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--surface);
            border: 1px solid var(--glass-border);
            padding: 10px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* --- Hero Section --- */
        .hero {
            padding: 100px 0 60px;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            background: var(--gradient-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .hero p {
            max-width: 700px;
            margin: 0 auto;
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* --- Content Sections --- */
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.2rem;
            display: inline-block;
            border-bottom: 4px solid var(--primary);
            padding-bottom: 10px;
            color: var(--text-main);
        }

        /* --- Feature Grid --- */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 80px;
        }

        .feature-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--neon-glow);
            border-color: var(--primary);
        }

        .feature-card i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            margin-bottom: 15px;
            color: var(--text-main);
        }

        /* --- Workflow Timeline --- */
        .workflow-container {
            position: relative;
            padding: 40px 0;
            margin-bottom: 80px;
        }

        .workflow-step {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            background: var(--card-bg);
            padding: 20px;
            border-radius: 15px;
            border-left: 5px solid var(--primary);
            transition: var(--transition);
        }

        .workflow-step:hover {
            background: var(--surface);
            transform: scale(1.02);
        }

        .step-num {
            background: var(--gradient-bar);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 20px;
            flex-shrink: 0;
        }

        /* --- Tech Stack --- */
        .tech-pills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .pill {
            background: var(--primary-dark);
            color: var(--white);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid var(--primary);
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .features-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="theme-switch" id="theme-toggle">
        <i class="fas fa-sun" style="color: #f1c40f;"></i>
        <i class="fas fa-moon" style="color: #9b59b6;"></i>
    </div>

    <header class="hero">
        <div class="container" data-aos="fade-up">
            <h1>Tender Management System</h1>
            <p>A sophisticated web-based solution designed to simplify, organize, and automate the entire procurement lifecycle with maximum transparency.</p>
        </div>
    </header>

    <main class="container">
        
        <section style="margin-bottom: 100px;" data-aos="fade-right">
            <div class="feature-card" style="text-align: left; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
                <div>
                    <h2 style="margin-bottom: 20px; color: var(--primary);">Why TMS?</h2>
                    <p>Managing tenders manually is time-consuming and error-prone. Our system centralizes data, automates approvals, and ensures every decision is logged for accountability.</p>
                </div>
                <div style="background: var(--gradient-bar); height: 200px; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shield-halved" style="color: white; font-size: 5rem;"></i>
                </div>
            </div>
        </section>

        <section class="section-title" data-aos="fade-up">
            <h2>Core Features</h2>
            <div class="features-grid" style="margin-top: 50px;">
                <div class="feature-card">
                    <i class="fas fa-users-gear"></i>
                    <h3>Role Management</h3>
                    <p>Specific dashboards for Admins, Auditors, Reviewers, and Vendors.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-file-signature"></i>
                    <h3>Tender Lifecycle</h3>
                    <p>Complete control over creation, publishing, and real-time status tracking.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-chart-line"></i>
                    <h3>Advanced Reporting</h3>
                    <p>Detailed performance analytics and audit logs for decision-making.</p>
                </div>
            </div>
        </section>

        <section data-aos="zoom-in">
            <div class="section-title">
                <h2>System Workflow</h2>
            </div>
            <div class="workflow-container">
                <div class="workflow-step">
                    <div class="step-num">1</div>
                    <div><strong>Tender Creation:</strong> Creator publishes requirements and specs.</div>
                </div>
                <div class="workflow-step">
                    <div class="step-num">2</div>
                    <div><strong>Participation:</strong> Vendors register and submit secure documents.</div>
                </div>
                <div class="workflow-step">
                    <div class="step-num">3</div>
                    <div><strong>Review:</strong> Auditors and Reviewers evaluate submissions.</div>
                </div>
                <div class="workflow-step">
                    <div class="step-num">4</div>
                    <div><strong>Final Decision:</strong> Admin approves and closes the tender.</div>
                </div>
            </div>
        </section>

        <section style="text-align: center; margin-bottom: 100px;" data-aos="fade-up">
            <h2>Technology Stack</h2>
            <div class="tech-pills">
                <span class="pill">HTML5</span>
                <span class="pill">CSS3</span>
                <span class="pill">JavaScript</span>
                <span class="pill">PHP</span>
                <span class="pill">MySQL</span>
                <span class="pill">Apache</span>
            </div>
        </section>

    </main>

    <footer style="padding: 40px; text-align: center; border-top: 1px solid var(--glass-border);">
        <p style="color: var(--text-muted);">&copy; <?php echo date('Y'); ?> Tender Management System | Secure Procurement Solution</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize Animations
        AOS.init({
            duration: 1000,
            once: true
        });

        // Theme Toggle Logic
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.documentElement;

        // Check for saved theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        body.setAttribute('data-theme', savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>
