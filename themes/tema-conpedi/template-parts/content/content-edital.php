<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

use Pods\REST\V1\Endpoints\Field;

// Get sponsors for this post.
if ( function_exists( 'newspack_get_all_sponsors' ) ) {
	$all_sponsors         = newspack_get_all_sponsors( get_the_id(), null, 'post' );
	$native_sponsors      = newspack_get_native_sponsors( $all_sponsors );
	$underwriter_sponsors = newspack_get_underwriter_sponsors( $all_sponsors );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php newspack_post_thumbnail( 'newspack-featured-image' ); ?>

	<div class="entry-container">
		<?php
		if ( 'page' !== get_post_type() ) :
			if ( ! empty( $native_sponsors ) ) :
				// Get label for native post sponsors.
				newspack_sponsor_label( $native_sponsors );
			else :
				newspack_categories();
			endif;
		endif;
		?>
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( ! is_page() ) : ?>
			<?php if ( ! empty( $native_sponsors ) ) : ?>
				<div class="entry-meta entry-sponsor">
					<?php newspack_sponsor_logo_list( $native_sponsors ); ?>
					<span>
						<?php
						newspack_sponsor_byline( $native_sponsors );
						newspack_posted_on();
						?>
					</span>
				</div>
			<?php else : ?>
				<div class="entry-meta">
					<?php
						newspack_posted_by();
						?>
				</div><!-- .meta-info -->
				<div class="entry-meta">
					<?php
						echo pods_field('edital',get_the_id(),'data_de_encerramento',true); ?>
				</div><!-- .meta-info -->
				<div class="entry-meta">
						<?php
						echo sprintf('<a class="button-visualizar" href="%s" rel="bookmark"> Visualizar', esc_url(pods_field('edital',get_the_id(),'link_pdf',true)), '</a>' ); ?>
			<?php endif; ?>
		<?php endif; ?>
	</div><!-- .entry-container -->
</article><!-- #post-${ID} -->
