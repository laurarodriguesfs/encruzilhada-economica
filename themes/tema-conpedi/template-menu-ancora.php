<?php
get_header();
/**
 * Template Name: Menu Âncora
*/
?>

	<section id="primary" class="content-area">

		<header class="page-header">

		</header><!-- .page-header -->

		<?php do_action( 'before_archive_posts' ); ?>

		<main id="main" class="site-main">

 		<?php

		the_content();

		?>
		</div>
		</main><!-- #main -->
		<?php
		$archive_layout = get_theme_mod( 'archive_layout', 'default' );
		if ( 'default' === $archive_layout ) {
			get_sidebar();
		}
		?>
	</section><!-- #primary -->


<?php get_footer();
