<?php
/**
 * Template Name: Blog com Filtros Personalizados
 * Description: Template customizado para a página de blog com filtros AJAX.
 */

// Obtém as categorias para os filtros
$subject_categories = get_categories( array(
    'taxonomy'   => 'category',
    'orderby'    => 'name',
    'exclude'    => array( 1 ), // Exclui a categoria "Sem categoria" (ID 1)
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
            // CÓDIGO FINAL: Carrega os posts iniciais de forma limpa.
            $initial_args = array(
                'post_type'        => 'post',
                'post_status'      => 'publish',
                'posts_per_page'   => get_option('posts_per_page'),
                'suppress_filters' => true, // Importante para evitar conflitos
            );
            $query = new WP_Query( $initial_args );

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post();
                    // Usamos o template part padrão do seu tema que sabemos que existe
					get_template_part( 'template-parts/content/content', 'excerpt' );
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div><?php
        // Exibe o botão "Carregar Mais" se houver mais páginas
        if ( $query->max_num_pages > 1 ) :
        ?>
            <div class="load-more-container">
                <button id="load-more-button" class="button"><?php _e( 'Carregar mais', 'newspack' ); ?></button>
            </div>
        <?php 
        endif;
        ?>

    </main>
</div>

<?php get_footer(); ?>