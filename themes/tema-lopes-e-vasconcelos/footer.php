<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newspack
 */

?>

	<?php do_action( 'before_footer' ); ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="footer-area">
			<?php remove_filter( 'get_the_date', 'newspack_convert_to_time_ago', 10, 3 ); ?>
			<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>
            <div class="footer-social-branding-wrapper"> 
                
                <?php get_template_part( 'template-parts/footer/footer', 'branding' ); ?>
                
                <div class="desenvolvido-por-container">
					<a href="<?php echo esc_url( __( 'https://laurarodrigues.com.br', 'laura rodrigues' ) ); ?>" class="desenvolvido-por">
						<?php echo esc_html__( 'Desenvolvido por', 'laura rodrigues' ); ?>
						<img class="custom-logo-lr" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-claro.png" alt="Logo Laura Rodrigues">
					</a>
				</div>
            </div> </div>

        </div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
