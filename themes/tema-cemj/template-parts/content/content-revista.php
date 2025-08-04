<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

// Get sponsors for this post.
if ( function_exists( 'newspack_get_all_sponsors' ) ) {
	$all_sponsors         = newspack_get_all_sponsors( get_the_id(), null, 'post' );
	$native_sponsors      = newspack_get_native_sponsors( $all_sponsors );
	$underwriter_sponsors = newspack_get_underwriter_sponsors( $all_sponsors );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<?php newspack_post_thumbnail( 'newspack-featured-image' ); ?>
	<?php else : 
		global $post;
   		$post_slug = $post->post_name;
		?>
		<figure class="post-thumbnail">
			<a class="post-thumbnail-inner" href="<?php echo get_permalink().$post_slug ?>">
				<img class= "attachment-newspack-featured-image size-newspack-featured-image wp-post-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default.png" alt="<?php the_title(); ?>">
			</a>
		</figure>
	<?php endif; ?>

	<div class="entry-container">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->
	</div><!-- .entry-container -->
</article><!-- #post-${ID} -->
