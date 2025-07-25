<?php
/**
 * Template para página de categoria das coleções do Tainacan
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tema-cemj
 */

get_header(); ?>

<section id="primary" class="content-area">
    <header class="page-header">
        <h1 class="page-title"><?php single_term_title(); ?></h1>
    </header><!-- .page-header -->

    <main id="main" class="site-main">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                // Exibir cada item da categoria
                ?>
                <div class="category-item">
                    <h2><?php the_title(); ?></h2>
                    <div class="category-item-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more">Leia mais</a>
                </div>
                <?php
            endwhile;

            // Paginação
            the_posts_pagination();
        else :
            echo '<p>' . __('Nenhum item encontrado para esta categoria.', 'seu-tema') . '</p>';
        endif;
        ?>
    </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
