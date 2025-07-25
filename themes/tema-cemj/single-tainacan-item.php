<?php
/**
 * Template para exibir um item específico do Tainacan
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tema-cemj
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                // Exibir o conteúdo do item
                ?>
                <div class="item-detail">
                    <h1><?php the_title(); ?></h1>
                    <div class="item-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
            endwhile;
        else :
            echo '<p>' . __('Item não encontrado.', 'seu-tema') . '</p>';
        endif;
        ?>
    </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();