<?php
/**
 * Displays the footer branding and social links.
 *
 * @package Newspack
 */

$has_footer_logo = false;
if ( '' !== get_theme_mod( 'newspack_footer_logo', '' ) && 0 !== get_theme_mod( 'newspack_footer_logo', '' ) ) {
	$has_footer_logo = true;
}

if ( is_active_sidebar( 'footer-1' ) && ( has_custom_logo() || $has_footer_logo ) ) : ?>
	<div class="footer-branding">
		<div class="wrapper">
		<?php 
			newspack_social_menu_footer();
		?>
		</div><!-- .wrapper -->
	</div><!-- .footer-branding -->
<?php endif; ?>
