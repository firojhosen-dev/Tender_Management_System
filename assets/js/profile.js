/* profile.js */

document.addEventListener('DOMContentLoaded', () => {
    // --- 1. Tab Logic ---
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            tab.classList.add('active');

            // Hide all contents
            contents.forEach(c => c.classList.remove('active'));

            // Show target content with animation reset
            const targetId = tab.getAttribute('data-tab');
            const targetContent = document.getElementById(targetId);
            
            if(targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    // --- 2. Dark Mode Logic ---
    const themeToggle = document.getElementById('themeToggle');
    const root = document.documentElement;
    const icon = themeToggle.querySelector('span'); // Assuming an emoji or icon inside

    // Check Local Storage
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        root.setAttribute('data-theme', currentTheme);
        updateToggleText(currentTheme);
    }

    themeToggle.addEventListener('click', () => {
        const current = root.getAttribute('data-theme');
        const newTheme = current === 'dark' ? 'light' : 'dark';
        
        root.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateToggleText(newTheme);
    });

    function updateToggleText(theme) {
        if (theme === 'dark') {
            themeToggle.innerHTML = '☀️ Light Mode';
        } else {
            themeToggle.innerHTML = '🌙 Dark Mode';
        }
    }
});