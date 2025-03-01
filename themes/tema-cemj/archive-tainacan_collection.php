<?php
/**
 * Template para listagem de coleções do Tainacan
 */
get_header();
?>

<main id="tainacan-collections">
    <div class="tainacan-container">
        <?php
        while (have_posts()) : the_post();
            the_content(); // Mantém os blocos do Tainacan
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
