document.addEventListener('DOMContentLoaded', function() {
    const menu = document.getElementById('megaMenu');
    const btn = document.getElementById('menuToggle');
    const body = document.body;
    const primary = document.querySelector('section#primary'); 
    
    if (!menu || !btn) return;

    const btnText = btn.querySelector('.text');

    function updateButtonText() {
        if (!btnText) return;
        btnText.innerText = menu.classList.contains('is-closed') ? " > Mostrar menus" : "X Esconder menus";
    }

    function applyMenuState(isClosed, save = true) {
        if (isClosed) {
            menu.classList.add('is-closed');
            body.classList.add('menu-is-closed');
            primary?.classList.add('menu-is-closed');
        } else {
            menu.classList.remove('is-closed');
            body.classList.remove('menu-is-closed');
            primary?.classList.remove('menu-is-closed');
        }

        if (save) {
            localStorage.setItem('menuStatus', isClosed ? 'closed' : 'open');
        }
        updateButtonText();
    }

    // --- 1. INICIALIZAÇÃO SILENCIOSA (SEM ANIMAÇÃO) ---
    const savedState = localStorage.getItem('menuStatus');
    const isMobile = window.innerWidth < 782;

    // Aplicamos o estado inicial antes de qualquer transição existir no CSS
    if (isMobile || savedState === 'closed') {
        applyMenuState(true, false);
    } else {
        applyMenuState(false, false);
    }

    // --- 2. O TRUQUE: LIBERAR ANIMAÇÕES APÓS O RENDER ---
    // Adicionamos 'is-ready' para ativar os transitions do CSS apenas para interações futuras
    setTimeout(() => {
        body.classList.add('is-ready');
        document.documentElement.classList.remove('menu-is-closed-instant');
    }, 150); // Um delay leve para garantir que o frame inicial já foi desenhado

    // --- 3. EVENTOS DE INTERAÇÃO (ESTES TERÃO ANIMAÇÃO) ---
    btn.addEventListener('click', () => {
        const currentlyClosed = menu.classList.contains('is-closed');
        applyMenuState(!currentlyClosed, true);
    });

    window.addEventListener('scroll', () => {
        if (window.innerWidth < 782) return;
        const currentScroll = window.scrollY;
        const stateInStorage = localStorage.getItem('menuStatus');

        // Fecha no scroll (animado, pois is-ready já estará presente)
        if (currentScroll > 80 && !menu.classList.contains('is-closed')) {
            applyMenuState(true, true);
        } 
        
        // Abre no scroll (se não foi fechado manualmente)
        if (currentScroll <= 10 && menu.classList.contains('is-closed') && stateInStorage !== 'closed') {
            applyMenuState(false, true);
        }
    }, { passive: true });
});