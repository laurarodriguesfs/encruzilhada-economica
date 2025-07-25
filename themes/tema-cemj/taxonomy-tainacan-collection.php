<?php
/**
 * Template para página de coleção específica no Tainacan
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
        // Query para mostrar os itens dentro da coleção
        $collection_id = get_queried_object_id();
        $args = array(
            'post_type' => 'tainacan-item',
            'posts_per_page' => 10,
            'meta_query' => array(
                array(
                    'key' => 'tainacan-collection',
                    'value' => $collection_id,
                    'compare' => '='
                )
            )
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
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
            the_posts_pagination();
        else :
            echo '<p>' . __('Nenhum item encontrado.', 'seu-tema') . '</p>';
        endif;
        wp_reset_postdata();
        ?>
    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>