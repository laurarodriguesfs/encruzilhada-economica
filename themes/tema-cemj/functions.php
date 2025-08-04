<?php
/**
 * Newspack Scott functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Newspack Scott
 */


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

/** Busca personalizada para qualquer post type */
function search_custom_post_type($template)
{
  global $wp_query;

  // Verifica se é uma busca
  if ($wp_query->is_search) {
    return locate_template('archive-search.php');  // Redireciona para archive-search.php
  }

  return $template;
}
add_filter('template_include', 'search_custom_post_type');

function meu_tema_adicionar_estilos_editor() {
    add_theme_support('editor-styles');
    add_editor_style('editor-style.scss');
}
add_action('after_setup_theme', 'meu_tema_adicionar_estilos_editor');

function registrar_fontes_personalizadas_editor() {
    wp_enqueue_script(
        'custom-fonts',
        get_template_directory_uri() . '/custom-fonts.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
    );
}
add_action( 'enqueue_block_editor_assets', 'registrar_fontes_personalizadas_editor' );

add_filter('template_include', function ($template) {
    // Página de todas as coleções
    if (is_post_type_archive('tainacan-collection')) {
        $child_template = get_stylesheet_directory() . '/archive-tainacan-collection.php';
        if (file_exists($child_template)) {
            return $child_template;
        }
    }

    // Página de itens de uma coleção
    if (is_post_type_archive('tainacan-item')) {
        $child_template = get_stylesheet_directory() . '/archive-tainacan-item.php';
        if (file_exists($child_template)) {
            return $child_template;
        }
    }

    // Página de um item específico
    if (is_singular('tainacan-item')) {
        $child_template = get_stylesheet_directory() . '/single-tainacan-item.php';
        if (file_exists($child_template)) {
            return $child_template;
        }
    }

    // Página de categorias das coleções
    if (is_tax('tainacan-category')) {
        $child_template = get_stylesheet_directory() . '/taxonomy-tainacan-category.php';
        if (file_exists($child_template)) {
            return $child_template;
        }
    }

    // Página de tags das coleções
    if (is_tax('tainacan-tag')) {
        $child_template = get_stylesheet_directory() . '/taxonomy-tainacan-tag.php';
        if (file_exists($child_template)) {
            return $child_template;
        }
    }

    return $template;
});

function add_post_to_admin_menu() {
    // Adiciona o link para a página de posts ao menu lateral do WordPress
    add_menu_page(
        'Todos os Posts',  // Título da página
        'Posts',           // Nome do item no menu
        'edit_posts',      // Capacidade necessária
        'edit.php',        // O slug para acessar a página de todos os posts
        '',                // Não há função personalizada (usamos a página padrão)
        'dashicons-admin-post', // Ícone para o menu
        6                  // Posição do item no menu (pode ser ajustada)
    );
}
add_action('admin_menu', 'add_post_to_admin_menu');

// Adiciona suporte para páginas do Tainacan
function tainacan_pages_support() {
    add_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'tainacan_pages_support' );

function my_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'my_custom_flush_rewrite_rules');

/**
 * Tainacan Functions to use with the Tainacan Plugins
 */

 function tainacan_collections_viewmode($public_query_vars){
    $public_query_vars[] = "tainacan_collections_viewmode";
    return $public_query_vars;
}
add_filter( 'query_vars', 'tainacan_collections_viewmode');

function tainacan_active($selected, $current = true, $echo = true) {

    $return = $selected == $current ? 'active' : '';

    if ($echo)
        echo $return;

    return $return;

}

function tainacan_theme_collection_title($title){
    if (is_post_type_archive('tainacan-collection')) {
        return 'Coleções';
    }
    return $title;
}
add_filter('get_the_archive_title', 'tainacan_theme_collection_title');

function tainacan_theme_collection_query($query){
    if ($query->is_main_query() && $query->is_post_type_archive('tainacan-collection')) {
        $query->set('posts_per_page', 12);
    }
}
add_action('pre_get_posts', 'tainacan_theme_collection_query');

function tainacan_meta_date_author( $echo = true ) {
	$time = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date()
	);

	$string = $time_string;
	$string .= '&nbsp;por&nbsp;';
	$string .= get_the_author_posts_link();

	$string = apply_filters( 'tainacan-meta-date-author', $string );

	if ( $echo ) {
		echo $string;
	} else {
		return $string;
	}
}

add_filter( 'jpeg_quality', 'rhs_image_full_quality' );
add_filter( 'wp_editor_set_quality', 'rhs_image_full_quality' );

