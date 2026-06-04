<?php
/**
 * Template Name: One column wide
 * * Template Post Type: post, page, item_da_agenda, dado_ou_evidencia, dossie, livro_ou_resenha, publicacao_ou_analis, video_ou_podcast
 *
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Newspack
 */

get_header();
?>

	<section id="primary" class="content-area <?php echo esc_attr( newspack_get_category_tag_classes( get_the_ID() ) ); ?>">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				?>
					<header class="entry-header">
						<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
					</header>

				<div class="main-content">

					<?php
					if ( is_active_sidebar( 'article-1' ) ) {
						dynamic_sidebar( 'article-1' );
					}

					// A CHAMADA DA IMAGEM FOI REMOVIDA DESTA ÁREA.

					get_template_part( 'template-parts/content/content-single', 'single' );
					// ... (resto do código)

					newspack_previous_next();

					?>
				</div><!-- .main-content -->

			<?php
				endwhile;
				get_sidebar();
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
