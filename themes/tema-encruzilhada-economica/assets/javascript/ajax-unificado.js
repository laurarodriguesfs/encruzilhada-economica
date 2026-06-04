jQuery(function ($) {
    // --- Variáveis Globais e Seletores ---
    const button = $('#load-more-button');
    let container;
    
    if (typeof ajax_params === 'undefined') {
        return;
    }

    container = $(ajax_params.container);
    if (!button.length || !container.length) {
        return;
    }

    let currentPage = parseInt(ajax_params.current_page, 10);
    let maxPages = parseInt(ajax_params.max_pages, 10);
    const originalButtonText = button.text();

    let currentCategory = '';
    let currentFormat = '';

    if (currentPage >= maxPages) {
        button.parent().hide();
    }

    // --- Função Principal de AJAX ---
    function fetchPosts(isFiltering = false) {
        
        const pageToFetch = isFiltering ? 1 : currentPage + 1;

        button.text("Carregando...").prop('disabled', true);

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'post',
            data: {
                action: 'unificado_load_posts',
                nonce: ajax_params.nonce,
                page: pageToFetch,
                query: ajax_params.initial_query,
                template_part: ajax_params.template_part,
                category: currentCategory,
                formato: currentFormat,
            },
            success: function (response) {
                // MUDANÇA 1: Verificar se a requisição foi um sucesso e se temos dados
                if ( response.success && response.data ) {
                    const newHtml = response.data.html;
                    const newMaxPages = parseInt(response.data.max_pages, 10);

                    if (isFiltering) {
                        container.html(newHtml);
                        maxPages = newMaxPages; // MUDANÇA 2: Atualiza o maxPages global
                    } else {
                        container.append(newHtml);
                    }

                    currentPage = pageToFetch;

                    // MUDANÇA 3: Nova lógica para esconder o botão
                    if (currentPage >= maxPages || newHtml.trim() === '') {
                        button.parent().hide();
                    } else {
                        button.parent().show();
                    }
                }
            },
            error: function () {
                button.parent().html('<p>Ocorreu um erro.</p>');
            },
            complete: function () {
                if (currentPage < maxPages) {
                    button.text(originalButtonText).prop('disabled', false);
                }
            }
        });
    }

    // --- Event Listeners (permanecem os mesmos) ---
    button.on('click', function (e) {
        e.preventDefault();
        fetchPosts(false);
    });

    if (ajax_params.is_filter_page) {
        $('.filter-button').on('click', function (e) {
            e.preventDefault();
            const $thisButton = $(this);
            const $group = $thisButton.closest('.filter-group');
            const taxonomy = $group.data('taxonomy');
            const term = $thisButton.data('term');

            $group.find('.filter-button').removeClass('active');
            $thisButton.addClass('active');

            if (taxonomy === 'category') {
                currentCategory = term;
            } else if (taxonomy === 'formato') {
                currentFormat = term;
            }

            fetchPosts(true);
        });
    }
});