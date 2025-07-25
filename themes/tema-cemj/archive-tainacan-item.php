<?php
/**
 * Template para página de arquivo de itens do Tainacan
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tema-cemj
 */

get_header(); ?>


<section id="primary" class="content-area">
    <header class="page-header">
        <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
    </header><!-- .page-header -->

    <main id="main" class="site-main">
        <?php
        $query = new WP_Query(array(
            'post_type' => 'tainacan-item',
            'posts_per_page' => 10
        ));
        
        if (!$query->have_posts()) {
            echo '<p>⚠️ Nenhum item encontrado na coleção.</p>';
        }
        
        if (have_posts()) :
            while (have_posts()) : the_post();
                // Exibir cada item
                ?>
                <div class="item">
                    <h2><?php the_title(); ?></h2>
                    <div class="item-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more">Leia mais</a>
                </div>
                <?php
            endwhile;

            // Paginação
            the_posts_pagination();
        else :
            echo '<p>' . __('Nenhum item encontrado.', 'seu-tema') . '</p>';
        endif;
        ?>
    </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
