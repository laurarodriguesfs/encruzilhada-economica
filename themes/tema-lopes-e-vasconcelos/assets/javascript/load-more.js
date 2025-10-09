/**
 * Versão final e limpa do script "Carregar Mais".
 */
jQuery(function ($) {
  // Seleciona os elementos da página
  var button = $("#load-more-button");
  var container = $(load_more_params.container);
  // Se o botão ou o contêiner não existirem, não faz nada.
  if (!button.length || !container.length) {
    return;
  }

  // Guarda o texto original do botão para restaurá-lo depois
  var originalText = button.text();

  // Define a função de clique no botão
  button.on("click", function (e) {
    e.preventDefault();

    // Mostra um feedback visual e desabilita o botão para evitar cliques duplos
    button.text("Carregando...").prop("disabled", true);

    // Faz a chamada AJAX para o WordPress
    $.ajax({
      url: load_more_params.ajaxurl,
      type: "post",
      data: {
        action: "load_more_posts",
        page: load_more_params.current_page,
        query: load_more_params.query, // Chave correta
        nonce: load_more_params.nonce,
        template_part: load_more_params.template_part,
      },
      success: function (response) {
        // Se a resposta contiver posts (não for vazia)
        if (response.trim() !== "") { // Checagem mais segura
          // Adiciona os novos posts ao contêiner
          container.append(response);

          // Incrementa o contador da página para a próxima requisição
          load_more_params.current_page++;

          // Se a nova página for a última, esconde o botão
          if (load_more_params.current_page >= load_more_params.max_pages) {
            button.parent().hide(); // Esconde o div em volta do botão
          }
        } else {
          // Se a resposta for vazia, não há mais posts, então esconde o botão
          button.parent().hide(); // Esconde o div em volta do botão
        }
      },
      error: function () {
        // Em caso de erro na requisição, esconde o botão para evitar tentativas repetidas
        button.parent().hide(); // Esconde o div em volta do botão
        console.error("Erro ao carregar mais posts.");
      },
      complete: function () {
        // Esta função é executada sempre (em sucesso ou erro)
        // Restaura o botão ao seu estado original, caso ele ainda esteja visível
        if (button.is(":visible")) {
          button.text(originalText).prop("disabled", false);
        }
      }
    });
  });
});