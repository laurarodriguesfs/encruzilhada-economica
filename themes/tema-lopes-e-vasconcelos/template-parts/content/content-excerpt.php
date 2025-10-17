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
            // Exibe as categorias (Assunto)
            echo '<span class="cat-links">' . get_the_category_list( ', ' ) . '</span>';

            // Pega os termos da taxonomia "formato"
            $format_terms = get_the_term_list( get_the_ID(), 'formato', '', ', ' );

            // Se houver formatos, exibe eles com um separador
            if ( ! empty( $format_terms ) ) {
                if ( has_category() ) {
                    echo '<span class="meta-separator"> </span>';
                }
                echo '<span class="format-links">' . $format_terms . '</span>';
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