<?php get_header('full'); ?>

<?php
$collection = tainacan_get_collection(); // Obtém a coleção atual
?>
<section id="primary" class="content-area">
	<main id="main" class="site-main">
            
        <?if ($collection): ?>
            <div class="tainacan-collection-description-especial">
                <h1><?php echo esc_html($collection->get_name()); ?></h1>
                <p><?php echo wp_kses_post($collection->get_description()); ?></p>
            </div>
        <?php endif; ?>

        <?php get_template_part('tainacan/header-collection'); ?>

       

    </main><!-- #main -->
</section><!-- #primary -->

<?php tainacan_the_faceted_search(); ?>

<?php get_footer('full'); ?>