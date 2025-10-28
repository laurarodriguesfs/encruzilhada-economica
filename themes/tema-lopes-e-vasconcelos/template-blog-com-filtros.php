<?php
/**
 * Template Name: Blog com Filtros Personalizados
 * Description: Template customizado para a página de blog com filtros AJAX.
 */

// Obtém as categorias para os filtros
$subject_categories = get_categories( array(
    'taxonomy'   => 'category',
    'orderby'    => 'name',
    'exclude'    => array( 1 ),
    'hide_empty' => true,
) );

$format_categories = get_categories( array(
    'taxonomy'   => 'formato',
    'orderby'    => 'name',
    'hide_empty' => true,
) );

get_header(); 
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <header class="entry-header">
            <?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
        </header>
        
        <div class="custom-filters-container">
            <h2>Encontre o que você precisa usando os filtros:</h2>

            <div>
                <h3>por assunto</h3>
                <div class="filter-group" data-taxonomy="category">
                    <button class="filter-button active" data-term="">Todos</button> 
                    <?php foreach ( $subject_categories as $category ) : ?>
                        <button class="filter-button" data-term="<?php echo esc_attr( $category->slug ); ?>">
                            <?php echo esc_html( $category->name ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h3>por formato</h3>
                <div class="filter-group" data-taxonomy="formato">
                    <button class="filter-button active" data-term="">Todos os Formatos</button>
                    <?php foreach ( $format_categories as $format_term ) : ?>
                        <button class="filter-button" data-term="<?php echo esc_attr( $format_term->slug ); ?>">
                            <?php echo esc_html( $format_term->name ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div id="posts-list-container" class="posts-grid-layout">
            <?php
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            
            $initial_args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 6,
                'paged'          => $paged,
                'no_found_rows'  => false,
            );
            
            $custom_query = new WP_Query( $initial_args );
            $max_pages = $custom_query->max_num_pages;

            if ( $custom_query->have_posts() ) :
                while ( $custom_query->have_posts() ) : $custom_query->the_post();
                    get_template_part( 'template-parts/content/content', 'excerpt' );
                endwhile;
            else :
                echo '<p class="no-posts">Nenhum post encontrado.</p>';
            endif;
            
            wp_reset_postdata();
            ?>
        </div>
        
        <?php if ( $max_pages > 1 ) : ?>
            <div class="load-more-container">
                <button id="load-more-button" class="button" data-max-pages="<?php echo esc_attr( $max_pages ); ?>" data-current-page="1">
                    <?php _e( 'Carregar mais', 'newspack' ); ?>
                </button>
                <div id="loading-spinner" style="display: none;">Carregando...</div>
            </div>
        <?php endif; ?>

    </main>
</div>

<script type="text/javascript">
// DEBUG CORRIGIDO - sem erros
console.log('=== DEBUG BLOG FILTROS ===');
console.log('Taxonomia formato:', '<?php echo taxonomy_exists('formato') ? 'existe' : 'NÃO EXISTE'; ?>');
console.log('Categorias formato:', <?php echo count($format_categories); ?>);
console.log('Categorias assunto:', <?php echo count($subject_categories); ?>);

// Contar posts visíveis
function updatePostsDebug() {
    const posts = document.querySelectorAll('#posts-list-container article');
    const debugElement = document.getElementById('debug-posts-count');
    if (debugElement) {
        debugElement.textContent = `Posts: ${posts.length}`;
    }
    console.log('Posts encontrados no container:', posts.length);
}

// Inicializar quando DOM carregar
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado - iniciando debug...');
    updatePostsDebug();
    
    // Elementos críticos
    const postsContainer = document.getElementById('posts-list-container');
    const filterButtons = document.querySelectorAll('.filter-button');
    const loadMoreBtn = document.getElementById('load-more-button');
    
    console.log('Container de posts:', postsContainer ? 'OK' : 'NÃO ENCONTRADO');
    console.log('Botões de filtro:', filterButtons.length);
    console.log('Botão load more:', loadMoreBtn ? 'OK' : 'NÃO ENCONTRADO');
    
    // Observar mudanças nos posts
    if (postsContainer) {
        const postsObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    console.log('Container de posts modificado - atualizando contagem');
                    updatePostsDebug();
                }
            });
        });
        
        postsObserver.observe(postsContainer, { 
            childList: true, 
            subtree: true 
        });
    }
    
    // Testar cliques nos filtros
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const taxonomy = this.parentElement.dataset.taxonomy;
            const term = this.dataset.term;
            console.log('Filtro clicado:', taxonomy, term);
            document.getElementById('debug-ajax-status').textContent = `Filtro: ${taxonomy} - ${term}`;
        });
    });
});

// Verificar se há scripts externos com erro
window.addEventListener('error', function(e) {
    console.error('Erro global capturado:', e.error);
    document.getElementById('debug-ajax-status').textContent = 'ERRO JS: ' + e.message;
});
</script>

<?php get_footer(); ?>