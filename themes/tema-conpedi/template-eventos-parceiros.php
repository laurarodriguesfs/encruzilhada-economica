<?php
get_header();
/**
 * Template Name:  Archive de eventos de parceiros
*/

$paged = (isset($_GET["pagina"]) && !empty($_GET["pagina"])) ? absint($_GET["pagina"]): 1;
$hide_empty  = false;
$orderby     = 'id';
$order       = 'DESC';
$per_page= 9;
$offset      = ($paged - 1) * $per_page;

 if (isset($_GET['order']) && !empty($_GET['order'])) {

	$filter_order = sanitize_title($_GET['order']);

	if ($filter_order == 'title_asc') {
		$orderby = 'title';
		$order   = 'ASC';
	} elseif ($filter_order == 'title_desc') {
		$orderby = 'title';
		$order   = 'DESC';
	} elseif ($filter_order == 'date_desc') {
		$orderby = 'term_id';
		$order   = 'DESC';
	} elseif ($filter_order == 'date_asc') {
		$orderby = 'term_id';
		$order   = 'ASC';
	}
}

 $eventos_posts = new WP_Query( array(
	'post_type'		=> 'hotsite-parceiros',
    'no_found_rows' => true,
	'number'     => $per_page,
	'offset'     => $offset,
	'orderby'    => $orderby,
	'order'      => $order,
	'hide_empty' => $hide_empty,
	'tax_query' => array(
		array(
			'taxonomy' => 'category', //double check your taxonomy name in you dd
			'field'    => 'id',
			'terms'    => 35,
			'operator' => 'NOT IN',
		),
	   ),
	)
 );

 $count_posts = wp_count_posts( $post_type = 'hotsite-parceiros' );

 if ( $count_posts ) {
	 $published_posts = $count_posts->publish;
 }

 $cat_id = 35;
 $post_type = 'hotsite-parceiros';
 $args = array(
	 'category' => $cat_id,
	 'post_type' => $post_type,
 );

$count_posts_cat = get_posts( $args );
$total_posts_cat = count($count_posts_cat);

$total_published_posts = $published_posts - $total_posts_cat;


$feature_latest_post = get_theme_mod( 'archive_feature_latest_post', true );
$show_excerpt        = get_theme_mod( 'archive_show_excerpt', false );
?>

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

				<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

				<?php do_action( 'newspack_theme_below_archive_title' ); ?>

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

		<main id="main" class="site-main">

 		<?php

		the_content();

		?>
		<div class="archive-session">
		<?
		if ( $eventos_posts->have_posts() ) :
			$post_count = 0;

			// Start the Loop.
			while ( $eventos_posts->have_posts() ) :
				$post_count++;
				$eventos_posts->the_post();

				// Check if you're on the first post of the first page and if it should be styled differently, or if excerpts are enabled.
				if ( ( 1 === $post_count && 0 === get_query_var( 'paged' ) && true === $feature_latest_post ) || true === $show_excerpt ) {
					get_template_part( 'template-parts/content/content', 'evento' );
				} else {
					get_template_part( 'template-parts/content/content', 'evento' );
				}

				// End the loop.
			endwhile;

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>
		</div>
		</main><!-- #main -->
		<div class="pagination-posts">
		<div class="navigation pagination">
					<div class="nav-links">
						<?php

						$total_pages = intval($total_published_posts / $per_page) + 1;

						$arrow_icon = file_get_contents( get_template_directory_uri() . '../assets/images/menu-arrow.svg' );
						echo paginate_links([
							'base'      => add_query_arg('pagina','%#%'),
							'format'    => '?pagina=%#%',
							'total'     => $published_posts / $per_page,
							'current'   => $paged,
							'total'     => $total_pages,
							'mid_size'  => 2,
							'prev_text' => 'PREV',
							'next_text' => 'NEXT',
							'show_all'  => TRUE,
						]);

						if($paged==$total_pages+1):echo paginate_links([
							'base'      => add_query_arg('pagina','%#%'),
							'format'    => '?pagina=%#%',
							'current'   => $paged,
							'total'     => $total_pages+1,
							'mid_size'  => 2,
							'prev_text' => 'P',
							'next_text' => 'N',
						]);
						endif
						?>
					</div><!-- .nav-links -->
				</div><!-- .content-pagination -->
			</div>
		</div>
		<?php
		$archive_layout = get_theme_mod( 'archive_layout', 'default' );
		if ( 'default' === $archive_layout ) {
			get_sidebar();
		}
		?>
	</section><!-- #primary -->


<?php get_footer();
