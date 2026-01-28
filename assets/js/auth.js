/* auth.js */
document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
    
    // Check for saved user preference
    const savedTheme = localStorage.getItem('auth-theme') || 'light';
    root.setAttribute('data-theme', savedTheme);
    updateToggleIcon(savedTheme);

    themeBtn.addEventListener('click', () => {
        const currentTheme = root.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        root.setAttribute('data-theme', newTheme);
        localStorage.setItem('auth-theme', newTheme);
        updateToggleIcon(newTheme);
    });

    function updateToggleIcon(theme) {
        themeBtn.innerHTML = theme === 'light' ? '🌙' : '☀️';
    }

    // Input interaction animation
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.style.transform = 'translateX(5px)';
            input.parentElement.style.transition = 'transform 0.3s ease';
        });
        input.addEventListener('blur', () => {
            input.parentElement.style.transform = 'translateX(0)';
        });
    });
});
