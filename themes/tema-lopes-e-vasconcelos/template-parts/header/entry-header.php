<?php
/**
 * Displays the post header
 *
 * @package Newspack
 */

$discussion = ! is_page() && newspack_can_show_post_thumbnail() ? newspack_get_discussion_data() : null;

if ( function_exists( 'newspack_get_all_sponsors' ) ) {
    $all_sponsors         = newspack_get_all_sponsors( get_the_id() );
    $native_sponsors      = newspack_get_native_sponsors( $all_sponsors );
    $underwriter_sponsors = newspack_get_underwriter_sponsors( $all_sponsors );
}

$page_hide_title = get_post_meta( $post->ID, 'newspack_hide_page_title', true );

$subtitle = get_post_meta( $post->ID, 'newspack_post_subtitle', true );
?>

<div class="entry-header-inner">
    <?php if ( is_singular() ) : ?>
        <?php
        if ( ! is_page() ) :
            if ( ! empty( $native_sponsors ) ) {
                newspack_sponsor_label( $native_sponsors, null, true );
            } else {
                echo sprintf(
                    '<div class="categoria-e-formato-wrapper">'
                );
                
                $formato_terms = get_the_terms( get_the_ID(), 'formato' ); 

                if ( $formato_terms && ! is_wp_error( $formato_terms ) ) {
                    $first_term = is_array( $formato_terms ) ? reset( $formato_terms ) : $formato_terms;
                    
                    if ( is_object( $first_term ) ) {
                        $term_link = get_term_link( $first_term->term_id, 'formato' );
                        
                        if ( ! is_wp_error( $term_link ) ) {
                            echo sprintf(
                                '<span class="cat-links"><a href="%1$s" class="formato-link">%2$s</a><span class="formato-separator">&nbsp;</span></span>',
                                esc_url( $term_link ),
                                esc_html( $first_term->name )
                            );
                        }
                    }
                }
                
                newspack_categories();

                 echo sprintf(
                    '</div>'
                );
                
            }
        endif;
        ?>
        <?php if ( ! $page_hide_title ) : ?>
            <h1 class="entry-title <?php echo $subtitle ? 'entry-title--with-subtitle' : ''; ?>">
                <?php echo wp_kses_post( get_the_title() ); ?>
            </h1>
        <?php endif; ?>
        <?php if ( $subtitle ) : ?>
            <div class="newspack-post-subtitle">
                <?php echo esc_html( $subtitle ); ?>
            </div>
        <?php endif; 
        if ( has_excerpt() ) : ?>
            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark">
                <?php echo wp_kses_post( get_the_title() ); ?>
            </a>
        </h2>
    <?php endif; ?>
</div>