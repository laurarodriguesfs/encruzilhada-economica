<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newspack
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php
		remove_filter( 'get_the_date', 'newspack_convert_to_time_ago', 10, 3 );
		do_action( 'before_sidebar' );
		/**
		 * Displays social links menu; create a function for the wp_nav_menu settings to reduce duplication.
		 */
		function newspack_fixed_menu_settings() {
			wp_nav_menu(
				array(
					'theme_location' => 'fixed-menu',
					'menu_class'     => 'fixed-links-menu',
					'container'      => false,
					'link_before'    => '<span>'  . newspack_get_icon_svg( 'link' ),
					'link_after'     => '</span>',
					'depth'          => 1,
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
		}
		?>
		<nav class="fixed-navigation" aria-label="<?php esc_attr_e( 'Fixed Links Menu', 'newspack' ); ?>" <?php echo $toolbar_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php newspack_fixed_menu_settings(); ?>
		</nav><!-- .social-navigation -->

		<?
		do_action( 'after_sidebar' );
		add_filter( 'get_the_date', 'newspack_convert_to_time_ago', 10, 3 );
	?>
</aside><!-- #secondary -->
