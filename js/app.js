// Fonctions globales : thème, utilitaires
(function(){
  // Theme toggle
  const btn = document.getElementById('theme-toggle');
  function setTheme(t){
    document.body.className = t;
    localStorage.setItem('ujeb-theme', t);
    if(btn) btn.textContent = (t === 'dark') ? '☀️' : '🌙';
  }
  const stored = localStorage.getItem('ujeb-theme') || 'light';
  setTheme(stored);
  if(btn){
    btn.addEventListener('click', () => {
      setTheme(document.body.className === 'dark' ? 'light' : 'dark');
    });
  }
})();
