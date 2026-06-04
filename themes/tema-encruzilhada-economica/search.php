<?php
/**
 * The template for displaying search results pages
 * @package Newspack
 */

get_header(); ?>

<section id="primary" class="content-area">
    <header class="page-header">
        <h1 class="page-title">
            <?php 
            if ( get_search_query() ) {
                printf( esc_html__( 'Resultados para: %s', 'newspack' ), '<span>' . get_search_query() . '</span>' );
            } else {
                esc_html_e( 'Busca', 'newspack' );
            }
            ?>
        </h1>
        <?php get_search_form(); ?>
    </header>

    <main id="main" class="site-main">

    <?php 
    // REMOVEMOS O BLOCO DO EXIT E DO POST_TYPE PARA TESTE
    if ( have_posts() ) : 

        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/content/content', 'excerpt' );
        endwhile;

        // Paginação
        the_posts_pagination( array(
            'prev_text' => 'PREV',
            'next_text' => 'NEXT',
        ) );

    else : ?>

        <div class="no-results not-found" style="padding: 50px 0; text-align: center; border: 1px dashed #ccc;">
            <h2 style="color: #333;">Lamentamos, nada foi encontrado.</h2>
            <p>Não encontramos nenhum conteúdo para sua pesquisa ou filtros selecionados.</p>
            <p>Tente pesquisar outros termos ou ajustar os filtros acima.</p>
        </div>

    <?php endif; ?>

    </main>
    <?php get_sidebar(); ?>
</section>

<?php get_footer(); ?>