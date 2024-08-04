<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) {

			// Load posts loop.
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/content', 'excerpt' );
			}

			?>

			<div class="pagination-posts">
				<?php
					$args = array(
						'show_all' => false, // all pages involved in pagination are shown
						'end_size' => 1,     // number of pages at the ends
						'mid_size' => 1,     // number of pages around the current page
						'prev_next' => true, // whether to display 'previous/next page' side links.
						'prev_text' => 'PREV',
						'next_text' => 'NEXT',
						'add_args' => false,  // Array of arguments (query variables) to add to links.
						'add_fragment' => '', // Text to be added to all links.
						'screen_reader_text' => __('Posts navigation' ),
					);

				the_posts_pagination($args);

				?>
			</div>
			<?

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );

		}
		?>

		</main><!-- .site-main -->
		<?php get_sidebar(); ?>
	</section><!-- .content-area -->

<?php
get_footer();
