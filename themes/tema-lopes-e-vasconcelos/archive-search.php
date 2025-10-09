<?php
/* Template Name: Custom Search */
get_header(); ?>


<section id="primary" class="content-area">

		<header class="page-header">
			<?php
				if ( is_author() ) {

					$queried       = get_queried_object();
					$author_avatar = '';

					if ( function_exists( 'coauthors_posts_links' ) ) {
						// Check if this is a guest author post type.
						if ( 'guest-author' === get_post_type( $queried->{ 'ID' } ) ) {
							// If yes, make sure the author actually has an avatar set; otherwise, coauthors_get_avatar returns a featured image.
							if ( get_post_thumbnail_id( $queried->{ 'ID' } ) ) {
								$author_avatar = coauthors_get_avatar( $queried, 120 );
							} else {
								// If there is no avatar, force it to return the current fallback image.
								$author_avatar = get_avatar( ' ' );
							}
						} else {
							$author_avatar = coauthors_get_avatar( $queried, 120 );
						}
					} else {
						$author_id     = get_query_var( 'author' );
						$author_avatar = get_avatar( $author_id, 120 );
					}

					if ( $author_avatar ) {
						echo wp_kses( $author_avatar, newspack_sanitize_avatars() );
					}
				}
			?>
			<span>

				<?php
				if ( ( is_category() || is_tag() ) && ! empty( $native_sponsors ) ) {
					// Get label for native archive sponsors.
					newspack_sponsor_label( $native_sponsors, null, true );
				}
				?>

				<h1 class="page-title">Encontre os projetos, artigos e relatórios que te interessam.</h1>

				<?php do_action( 'newspack_theme_below_archive_title' ); ?>


				<?php get_search_form(); ?>


				<?php
				if ( ( is_category() || is_tag() ) && ! empty( $native_sponsors ) ) :
					// Get description for native archive sponsors.
					newspack_sponsor_archive_description( $native_sponsors );
				elseif ( '' !== get_the_archive_description() ) :
					?>
				<div class="taxonomy-description">
					<?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?>
				</div>
				<?php endif; ?>

				<?php
				if ( ( is_category() || is_tag() ) && ! empty( $underwriter_sponsors ) ) {
					// Get info for underwriter archive sponsors.
					newspack_sponsored_underwriters_info( $underwriter_sponsors );
				}
			?>

				<?php if ( is_author() ) : ?>
					<div class="author-meta">
						<?php
							$author_email = get_the_author_meta( 'user_email', get_query_var( 'author' ) );
							if ( true === get_theme_mod( 'show_author_email', false ) && '' !== $author_email ) :
							?>
							<a class="author-email" href="<?php echo 'mailto:' . esc_attr( $author_email ); ?>">
								<?php echo wp_kses( newspack_get_social_icon_svg( 'mail', 18 ), newspack_sanitize_svgs() ); ?>
								<?php echo esc_html( $author_email ); ?>
							</a>
						<?php endif; ?>

						<?php newspack_author_social_links( get_the_author_meta( 'ID' ), 20 ); ?>
					</div><!-- .author-meta -->

					<?php do_action( 'newspack_theme_below_author_archive_meta' ); ?>

				<?php endif; ?>
			</span>

		</header><!-- .page-header -->
		<?php do_action( 'before_archive_posts' ); ?>
		<div class="header-search">
			<h3>Resultado da busca por: <?php echo htmlentities($s, ENT_QUOTES, 'UTF-8'); ?> </h3>
		</div>
		<main id="main" class="site-main">
			<div class="archive-posts-grid">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content/content', 'search' ); ?>
				<?php endwhile; ?>
				<?php endif;?>
				</div>
        </main><?php
// Exibe o botão "Carregar Mais" apenas se houver mais páginas a serem carregadas
global $wp_query;
if ( $wp_query->max_num_pages > 1 ) :
?>
 <div class="load-more-container">
    <button id="load-more-button" class="button"><?php _e( 'Carregar mais', 'newspack' ); ?></button>
    </div>
<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>