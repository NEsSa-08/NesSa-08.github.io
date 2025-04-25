function configurarMenu(toggleId, menuId) {
  const toggle = document.getElementById(toggleId);
  const menu = document.getElementById(menuId);

  toggle.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('mostrar');
  });

  document.addEventListener('click', (e) => {
    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
      menu.classList.remove('mostrar');
    }
  });
}

// Configura ambos menús
configurarMenu('menu-toggle-1', 'menu-1');
configurarMenu('menu-toggle-2', 'menu-2');