<?php
/**
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

			if ( has_post_format( 'gallery' )) {
				echo 'Esta é uma galeria de imagens!';
 			}

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

					get_template_part( 'template-parts/content/content-single', 'single' );

					newspack_previous_next();?>

					<?php
					// Remova temporariamente o if do Newspack e force o nativo:
					echo "";
					comments_template();


					// Chama a nossa nova função para exibir os posts relacionados
                    exibir_posts_relacionados();

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
