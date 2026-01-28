document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    // Load saved preference
    const savedTheme = localStorage.getItem('company-theme') || 'light';
    if (savedTheme === 'dark') {
        body.setAttribute('data-theme', 'dark');
        themeToggle.innerHTML = "☀️ Light Mode";
    }

    themeToggle.addEventListener('click', () => {
        const isDark = body.getAttribute('data-theme') === 'dark';
        
        if (isDark) {
            body.removeAttribute('data-theme');
            localStorage.setItem('company-theme', 'light');
            themeToggle.innerHTML = "🌙 Dark Mode";
        } else {
            body.setAttribute('data-theme', 'dark');
            localStorage.setItem('company-theme', 'dark');
            themeToggle.innerHTML = "☀️ Light Mode";
        }
    });
});