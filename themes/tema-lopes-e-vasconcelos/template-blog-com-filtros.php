<?php
/**
 * Template Name: Blog com Filtros Personalizados
 * Description: Template customizado para a página de blog com filtros AJAX.
 */

// A lista de Formato agora é apenas informativa, não de exclusão
$format_slugs_to_include = array( 'opiniao', 'noticia', 'artigo' ); 

// 1. Obtém as categorias de ASSUNTO (Dynamicamente TODAS as categorias exceto 'sem-categoria' - NENHUMA EXCLUSÃO POR SLUG)
$subject_categories = get_categories( array(
    'taxonomy'   => 'category', // Taxonomia Padrão
    'orderby'    => 'name',
    'exclude'    => array( 'sem-categoria' ), // Exclui APENAS o slug padrão
    'hide_empty' => true,
) );

// 2. Obtém as categorias de FORMATO (Totalmente Separada)
$format_categories = get_categories( array(
    'taxonomy'   => 'formato', // <--- NOVA TAXONOMIA
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
                    
                    <?php 
                    // Se você criar uma nova categoria, ela aparecerá aqui.
                    foreach ( $subject_categories as $category ) : 
                    ?>
                        <button class="filter-button" data-term="<?php echo esc_attr( $category->slug ); ?>">
                            <?php echo esc_html( $category->name ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h3>por formato</h3>
                <div class="filter-group" data-taxonomy="formato"> <button class="filter-button" data-term="">Todos os Formatos</button>
                    
                    <?php 
                    foreach ( $format_categories as $format_term ) : 
                    ?>
                        <button class="filter-button" data-term="<?php echo esc_attr( $format_term->slug ); ?>">
                            <?php echo esc_html( $format_term->name ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div id="posts-list-container" class="posts-grid-layout">
            <?php
            lv_render_posts(); 
            ?>
        </div>

    </main>
</div>

<?php get_footer(); ?>