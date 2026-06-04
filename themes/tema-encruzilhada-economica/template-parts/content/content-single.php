<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

// Get sponsors for this taxonomy archive.
if ( function_exists( 'newspack_get_all_sponsors' ) ) {
	$all_sponsors         = newspack_get_all_sponsors(
		get_the_id(),
		null,
		'post',
		[
			'maxwidth'  => 150,
			'maxheight' => 100,
		]
	);
	$native_sponsors      = newspack_get_native_sponsors( $all_sponsors );
	$underwriter_sponsors = newspack_get_underwriter_sponsors( $all_sponsors );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">

		<?php
		if ( ! empty( $underwriter_sponsors ) ) :
			newspack_sponsored_underwriters_info( $underwriter_sponsors );
		endif;
		?>

		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'newspack' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);


		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'newspack' ),
				'after'  => '</div>',
			)
		);

		if ( is_active_sidebar( 'article-2' ) && is_single() ) {
			dynamic_sidebar( 'article-2' );
		}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php newspack_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'page' ) ) : ?>
		<div class="author-box-container">
			<div class="author-image">
				<?php 
				$author_id = get_the_author_meta('ID');
				$pod = pods( 'user', $author_id );
				$author_avatar_url = $pod->display( 'foto_do_autor' ); 
					
				if ( empty($author_avatar_url) ) {
					$author_avatar_url = get_avatar_url($author_id, ['size' => 250]);
				}

				if ( strpos($author_avatar_url, '<img') !== false ) {
					echo $author_avatar_url;
				} else {
					echo '<img src="' . esc_url($author_avatar_url) . '" alt="' . get_the_author() . '">';
				}
				?>
			</div>

			<div class="author-info">
				<h3 class="author-name"><?php the_author(); ?></h3>
				<p class="author-description"><?php the_author_meta( 'description' ); ?></p>
				<a href="<?php echo get_author_posts_url( $author_id ); ?>" class="author-more-link">
					Ler mais de <?php echo esc_html(explode(' ', get_the_author())[0]); ?>
				</a>
			</div>
		</div>
	<?php endif; ?>

</article><!-- #post-${ID} -->
