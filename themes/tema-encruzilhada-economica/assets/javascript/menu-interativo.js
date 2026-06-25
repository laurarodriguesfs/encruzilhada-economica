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

    // Função auxiliar para abrir/fechar todas as listas internas de uma vez
    function toggleAllSubmenus(open) {
        const sublists = menu.querySelectorAll('.menu-list');
        const titles = menu.querySelectorAll('.menu-title');
        
        sublists.forEach(list => {
            if (open) list.classList.add('is-open');
            else list.classList.remove('is-open');
        });

        titles.forEach(title => {
            if (open) title.classList.add('is-active');
            else title.classList.remove('is-active');
        });
    }

    // Verifica se sobrou alguma lista aberta. Se não, fecha o menu geral
    function checkActiveMenus() {
        const anyOpen = menu.querySelectorAll('.menu-list.is-open').length > 0;
        
        // Se nenhuma lista estiver aberta, fecha o container do menu principal
        if (!anyOpen && !menu.classList.contains('is-closed')) {
            applyMenuState(true, true);
        }
    }

    function applyMenuState(isClosed, save = true) {
        if (isClosed) {
            menu.classList.add('is-closed');
            body.classList.add('menu-is-closed');
            primary?.classList.add('menu-is-closed');
            toggleAllSubmenus(false);
        } else {
            menu.classList.remove('is-closed');
            body.classList.remove('menu-is-closed');
            primary?.classList.remove('menu-is-closed');
            toggleAllSubmenus(true);
        }

        if (save) {
            localStorage.setItem('menuStatus', isClosed ? 'closed' : 'open');
        }
        updateButtonText();

        // Roda imediatamente e monitora durante a transição do CSS
        loopAjustarMargem(350);
    }

    // --- 1. INICIALIZAÇÃO SILENCIOSA (SEM ANIMAÇÃO) ---
    const savedState = localStorage.getItem('menuStatus');
    const isMobile = window.innerWidth < 782;

    if (isMobile || savedState === 'closed') {
        applyMenuState(true, false);
    } else {
        applyMenuState(false, false);
    }

    // --- 2. O TRUQUE: LIBERAR ANIMAÇÕES APÓS O RENDER ---
    setTimeout(() => {
        body.classList.add('is-ready');
        document.documentElement.classList.remove('menu-is-closed-instant');
        ajustarMargemDinamica(); // Garante o cálculo perfeito inicial
    }, 150);

    // --- 3. EVENTOS DE INTERAÇÃO (ESTES TERÃO ANIMAÇÃO) ---
    btn.addEventListener('click', () => {
        const currentlyClosed = menu.classList.contains('is-closed');
        applyMenuState(!currentlyClosed, true);
    });

    // --- 4. FUNÇÃO PARA CONTROLAR CADA MENU INDIVIDUALMENTE ---
    function setupMenuToggle(columnSelector) {
        const column = document.querySelector(columnSelector);
        if (!column) return;

        const title = column.querySelector('.menu-title');
        const list = column.querySelector('.menu-list');

        if (!title || !list) return;

        title.addEventListener('click', (e) => {
            // Se o mega menu geral estiver fechado, abre ele e expande apenas esta lista
            if (menu.classList.contains('is-closed')) {
                e.preventDefault();
                
                menu.classList.remove('is-closed');
                body.classList.remove('menu-is-closed');
                primary?.classList.remove('menu-is-closed');
                localStorage.setItem('menuStatus', 'open');
                updateButtonText();

                list.classList.add('is-open');
                title.classList.add('is-active');
                
                loopAjustarMargem(350);
                return;
            }

            // Se o mega menu já estiver aberto, alterna apenas este submenu atual
            e.preventDefault();
            list.classList.toggle('is-open');
            title.classList.toggle('is-active');

            // Executa a checagem após fechar uma lista individualmente
            checkActiveMenus();

            // Roda o monitoramento da altura durante a transição fluida
            loopAjustarMargem(350);
        });
    }

    // Ativa o evento mapeando pelas classes específicas que colocamos no PHP
    setupMenuToggle('.col-conteudo');
    setupMenuToggle('.col-eixos');

    // --- 5. COMPORTAMENTO DE SCROLL ---
    window.addEventListener('scroll', () => {
        if (window.innerWidth < 782) return;
        const currentScroll = window.scrollY;
        const stateInStorage = localStorage.getItem('menuStatus');

        if (currentScroll > 80 && !menu.classList.contains('is-closed')) {
            applyMenuState(true, true);
        } 
        
        if (currentScroll <= 10 && menu.classList.contains('is-closed') && stateInStorage !== 'closed') {
            applyMenuState(false, true);
        }
    }, { passive: true });

    // Recalcula se o usuário virar o celular ou mudar o tamanho da janela do navegador
    window.addEventListener('resize', ajustarMargemDinamica);
});

