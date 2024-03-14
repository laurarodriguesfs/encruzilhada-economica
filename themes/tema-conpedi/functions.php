<?php
/**
 * Newspack Scott functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Newspack Scott
 */

/**
 * SVG Icons related functions.
 */
require get_stylesheet_directory() . '/inc/icon-functions-conpedi.php';

/**
 * SVG Icons class.
 */
require get_stylesheet_directory() . '/classes/class-conpedi-svg-icons.php';

if ( ! function_exists( 'newspack_scott_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newspack_scott_setup() {
		// Remove the default editor styles
		remove_editor_styles();
		// Add child theme editor styles, compiled from `style-child-theme-editor.scss`.
		add_editor_style( 'styles/style-editor.css' );

		register_nav_menus(
			array(
				'fixed-menu'   => __( 'Menu fixo', 'newspack' ),
			)
		);

	}
endif;
add_action( 'after_setup_theme', 'newspack_scott_setup', 12 );

/**
 * Function to load child theme's Google Fonts.
 */
function newspack_scott_fonts_url() {
	$fonts_url = '';

	/**
	* Translators: If there are characters in your language that are not
	* supported by Fira Sans Condensed, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$fira_sans_condensed = esc_html_x( 'on', 'Fira Sans Condensed font: on or off', 'newspack-scott' );
	if ( 'off' !== $fira_sans_condensed ) {
		$font_families   = array();
		$font_families[] = 'Fira Sans Condensed:400,400i,600,600i';

		$query_args = array(
			'family'  => urlencode( implode( '|', $font_families ) ),
			'subset'  => urlencode( 'latin,latin-ext' ),
			'display' => urlencode( 'swap' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return esc_url_raw( $fonts_url );
}

/**
 * Display custom color CSS in customizer and on frontend.
 */
function newspack_scott_custom_colors_css_wrap() {
	// Only bother if we haven't customized the color.
	if ( ( ! is_customize_preview() && 'default' === get_theme_mod( 'theme_colors', 'default' ) ) || is_admin() ) {
		return;
	}
	require_once get_stylesheet_directory() . '/inc/child-color-patterns.php';
	?>

	<style type="text/css" id="custom-theme-colors-scott">
		<?php echo newspack_scott_custom_colors_css(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</style>
	<?php
}
add_action( 'wp_head', 'newspack_scott_custom_colors_css_wrap' );

/**
 * Display custom font CSS in customizer and on frontend.
 */
function newspack_scott_typography_css_wrap() {
	if ( is_admin() || ( ! get_theme_mod( 'font_body', '' ) && ! get_theme_mod( 'font_header', '' ) && ! get_theme_mod( 'accent_allcaps', true ) ) ) {
		return;
	}
	?>

	<style type="text/css" id="custom-theme-fonts-scott">
		<?php echo newspack_scott_custom_typography_css(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</style>

<?php
}
add_action( 'wp_head', 'newspack_scott_typography_css_wrap' );


/**
 * Enqueue scripts and styles.
 */
function newspack_scott_scripts() {
	// Enqueue Google fonts.
	wp_enqueue_style( 'newspack-scott-fonts', newspack_scott_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'newspack_scott_scripts' );


/**
 * Enqueue supplemental block editor styles.
 */
function newspack_scott_editor_customizer_styles() {
	// Enqueue Google fonts.
	wp_enqueue_style( 'newspack-scott-fonts', newspack_scott_fonts_url(), array(), null );

	// Check for color or font customizations.
	$theme_customizations = '';
	require_once get_stylesheet_directory() . '/inc/child-color-patterns.php';

	if ( 'custom' === get_theme_mod( 'theme_colors' ) ) {
		// Include color patterns.
		$theme_customizations .= newspack_scott_custom_colors_css();
	}

	if ( get_theme_mod( 'font_body', '' ) || get_theme_mod( 'font_header', '' ) || get_theme_mod( 'accent_allcaps', true ) ) {
		$theme_customizations .= newspack_scott_custom_typography_css();
	}

	// If there are any, add those styles inline.
	if ( $theme_customizations ) {
		// Enqueue a non-existant file to hook our inline styles to:
		wp_register_style( 'newspack-scott-editor-inline-styles', false );
		wp_enqueue_style( 'newspack-scott-editor-inline-styles' );
		// Add inline styles:
		wp_add_inline_style( 'newspack-scott-editor-inline-styles', $theme_customizations );
	}
}
add_action( 'enqueue_block_editor_assets', 'newspack_scott_editor_customizer_styles' );

/**
 * Custom typography styles for child theme.
 */

require get_stylesheet_directory() . '/inc/child-typography.php';



function theme_assets() {
    wp_enqueue_style('vo-app', get_stylesheet_directory_uri() . '/dist/app.css', ['newspack-style'], filemtime(get_stylesheet_directory() . '/dist/app.css'), 'all');
    wp_enqueue_script('vo-app', get_stylesheet_directory_uri() . '/dist/app.js', null, true);
}

add_action('wp_enqueue_scripts', 'theme_assets');

function evp_customize_register( $wp_customize ){

    // Add header text color hexidecimal setting and control.
	$wp_customize->add_setting(
		'header_text_color_hex',
		array(
			'default'           => '#F8F8FF',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_text_color_hex',
			array(
				'label' => __( 'Apply a text color to the header.', 'newspack' ),
				'section'     => 'colors',
			)
		)
	);


   	 // Add header text color hexidecimal setting and control.
	$wp_customize->add_setting(
		'footer_text_color_hex',
		array(
			'default'           => '#F8F8FF',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_text_color_hex',
			array(
				'label' => __( 'Apply a text color to the footer.', 'newspack' ),
				'section'     => 'colors',
			)
		)
	);

}

add_action( 'customize_register', 'evp_customize_register' );

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

add_action( 'init', 'my_unregister_post_type', 999 );
function my_unregister_post_type(){
	unregister_post_type('locateanythingmarker');
}

add_action( 'admin_menu', 'remove_default_post_type' );

function remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}

add_action( 'admin_init', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}

add_action('admin_menu', 'remove_comment_support');

function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

/**
 * Add a extra span and class to the_archive_title, for easier styling.
 */
function conpedi_update_the_archive_title( $title ) {
	// Split the title into parts so we can wrap them with spans:
	$title_parts = explode( '<span class="page-description">', $title, 2 );
	// Glue it back together again.
	if ( ! empty( $title_parts[1] ) ) {
		$title = wp_kses(
			$title_parts[1],
			array(
				'span' => array(
					'class' => array(),
				),
			)
		);
		$title = '<span class="page-description">' . $title;
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'conpedi_update_the_archive_title', 11, 1 );

/** Busca personalizada para livros */
function search_livros($template)
{
  global $wp_query;
  $post_type = get_query_var('post_type');
  if( $wp_query->is_search && $post_type == 'livro' )
  {
    return locate_template('archive-search.php');  //  redirect to archive-search.php
  }
  return $template;
}
add_filter('template_include', 'search_livros');
