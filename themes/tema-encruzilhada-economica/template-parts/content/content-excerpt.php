<?php

if ( function_exists( 'newspack_get_all_sponsors' ) ) {
    $all_sponsors         = newspack_get_all_sponsors( get_the_id(), null, 'post' );
    $native_sponsors      = newspack_get_native_sponsors( $all_sponsors );
    $underwriter_sponsors = newspack_get_underwriter_sponsors( $all_sponsors );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <?php newspack_post_thumbnail( 'newspack-featured-image' ); ?>
    <?php endif; ?>

    <div class="entry-container">

        <div class="entry-meta">
            <?php
            // Pega todas as categorias vinculadas ao post
            $categorias = get_the_category();

            if ( ! empty( $categorias ) ) {
                // Exibe apenas a primeira categoria [0] com o link correto
                echo '<span class="cat-links">';
                echo '<a href="' . esc_url( get_category_link( $categorias[0]->term_id ) ) . '">' . esc_html( $categorias[0]->name ) . '</a>';
                echo '</span>';
            }
            ?>
        </div>
        <header class="entry-header">
            <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        </header>
        <div class="entry-content the-excerpt">
            <?php the_excerpt(); ?>
        </div>
    </div>
</article>