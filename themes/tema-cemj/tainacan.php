<?php
/**
 * Template para páginas do Tainacan
 */
get_header();
?>

<main id="tainacan-template">
    <div class="tainacan-container">
        <?php
        while (have_posts()) : the_post();
            the_content(); // Mantém os blocos e interface do Tainacan
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
