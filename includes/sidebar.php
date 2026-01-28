/* --- sidebar.php --- */
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security: Prevent unauthorized access
if (!isset($_SESSION['user_id'])) {
    // header("Location: login.php");
    // exit();
}

$user_role = $_SESSION['role_name'] ?? 'Admin'; 
$current_page = basename($_SERVER['PHP_SELF']);

$menu_items = [
    ['name' => 'Dashboard', 'icon' => 'fas fa-th-large', 'link' => 'dashboard.php', 'roles' => ['Admin', 'Manager', 'Staff']],
    ['name' => 'Tenders', 'icon' => 'fas fa-file-contract', 'link' => 'tenders.php', 'roles' => ['Admin', 'Manager']],
    ['name' => 'Vendors', 'icon' => 'fas fa-handshake', 'link' => 'vendors.php', 'roles' => ['Admin', 'Manager']],
    ['name' => 'Users', 'icon' => 'fas fa-users-cog', 'link' => 'users.php', 'roles' => ['Admin']],
    ['name' => 'Reports', 'icon' => 'fas fa-chart-line', 'link' => 'reports.php', 'roles' => ['Admin', 'Manager']],
    ['name' => 'Settings', 'icon' => 'fas fa-cogs', 'link' => 'settings.php', 'roles' => ['Admin']],
    ['name' => 'Profile', 'icon' => 'fas fa-user-circle', 'link' => 'profile.php', 'roles' => ['Admin', 'Manager', 'Staff']],
    ['name' => 'Logout', 'icon' => 'fas fa-sign-out-alt', 'link' => 'logout.php', 'roles' => ['Admin', 'Manager', 'Staff']],
];
?>

<aside class="sidebar-container" id="mainSidebar">
    <div class="sidebar-header">
        <div class="logo-box">
            <i class="fas fa-gavel logo-icon"></i>
            <span class="logo-text">TMS Pro</span>
        </div>
        <button class="mobile-close-btn" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <?php foreach ($menu_items as $item): ?>
            <?php if (in_array($user_role, $item['roles'])): ?>
                <a href="<?php echo $item['link']; ?>" 
                   class="nav-link <?php echo ($current_page == $item['link']) ? 'active' : ''; ?>">
                    <i class="<?php echo $item['icon']; ?>"></i>
                    <span class="link-text"><?php echo $item['name']; ?></span>
                </a>
            <?php endif; ?>
        <?php foreach; ?>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar"><?php echo substr($user_role, 0, 1); ?></div>
            <div class="user-details">
                <p class="u-name">System User</p>
                <p class="u-role"><?php echo $user_role; ?></p>
            </div>
        </div>
    </div>
</aside>

/* --- header.php --- */
<header class="main-header">
    <div class="header-left">
        <button class="mobile-toggle" id="openSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">Tender Management System</h1>
    </div>
    <div class="header-right">
        <span class="date-display"><?php echo date('D, M j, Y'); ?></span>
    </div>
</header>

/* --- styles.css --- */
<style>
:root {
    --primary-color: #4361ee;
    --primary-dark: #3f37c9;
    --sidebar-bg: #0f172a;
    --sidebar-width-collapsed: 70px;
    --sidebar-width-expanded: 260px;
    --text-color: #f8fafc;
    --transition-speed: 0.4s;
    --glass-blur: blur(12px);
    --glass-bg: rgba(15, 23, 42, 0.85);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

body {
    background: #f1f5f9;
}

/* --- Header --- */
.main-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    z-index: 900;
}

.mobile-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--sidebar-bg);
    cursor: pointer;
}

/* --- Sidebar Desktop --- */
.sidebar-container {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: var(--sidebar-width-collapsed);
    background: var(--sidebar-bg);
    color: var(--text-color);
    overflow: hidden;
    transition: width var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1), background var(--transition-speed);
    z-index: 1001;
    display: flex;
    flex-direction: column;
}

.sidebar-container:hover {
    width: var(--sidebar-width-expanded);
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border-right: 1px solid rgba(255,255,255,0.1);
}

.sidebar-header {
    height: 70px;
    display: flex;
    align-items: center;
    padding: 0 20px;
    margin-bottom: 20px;
}

.logo-box {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo-icon {
    font-size: 1.8rem;
    color: var(--primary-color);
    min-width: 30px;
}

.logo-text {
    font-size: 1.25rem;
    font-weight: 700;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s;
}

.sidebar-container:hover .logo-text {
    opacity: 1;
}

/* --- Navigation Links --- */
.sidebar-nav {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 0 10px;
}

.nav-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #94a3b8;
    height: 50px;
    border-radius: 8px;
    transition: all 0.3s;
    white-space: nowrap;
    padding: 0 15px;
}

.nav-link i {
    font-size: 1.2rem;
    min-width: 30px;
    margin-right: 15px;
    text-align: center;
}

.link-text {
    opacity: 0;
    transition: opacity 0.3s;
    font-weight: 500;
}

.sidebar-container:hover .link-text {
    opacity: 1;
}

.nav-link:hover {
    background: rgba(255,255,255,0.05);
    color: #fff;
}

.nav-link.active {
    background: var(--primary-color);
    color: #fff;
    box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 35px;
    height: 35px;
    background: var(--primary-dark);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    min-width: 35px;
}

.user-details {
    opacity: 0;
    transition: opacity 0.3s;
    white-space: nowrap;
}

.sidebar-container:hover .user-details {
    opacity: 1;
}

.u-name { font-size: 0.9rem; font-weight: 600; }
.u-role { font-size: 0.75rem; color: #94a3b8; }

.mobile-close-btn { display: none; }

/* --- Mobile Breakpoint --- */
@media (max-width: 768px) {
    .mobile-toggle { display: block; }
    
    .sidebar-container {
        width: 100% !important;
        left: -100%;
        background: var(--sidebar-bg) !important;
        backdrop-filter: none !important;
        transition: left 0.5s cubic-bezier(0.77,0,0.175,1);
    }

    .sidebar-container.mobile-active {
        left: 0;
    }

    .sidebar-container .logo-text,
    .sidebar-container .link-text,
    .sidebar-container .user-details {
        opacity: 1;
    }

    .sidebar-nav {
        justify-content: center;
        align-items: center;
    }

    .nav-link {
        width: 80%;
        justify-content: center;
        height: 60px;
        font-size: 1.2rem;
    }

    .mobile-close-btn {
        display: block;
        background: none;
        border: none;
        color: #fff;
        font-size: 2rem;
        margin-left: auto;
        cursor: pointer;
    }
    
    .sidebar-header {
        padding: 0 30px;
        height: 100px;
    }
}
</style>

/* --- script.js --- */
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('mainSidebar');
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const navLinks = document.querySelectorAll('.nav-link');

    // Mobile Open
    openBtn.addEventListener('click', () => {
        sidebar.classList.add('mobile-active');
        document.body.style.overflow = 'hidden'; // Prevent scroll
    });

    // Mobile Close
    const closeSidebar = () => {
        sidebar.classList.remove('mobile-active');
        document.body.style.overflow = 'auto';
    };

    closeBtn.addEventListener('click', closeSidebar);

    // Active Link Handler (Visual only for demo, PHP handles actual routing)
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('mobile-active')) {
            closeSidebar();
        }
    });
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">