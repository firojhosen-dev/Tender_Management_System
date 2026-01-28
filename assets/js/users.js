// Theme Management
const initTheme = () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);
};

const toggleTheme = () => {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
};

const updateThemeIcon = (theme) => {
    const icon = document.getElementById('theme-icon');
    if(icon) icon.textContent = theme === 'light' ? '🌙' : '☀️';
};

// Modal Logic
const toggleModal = (modalId, action) => {
    const modal = document.getElementById(modalId);
    modal.style.display = action === 'open' ? 'flex' : 'none';
};

// Notification System
const notify = (msg, type = 'success') => {
    const div = document.createElement('div');
    div.className = `notification ${type}`;
    div.style.cssText = `position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 8px; color: white; background: ${type === 'success' ? 'var(--success)' : 'var(--danger)'}; z-index: 9999; animation: slideIn 0.3s ease;`;
    div.textContent = msg;
    document.body.appendChild(div);
    setTimeout(() => div.remove(), 3000);
};

// Initialize
document.addEventListener('DOMContentLoaded', initTheme);