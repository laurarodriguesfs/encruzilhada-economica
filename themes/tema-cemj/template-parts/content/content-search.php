<?php
/**
 * Template part for displaying search results (content-search.php)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

// ... (O código dos sponsors pode permanecer se você o usar) ...
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-container">

		<?php
		if ( has_post_thumbnail() ) :
		?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php the_post_thumbnail( 'thumbnail' ); ?>
				</a>
			</div>
		<?php
		endif;
		?>

		<div class="entry-text-wrapper">

			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header>

			<div class="entry-content the-excerpt">
				<?php the_excerpt(); ?>
			</div>

		</div>

	</div>

</article>