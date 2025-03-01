<?php
get_header();
?>

<main id="tainacan-taxonomy-tag">
    <header class="page-header">
        <h1 class="page-title">
            <?php single_term_title(); ?>
        </h1>
        <?php if (term_description()) : ?>
            <div class="taxonomy-description">
                <?php echo term_description(); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="tainacan-items-list">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('Nenhum item encontrado com esta tag.', 'seu-tema'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
?>
