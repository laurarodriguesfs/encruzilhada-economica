<?php get_header('full'); ?>

<section id="primary" class="content-area">
	<main id="main" class="site-main tainacan-container">
            
        <h1>Coleções</h1>

        <div class="tainacan-collection-grid">
            <?php get_template_part('partes-templates/loop-tainacan-collection', 'grid'); ?>
        </div>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer('full'); ?>