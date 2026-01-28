document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const sidebar = document.getElementById('tmsSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuBtn = document.getElementById('menuToggle');
    const closeBtn = document.getElementById('closeMenu');
    const themeBtn = document.getElementById('themeToggle');
    const userMenu = document.getElementById('userMenu');
    const dropdown = document.getElementById('dropdownContent');

    // Sidebar Logic
    const toggleSidebar = () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
        body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
    };

    menuBtn.addEventListener('click', toggleSidebar);
    closeBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Theme Toggle Logic
    const savedTheme = localStorage.getItem('theme') || 'light';
    if(savedTheme === 'dark') {
        body.setAttribute('data-theme', 'dark');
        themeBtn.innerHTML = '<i class="fas fa-sun"></i>';
    }

    themeBtn.addEventListener('click', () => {
        const isDark = body.getAttribute('data-theme') === 'dark';
        if(isDark) {
            body.removeAttribute('data-theme');
            localStorage.setItem('theme', 'light');
            themeBtn.innerHTML = '<i class="fas fa-moon"></i>';
        } else {
            body.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeBtn.innerHTML = '<i class="fas fa-sun"></i>';
        }
    });

    // Dropdown Logic (Native JS)
    userMenu.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    window.addEventListener('click', () => {
        if(dropdown.classList.contains('show')) dropdown.classList.remove('show');
    });

    // Close sidebar on ESC
    document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape' && sidebar.classList.contains('open')) toggleSidebar();
    });
});