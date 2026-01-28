// Toggle Dark/Light Mode
function toggleTheme() {
    const body = document.body;
    const btn = document.getElementById('theme-btn');
    
    if (body.classList.contains('light-theme')) {
        body.classList.replace('light-theme', 'dark-theme');
        btn.innerText = "☀️ Light Mode";
        localStorage.setItem('theme', 'dark-theme');
    } else {
        body.classList.replace('dark-theme', 'light-theme');
        btn.innerText = "🌙 Dark Mode";
        localStorage.setItem('theme', 'light-theme');
    }
}

// Custom Background Upload
function uploadBackground(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.documentElement.style.setProperty('--bg-image', `url(${e.target.result})`);
            localStorage.setItem('customBG', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Load saved preferences on startup
window.onload = () => {
    const savedTheme = localStorage.getItem('theme');
    const savedBG = localStorage.getItem('customBG');
    
    if (savedTheme) document.body.className = savedTheme;
    if (savedBG) document.documentElement.style.setProperty('--bg-image', `url(${savedBG})`);
};