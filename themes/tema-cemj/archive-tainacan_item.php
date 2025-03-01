<?php
/**
 * Template para listagem de itens do Tainacan
 */
get_header();
?>

<main id="tainacan-items">
    <div class="tainacan-container">
        <?php
        while (have_posts()) : the_post();
            the_content(); // Exibe os blocos do Tainacan corretamente
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
