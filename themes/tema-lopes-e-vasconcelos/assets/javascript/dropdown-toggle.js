document.querySelectorAll('.tainacan-dropdown-btn').forEach(function(dropdown) {
    dropdown.addEventListener('click', function(event) {
        // Evitar que o clique no dropdown se propague
        event.stopPropagation();
        // Alterna a classe 'open' para mostrar/ocultar o menu
        this.closest('.tainacan-dropdown').classList.toggle('open');
    });
});

// Fecha o dropdown ao clicar fora dele
document.addEventListener('click', function(event) {
    document.querySelectorAll('.tainacan-dropdown').forEach(function(dropdown) {
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('open');
        }
    });
});
