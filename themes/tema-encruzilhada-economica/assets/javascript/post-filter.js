jQuery(document).ready(function($) {
    var $postsContainer = $('#posts-list-container');
    var $filterGroups = $('.custom-filters-container .filter-group');
    
    // Objeto para manter o controle dos termos ativos por taxonomia.
    var activeFilters = {}; 

    // Inicialização: Marca o botão 'Todos' como ativo em cada grupo ao carregar.
    $filterGroups.each(function() {
        $(this).find('.filter-button[data-term=""]').addClass('active');
    });

    $('.filter-button').on('click', function(e) {
        e.preventDefault();
        var $button = $(this);
        var taxonomy = $button.closest('.filter-group').data('taxonomy'); 
        var termSlug = $button.data('term');     

        // 1. Gerencia a classe 'active'
        $button.siblings('.filter-button').removeClass('active');
        $button.addClass('active');

        // 2. Atualiza o objeto activeFilters
        if (termSlug) {
            activeFilters[taxonomy] = termSlug;
        } else {
            // Remove o filtro para essa taxonomia se for o botão 'Todos'
            delete activeFilters[taxonomy]; 
        }

        // 3. Converte o objeto activeFilters em um array para enviar via AJAX
        var filtersToSend = [];
        for (var tax in activeFilters) {
            if (activeFilters.hasOwnProperty(tax) && activeFilters[tax]) {
                filtersToSend.push({
                    taxonomy: tax,
                    term: activeFilters[tax]
                });
            }
        }

        // 4. Prepara os dados para o AJAX
        var data = {
            action: 'lv_filter_posts',
            nonce: lv_ajax.nonce,
            filters: filtersToSend 
        };

        // 5. Efeito de carregamento
        $postsContainer.fadeTo('fast', 0.5);

        // 6. Chamada AJAX
        $.ajax({
            url: lv_ajax.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    $postsContainer.html(response.data.html);
                } else {
                    $postsContainer.html('<p>Ocorreu um erro ao carregar os posts.</p>');
                }
                $postsContainer.fadeTo('fast', 1.0);
            },
            error: function() {
                $postsContainer.html('<p>Erro de comunicação com o servidor.</p>').fadeTo('fast', 1.0);
            }
        });
    });
});