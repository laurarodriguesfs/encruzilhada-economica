document.addEventListener('DOMContentLoaded', () => {
    // 1. VARIÁVEIS DE SELEÇÃO E CONTROLE
    const tabLinks = document.querySelectorAll('.tab-link');
    const initialMessage = document.querySelector('.initial-message'); 
    
    // Seleciona a área de conteúdo azul (destino do scroll para 'Ver mais')
    const areaConteudo = document.querySelector('.wp-block-column.is-vertically-aligned-center .wp-block-cover');
    
    // Seleciona o destino do scroll para 'Voltar à Lista'
    const elementoTopo = document.getElementById('topo-servicos'); 
    const botoesVoltar = document.querySelectorAll('.voltar-a-lista-btn');

    // **Media Query para mobile (Scroll condicional)**
    const mobileBreakpoint = 768; 
    const isMobile = window.matchMedia(`(max-width: ${mobileBreakpoint - 1}px)`); 

    if (tabLinks.length === 0) {
        if (initialMessage) {
            initialMessage.style.display = 'block';
        }
        return;
    }

    // --- FUNÇÃO PARA GARANTIR O ESTADO DE LIMPEZA (RESET) ---
    const resetState = (shouldShowInitialMessage = false) => {
        tabLinks.forEach(link => {
            link.classList.remove('active');
            link.textContent = 'Ver mais →';
        });

        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.style.display = 'none';
        });
        
        if (initialMessage) {
            initialMessage.style.display = shouldShowInitialMessage ? 'block' : 'none';
        }
    };

    // --- 2. LÓGICA DE ABERTURA/FECHAMENTO DE ABAS E SCROLL ---
    tabLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const isCurrentlyActive = link.classList.contains('active');
            
            resetState(); 
            
            // LÓGICA DE FECHAMENTO
            if (isCurrentlyActive) {
                if (initialMessage) {
                     initialMessage.style.display = 'block'; 
                }
                return; 
            }

            // LÓGICA DE ABERTURA
            const targetClass = Array.from(link.classList).find(className => className.startsWith('tab-link-'));
            if (!targetClass) return;
            
            const targetName = targetClass.split('-')[2]; 
            const targetPane = document.querySelector(`.tab-pane-${targetName}`);
            
            link.classList.add('active'); 
            link.textContent = 'Ver menos x';
            
            if (targetPane) {
                targetPane.style.display = 'block'; 
            }
            
            // CONDICIONAL DE SCROLL (SÓ PARA MOBILE)
            if (areaConteudo && isMobile.matches) {
                areaConteudo.scrollIntoView({
                    behavior: 'smooth', 
                    block: 'start'      
                });
            }
        });
    });

    // --- 3. LÓGICA DO BOTÃO "VOLTAR À LISTA" ---
    if (botoesVoltar.length > 0 && elementoTopo) {
        botoesVoltar.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault(); 

                // Faz a rolagem suave para o topo da lista de serviços
                elementoTopo.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    }

    // --- 4. ESTADO INICIAL DA PÁGINA ---
    resetState(true); 
});