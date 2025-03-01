<?php
get_header();
?>

<main id="tainacan-single-item">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <footer class="entry-footer">
                <p><?php esc_html_e('Publicado em:', 'seu-tema'); ?> <?php the_date(); ?></p>
                <p><?php esc_html_e('Coleção:', 'seu-tema'); ?> <?php echo get_the_terms(get_the_ID(), 'tainacan-collection')[0]->name; ?></p>
            </footer>
        </article>
    <?php endwhile; endif; ?>
</main>

<?php
get_footer();
?>