function rhs_image_full_quality( $quality ) {
	return 100;
}

function meu_tema_filho_custom_palette() {
    // Substitua 'seu-tema-filho' pelo textdomain do seu tema filho
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Amarelo Principal', 'child' ),
            'slug'  => 'amarelo-principal',
            'color' => '#F5D536',
        ),
        array(
            'name'  => __( 'Azul Escuro', 'child' ),
            'slug'  => 'azul-escuro',
            'color' => '#1C154D',
        ),
        array(
            'name'  => __( 'Verde Vibrante', 'child' ),
            'slug'  => 'verde-vibrante',
            'color' => '#0D8432',
        ),
        array(
            'name'  => __( 'Azul Médio', 'child' ),
            'slug'  => 'azul-medio',
            'color' => '#4083BD',
        ),
        array(
            'name'  => __( 'Preto', 'child' ),
            'slug'  => 'preto',
            'color' => '#000000',
        ),
        array(
            'name'  => __( 'Branco', 'child' ),
            'slug'  => 'branco',
            'color' => '#FFFFFF',
        ),
    ) );

}
add_action( 'after_setup_theme', 'meu_tema_filho_custom_palette', 20 );

function cemj_customizer_register( $wp_customize ) {
    // Exemplo: adicionar uma cor para a paleta
    $wp_customize->add_setting( 'primary_color', array(
        'default'   => '#F5D536',
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
        'label'    => __( 'Amarelo Principal', 'child' ),
        'section'  => 'colors',
        'settings' => 'primary_color',
    ) ) );
}
add_action( 'customize_register', 'cemj_customizer_register' );

/**
 * Enfileira o script para a funcionalidade "Carregar Mais".
 */
function newspack_child_enqueue_load_more_scripts() {
    // Só carrega o script em páginas de arquivo (categorias, tags, arquivos de autor, etc.)
    if ( is_archive() || is_home() ) {
        global $wp_query;

        // Define qual template part deve ser usado por padrão
        $template_to_use = 'excerpt';

        // Se estivermos no arquivo de 'revista', mudamos para 'revista'
        if ( is_post_type_archive('revista') ) {
            $template_to_use = 'revista';
        }



        // Registra e enfileira o script
        wp_enqueue_script(
            'newspack-load-more',
            get_stylesheet_directory_uri() . '/assets/javascript/load-more.js',
            array( 'jquery' ),
            '1.0',
            true
        );

        // Passa variáveis do PHP para o JavaScript
        wp_localize_script(
            'newspack-load-more',
            'load_more_params',
            array(
                'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                'query'         => json_encode( $wp_query->query_vars ), // Mude 'posts' para 'query'
                'current_page'  => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                'max_pages'     => $wp_query->max_num_pages, // Mude 'max_page' para 'max_pages'
                'nonce'         => wp_create_nonce('load_more_posts_nonce'),
                'template_part' => $template_to_use // ADICIONE ESTA LINHA
            )

        );
    }
}
add_action( 'wp_enqueue_scripts', 'newspack_child_enqueue_load_more_scripts' );

/**
 * Manipulador AJAX para carregar mais posts.
 */
function newspack_child_load_more_handler() {
    // Verifica o nonce de segurança
    check_ajax_referer('load_more_posts_nonce', 'nonce');

    // Prepara os argumentos da query
    $args = json_decode( stripslashes( $_POST['query'] ), true );
    $args['paged'] = $_POST['page'] + 1; // Carrega a próxima página
    $args['post_status'] = 'publish';

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        // Inicia o loop para buscar os posts
        while ( $query->have_posts() ) : $query->the_post();
            // Pega o nome do template que o JS enviou e o valida por segurança
            $template_part_name = 'excerpt'; // Valor padrão de segurança
            if ( isset($_POST['template_part']) ) {
                $template_part_name = sanitize_file_name($_POST['template_part']);
            }

            // Usa a variável para carregar o template correto
            get_template_part( 'template-parts/content/content', $template_part_name );
        endwhile;
    }

    wp_die(); // Termina a execução do AJAX
}
add_action( 'wp_ajax_load_more_posts', 'newspack_child_load_more_handler' );
add_action( 'wp_ajax_nopriv_load_more_posts', 'newspack_child_load_more_handler' ); // Para usuários não logados

/**
 * Altera o número de posts por página no arquivo de "Revistas".
 */
function tema_cemj_limite_posts_revista( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'revista' ) ) {
        
        $query->set( 'posts_per_page', 8 );
    }
}
add_action( 'pre_get_posts', 'tema_cemj_limite_posts_revista' );