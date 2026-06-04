document.addEventListener('DOMContentLoaded', function() {
    const blocoNewspack = document.querySelector('.wp-block-newspack-blocks-homepage-articles');

    if (blocoNewspack) {
        // Encontra todos os artigos dentro do bloco Newspack
        const artigos = blocoNewspack.querySelectorAll('article');

        artigos.forEach(article => {
            // 1. Encontra a div onde as categorias estão
            const catLinksContainer = article.querySelector('.cat-links');
            
            // 2. Procura a classe 'formato-' no artigo
            const classes = article.className.split(' '); 
            let formatoClass = null;

            // Percorre as classes para encontrar a que começa com 'formato-'
            for (let i = 0; i < classes.length; i++) {
                if (classes[i].startsWith('formato-')) {
                    formatoClass = classes[i];
                    break;
                }
            }

            // Se encontrarmos o formato e o container da categoria existir
            if (formatoClass && catLinksContainer) {
                // Remove o prefixo 'formato-' e substitui '-' por espaço
                let termoFormato = formatoClass.replace('formato-', '').replace(/-/g, ' ');
                
                // Capitaliza a primeira letra (Artigo, Ebook, etc.)
                termoFormato = termoFormato.charAt(0).toUpperCase() + termoFormato.slice(1);

                // Pega o URL da categoria existente para usar no link do formato
                const linkCategoriaExistente = catLinksContainer.querySelector('a');
                const urlFormato = linkCategoriaExistente ? linkCategoriaExistente.href : '#';

                // Cria o novo elemento HTML para o formato
                const formatoHTML = `
                    <a href="${urlFormato}" class="formato-link-injecao">${termoFormato}</a>
                    <span class="formato-separator-injecao">&nbsp;</span>
                `;

                // Injeta o HTML antes do conteúdo existente no .cat-links
                catLinksContainer.insertAdjacentHTML('afterbegin', formatoHTML);
            }
        });
    }
});