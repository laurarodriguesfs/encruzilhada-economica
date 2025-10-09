<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Newspack
 */

get_header();
?>

	<section id="primary" class="content-area">

		<header class="page-header">
			<h1 class="page-title">
				<?php esc_html_e( 'Search results', 'newspack' ); ?>
			</h1>
			<?php get_search_form(); ?>
		</header><!-- .page-header -->

		<main id="main" class="site-main">

		<?php if ( have_posts() ) :

			// check to see if there is a post type in the URL
			if ( isset( $_GET['post_type'] ) && $_GET['post_type'] ) {

				// save it for later
				$post_type = $_GET['post_type'];

				// check to see if a search template exists
				if ( locate_template( 'search-' . $post_type . '.php' ) ) {
					// load it and exit
					get_template_part( 'search', $post_type );
					exit;
				}

			}?>


			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content/content', 'excerpt' );

				// End the loop.
			endwhile;
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
			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>
		</main><!-- #main -->
		<?php get_sidebar(); ?>
	</section><!-- #primary -->

<?php
get_footer();