// Função que força o cálculo baseado APENAS no menu fechado
function ajustarMargemDinamica() {
    const masthead = document.getElementById('masthead');
    const primary = document.querySelector('section#primary');
    const menu = document.getElementById('megaMenu');
    
    if (!masthead || !primary || !menu) return;

    // 1. Guardamos o estado atual real do menu para não perdê-lo
    const menuEstavaFechado = menu.classList.contains('is-closed');
    
    // Pegamos todas as listas e títulos internos para checar se algum estava aberto individualmente
    const listasAbertas = [];
    const titulosAtivos = [];
    menu.querySelectorAll('.menu-list').forEach((list, index) => {
        if (list.classList.contains('is-open')) listasAbertas.push(index);
    });
    menu.querySelectorAll('.menu-title').forEach((title, index) => {
        if (title.classList.contains('is-active')) titulosAtivos.push(index);
    });

    // 2. TRUQUE: Forçamos temporariamente o menu a ficar 100% FECHADO para o navegador medir
    menu.classList.add('is-closed');
    menu.querySelectorAll('.menu-list').forEach(list => list.classList.remove('is-open'));
    menu.querySelectorAll('.menu-title').forEach(title => title.classList.remove('is-active'));

    // 3. MEDIÇÃO REAL: Pegamos a altura exata do cabeçalho com tudo fechado
    let alturaComMenuFechado = masthead.offsetHeight;

    // 4. Aplicamos os ajustes finos matemáticos que você pediu sobre a altura limpa calculada
    if (window.innerWidth < 782) {
        // No mobile, se a altura limpa calculada ainda vier com folga, aproximamos dos 200px
        if (alturaComMenuFechado > 220 || alturaComMenuFechado < 150) {
            alturaComMenuFechado = 200;
        }
    } else {
        // No desktop, se a altura limpa calculada vier perto de 250px, aproximamos dos 220px
        if (alturaComMenuFechado > 230) {
            alturaComMenuFechado = 220;
        }
    }

    // Aplicamos o valor final cravado no #primary
    primary.style.marginTop = alturaComMenuFechado + 'px';

    // 5. RESTAURAÇÃO: Devolvemos o menu exatamente ao estado em que ele estava antes da medição
    if (!menuEstavaFechado) {
        menu.classList.remove('is-closed');
    }
    
    // Devolve o estado das setas/listas individuais
    const allLists = menu.querySelectorAll('.menu-list');
    listasAbertas.forEach(index => allLists[index]?.classList.add('is-open'));
    
    const allTitles = menu.querySelectorAll('.menu-title');
    titulosAtivos.forEach(index => allTitles[index]?.classList.add('is-active'));
}

// Desativamos o monitoramento frame a frame! 
// Agora ele só roda uma vez cirurgicamente quando solicitado, sem dar trancos.
function loopAjustarMargem(duracao) {
    // Apenas executa o cálculo exato uma vez no momento da ação
    ajustarMargemDinamica();
}