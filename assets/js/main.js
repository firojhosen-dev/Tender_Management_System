/* assets/js/main.js */

(() => {
  const body = document.body;
  const sidebar = document.querySelector('.sidebar');
  const themeToggle = document.querySelector('[data-theme-toggle]');

  /* =========================
     THEME SYSTEM
  ========================= */
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) {
    body.setAttribute('data-theme', savedTheme);
  }

  themeToggle?.addEventListener('click', () => {
    const current = body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    body.setAttribute('data-theme', current);
    localStorage.setItem('theme', current);
  });

  /* =========================
     SIDEBAR TOGGLE (MOBILE)
  ========================= */
  document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });

  /* =========================
     SCROLL REVEAL
  ========================= */
  const revealElements = document.querySelectorAll('[data-reveal]');
  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('reveal-active');
        }
      });
    },
    { threshold: 0.15 }
  );

  revealElements.forEach(el => observer.observe(el));

  /* =========================
     BUTTON LOADING STATE
  ========================= */
  document.querySelectorAll('[data-loading]').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.disabled = true;
      btn.innerText = 'Loading...';
    });
  });

  /* =========================
     ACCESSIBILITY
  ========================= */
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal.active').forEach(m => m.classList.remove('active'));
    }
  });
})();
