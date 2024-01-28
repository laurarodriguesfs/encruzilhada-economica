<?php
get_header();
/**
 * Template Name: Archive de termos da taxonomia Agrupamento de posteres
 */

$paged       = (isset($_GET["pagina"]) && !empty($_GET["pagina"])) ? absint($_GET["pagina"]): 1;
$taxonomy    = 'agrupamento';
$hide_empty  = false;
$orderby     = 'id';
$order       = 'ASC';
$per_page    = 3;
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

$args = [
	'taxonomy'   => $taxonomy,
	'number'     => $per_page,
	'offset'     => $offset,
	'orderby'    => $orderby,
	'order'      => $order,
	'hide_empty' => $hide_empty,
];

$terms = get_terms($args);

$count_terms = wp_count_terms(
	[
		'taxonomy'   => $taxonomy,
		'hide_empty' => $hide_empty
	]
);

$total_pages = intval($count_terms / $per_page) + 1;

$count_found_terms = (($per_page * $paged) > $count_terms) ? $count_terms : $per_page * $paged;


?>



<div class="index-wrapper">

	<?php get_template_part('template-parts/header/entry-header', 'post'); ?>

	<div class="container">
		<div class="row">
			<div class="content-post">
				<?php the_content(); ?>
			</div><!-- .content-post -->

			<div class="infos">
			</div><!-- .infos -->

			<main class="archive-terms">
				<?php foreach ($terms as $term) : ?>
					<?php
					$title       = $term->name;
					$slogan      = get_term_meta($term->term_id, 'slogan', true);
					$thumbnail   = get_term_meta($term->term_id, 'imagem_destacada', true);
					$permalink   = get_term_link($term->term_id, 'agrupamento');
					$description = term_description($term->term_id);
					?>
					<div class="term post posts-wrapper">
						<div class="post-card">
							<div class="post-card--content">
								<a href="<?php echo esc_url($permalink); ?>">
									<h5>
										<?php if ($slogan) : ?>
											<?php echo($title); ?>>
										<?php else : ?>
											<?php echo($title); ?>
										<?php endif; ?>
									</h5>
									<div class="descricao">
										<?php if ($description) : ?>
											<p><?php echo apply_filters('the_content', $description); ?></p>
										<?php endif; ?>
									</div>
								</a><!-- .post-card--content -->
							</div>
						</div><!-- .post-card -->
					</div><!-- .term.post -->
				<?php endforeach; ?>
			</main><!-- .archive-posts -->

			<div class="navigation pagination">
					<div class="nav-links">
						<?php
						$arrow_icon_prev = file_get_contents( get_template_directory_uri() . '/assets/images/pagination-prev.svg' );
						echo paginate_links([
							'base'      => add_query_arg('pagina','%#%'),
							'format'    => '?pagina=%#%',
							'total'     => $count_terms / $per_page,
							'current'   => $paged,
							'total'     => $total_pages,
							'mid_size'  => 2,
							'prev_text' => $arrow_icon,
							'next_text' => $arrow_icon
						]);
						?>
					</div><!-- .nav-links -->
				</div><!-- .content-pagination -->
			</div>
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- .index-wrapper -->
<?php get_footer();
