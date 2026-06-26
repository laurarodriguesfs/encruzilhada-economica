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

// Adiciona uma paleta de cores personalizada ao editor do WordPress
function meu_tema_filho_custom_palette() {
    // Substitua 'child' pelo textdomain do seu tema, se for diferente
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Vermelho', 'child' ),
            'slug'  => 'vermelho',
            'color' => '#ad0000',
        ),
        array(
            'name'  => __( 'Azul Escuro', 'child' ),
            'slug'  => 'azul-escuro',
            'color' => '#24064e',
        ),
        array(
            'name'  => __( 'Azul Opaco', 'child' ),
            'slug'  => 'azul-opaco',
            'color' => '#4a3e70',
        ),
        array(
            'name'  => __( 'Roxo Claro', 'child' ),
            'slug'  => 'roxo-claro',
            'color' => '#a29eb6',
        ),
        array(
            'name'  => __( 'Rosa', 'child' ),
            'slug'  => 'rosa',
            'color' => '#d9043d',
        ),
        array(
            'name'  => __( 'Preto', 'child' ),
            'slug'  => 'preto',
            'color' => '#000000',
        ),
        array(
            'name'  => __( 'Branco', 'child' ),
            'slug'  => 'branco',
            'color' => '#fdfdfd',
        ),
    ) );
}
add_action( 'after_setup_theme', 'meu_tema_filho_custom_palette' );
add_action( 'after_setup_theme', 'meu_tema_filho_custom_palette', 20 );

/**
 * Enfileira os assets do Mix apenas no Customizer
 */
function meu_tema_customizer_palette_assets() {
    // Carrega o CSS principal que agora contém os estilos da paleta
    wp_enqueue_style( 'meu-tema-customizer-css', get_stylesheet_directory_uri() . '/dist/css/app.css' );
    
    // Carrega o JS da paleta (se você compilou ele separado ou dentro do app.js)
    wp_enqueue_script( 'meu-tema-palette-js', get_stylesheet_directory_uri() . '/dist/js/app.js', array(), null, true );
}
add_action( 'customize_controls_enqueue_scripts', 'meu_tema_customizer_palette_assets' );

/**
 * Registra a seção da paleta (Removido os blocos de Style e Script internos)
 */
function meu_tema_filho_customizer_palette_section( $wp_customize ) {
    $color_palette = [
        'Vermelho'    => '#ad0000',
        'Azul Escuro' => '#24064e',
        'Azul Opaco'  => '#4a3e70',
        'Roxo Claro'  => '#a29eb6',
        'Rosa'        => '#d9043d',
        'Preto'       => '#000000',
        'Branco'      => '#fdfdfd',
    ];

    $wp_customize->add_setting( 'meu_tema_paleta_header_setting' );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'meu_tema_paleta_header_control', [
        'section'     => 'colors',
        'settings'    => 'meu_tema_paleta_header_setting',
        'type'        => 'hidden',
        'priority'    => 5,
        'description' => '<hr><h3 style="margin-top:15px;">Paleta de Referência</h3>',
    ] ) );

    $palette_html = '<div id="custom-palette-container">';
    foreach ( $color_palette as $name => $hex ) {
        $palette_html .= sprintf(
            '<div class="custom-palette-swatch-wrapper">
                <div class="custom-palette-color-name">%s</div>
                <div class="custom-palette-color-box" style="background-color:%s" data-hex-code="%s"></div>
                <div class="custom-palette-hex-code">%s</div>
            </div>',
            esc_html($name), esc_attr($hex), esc_attr($hex), esc_html($hex)
        );
    }
    $palette_html .= '</div><div id="custom-palette-copy-feedback"></div>';

    $wp_customize->add_setting( 'meu_tema_paleta_dummy_setting' );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'meu_tema_paleta_control', [
        'section'     => 'colors',
        'settings'    => 'meu_tema_paleta_dummy_setting',
        'type'        => 'hidden',
        'priority'    => 6,
        'description' => $palette_html,
    ] ) );
}
add_action( 'customize_register', 'meu_tema_filho_customizer_palette_section' );

// Menus flutuantes
register_nav_menus( array(
    'menu_conteudo' => 'Menu Navegue pelo Conteúdo',
    'menu_eixos'    => 'Menu Eixos Temáticos',
) );

function enqueue_menu_scripts_child_theme() {
    // Caminho do arquivo no servidor para checar a data de modificação
    $js_path = get_stylesheet_directory() . '/assets/javascript/menu-interativo.js';
    
    // filemtime gera um número baseado na data/hora do arquivo
    $version = file_exists($js_path) ? filemtime($js_path) : '1.0';

    wp_enqueue_script(
        'menu-interativo', 
        get_stylesheet_directory_uri() . '/assets/javascript/menu-interativo.js', 
        array(), 
        $version, 
        true 
    );
}
add_action('wp_enqueue_scripts', 'enqueue_menu_scripts_child_theme');

function registrar_cpt_headers() {
    register_post_type('archive_header', [
        'labels'      => ['name' => 'Cabeçalhos de Archive', 'singular_name' => 'Cabeçalho'],
        'public'      => true,
        'show_in_rest' => true, // Ativa o Gutenberg
        'supports'    => ['title', 'editor'],
        'menu_icon'   => 'dashicons-layout',
    ]);
}
add_action('init', 'registrar_cpt_headers');

add_filter( 'gettext_with_context', 'traduzir_botao_by_newspack', 20, 4 );


function traduzir_botao_by_newspack( $translated_text, $text, $context, $domain ) {
    
    // ATENÇÃO: Esta é uma VERIFICAÇÃO de depuração. 
    // Se funcionar, o problema é o valor de $context.
    
    if ( 'by' === $text && 'newspack-blocks' === $domain ) {
        // Ignora o $context e força a tradução
        $translated_text = 'Por'; 
    }
    
    return $translated_text;
}

/**
 * ===================================================================
 * SISTEMA UNIFICADO DE AJAX: FILTROS E CARREGAR MAIS (VERSÃO FINAL)
 * Este bloco de código gerencia todas as listagens de posts dinâmicas.
 * ===================================================================
 */

/**
 * 1. Enfileira o script e passa os parâmetros corretos para cada tipo de página.
 */
function tema_unificado_ajax_scripts() {

    // Condição: Só carrega o script se for a página de filtros ou um arquivo.
    if ( is_search() || is_archive() ) {

        global $wp_query;

        $params = [
            'ajax_url'          => admin_url( 'admin-ajax.php' ),
            'nonce'             => wp_create_nonce( 'unificado_ajax_nonce' ),
            'posts_per_page'    => get_option('posts_per_page'),
            'max_pages'         => 1,
            'current_page'      => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
            'is_filter_page'    => false,
            'initial_query'     => [], // Começa como um array vazio por padrão
            'template_part'     => 'template-parts/content/content-excerpt',
            'container'         => '.archive-posts-grid', // Padrão para archive.php
        ];

        // Se for uma página de arquivo, nós preenchemos a initial_query.
         // Se for uma página de arquivo, nós preenchemos a initial_query.
        if ( is_archive() ) {
                $params['max_pages']     = $wp_query->max_num_pages;
                $params['initial_query'] = $wp_query->query_vars;

            // Se for a página de filtros, a initial_query permanece vazia.
            // Se for uma página de busca
        }
        if ( is_search() ) {
            $params['max_pages']     = $wp_query->max_num_pages;
            $params['initial_query'] = $wp_query->query_vars;
            $params['container']      = '.archive-posts-grid'; // Certifique-se que seu archive-search.php usa essa classe
        
            $params['template_part'] = 'template-parts/content/content-search';
        }
        
        // Enfileira o script (verifique o caminho!)
        wp_enqueue_script(
            'unificado-ajax-script',
            get_stylesheet_directory_uri() . '/assets/javascript/ajax-unificado.js', // VERIFIQUE SE ESTE CAMINHO ESTÁ CORRETO
            ['jquery'],
            '1.5', // Versão incrementada para evitar cache
            true
        );

        wp_localize_script( 'unificado-ajax-script', 'ajax_params', $params );
    }
}
add_action( 'wp_enqueue_scripts', 'tema_unificado_ajax_scripts' );


function tema_unificado_ajax_handler() {
    // Limpa buffers para evitar lixo no JSON
    if (ob_get_length()) ob_clean();

    $paged    = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $formato  = isset($_POST['formato']) ? sanitize_text_field($_POST['formato']) : '';
    
    // Recupera a query inicial enviada pelo JS
    $query_raw = $_POST['query'] ?? '';
    $initial_query = [];

    // Proteção PHP 8 contra o erro de stripslashes
    if (is_string($query_raw) && !empty($query_raw)) {
        $initial_query = json_decode(stripslashes($query_raw), true);
    } elseif (is_array($query_raw)) {
        $initial_query = $query_raw;
    }

    // Monta os argumentos básicos
    $args = [
        'paged'               => $paged,
        'post_status'         => 'publish',
        'posts_per_page'      => get_option('posts_per_page'),
        'ignore_sticky_posts' => 1,
    ];

    // Define o post_type: Se veio na query inicial (archive), usa ele. 
    // Se for a página de filtros, definimos o padrão (ajuste 'post' para o nome do seu CPT se necessário)
    $args['post_type'] = $initial_query['post_type'] ?? 'post';

    // Se existirem filtros de taxonomia
    $tax_query = ['relation' => 'AND'];
    
    if ( !empty($category) ) {
        $tax_query[] = ['taxonomy' => 'category', 'field' => 'slug', 'terms' => $category];
    }
    if ( !empty($formato) ) {
        $tax_query[] = ['taxonomy' => 'formato', 'field' => 'slug', 'terms' => $formato];
    }

    if ( count($tax_query) > 1 ) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query( $args );

    ob_start();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            // Tenta carregar o template part definido no JS, ou o padrão
            $template = $_POST['template_part'] ?? 'template-parts/content/content-excerpt';
            get_template_part( $template );
        }
    } else {
        if ( 1 === $paged ) {
            echo '<p style="text-align: center; width: 100%;">Nenhum post encontrado.</p>';
        }
    }

    $html = ob_get_clean();
    wp_reset_postdata();

    wp_send_json_success([
        'html'      => $html,
        'max_pages' => $query->max_num_pages,
    ]);
}
// Mantenha os add_action abaixo da função
add_action( 'wp_ajax_unificado_load_posts', 'tema_unificado_ajax_handler' );
add_action( 'wp_ajax_nopriv_unificado_load_posts', 'tema_unificado_ajax_handler' );

function exibir_posts_relacionados() {
    global $post;

    // 1. AJUSTE: Verifica se é um post individual de QUALQUER tipo (menos páginas)
    if ( !is_singular() || is_page() ) {
        return;
    }

    $id_do_post_atual = $post->ID;
    $post_type_atual = get_post_type($id_do_post_atual);

    // 2. DINÂMICO: Pega as taxonomias do post atual (seja 'category' ou do Pods)
    $taxonomias = get_object_taxonomies($post_type_atual);
    
    if ( empty($taxonomias) ) {
        return;
    }

    // Criamos uma tax_query que busca termos em QUALQUER taxonomia do post
    $tax_query = array('relation' => 'OR');
    $tem_termos = false;

    foreach ($taxonomias as $tax) {
        $termos = wp_get_post_terms($id_do_post_atual, $tax, array('fields' => 'ids'));
        if (!empty($termos) && !is_wp_error($termos)) {
            $tax_query[] = array(
                'taxonomy' => $tax,
                'field'    => 'term_id',
                'terms'    => $termos,
            );
            $tem_termos = true;
        }
    }

    // Se o post não tiver nenhuma categoria ou tag, não busca nada
    if (!$tem_termos) {
        return;
    }

    $args = array(
        'post_type'      => 'any', // Busca em todos os CPTs (inclusive Pods)
        'posts_per_page' => 3,
        'post__not_in'   => array($id_do_post_atual),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query'      => $tax_query,
    );

    $query_posts_relacionados = new WP_Query($args);

    if ( $query_posts_relacionados->have_posts() ) {
        echo '<section class="posts-relacionados">';
        echo '<div class="titulo-container">';
        echo '<h2>Relacionados</h2>';
        echo '</div>';
        echo '<div class="related-posts-container">';

        while ( $query_posts_relacionados->have_posts() ) {
            $query_posts_relacionados->the_post();
            
            get_template_part('template-parts/content/content', 'excerpt');
        }

        echo '</div>';
        echo '</section>';
    }

    wp_reset_postdata();
}

/**
 * Incluir Custom Post Types nas páginas de categorias e tags
 */
function incluir_cpts_na_categoria( $query ) {
    // Só altera a query principal, no front-end e se for uma página de categoria ou tag
    if ( ! is_admin() && $query->is_main_query() && ( is_category() || is_tag() ) ) {
        
        // Aqui você lista os nomes (slugs) dos seus CPTs do Pods
        $query->set( 'post_type', array( 
            'post', // Importante manter o post padrão se quiser que ele apareça
            'item_da_agenda', 
            'dado_ou_evidencia', 
            'dossie', 
            'livro_ou_resenha', 
            'publicacao_ou_analis', 
            'video_ou_podcast' 
        ) );
    }
}
add_action( 'pre_get_posts', 'incluir_cpts_na_categoria' );

function exibir_barra_compartilhamento_personalizada($post_url, $post_title, $post_excerpt = '') {
    $post_url_encoded = esc_url($post_url);
    $post_title_encoded = urlencode(strip_tags($post_title));
    $post_excerpt_encoded = urlencode(strip_tags($post_excerpt));
    $instagram_username = "toemmovimento";
    ?>

    <div class="share-bar"> <p>Compartilhe</p>

        <a id="instagram-share-button"
           href="https://www.instagram.com/<?php echo $instagram_username; ?>/"
           target="_blank"
           rel="noopener noreferrer"
           class="share-button instagram"
           title="Visitar nosso Instagram">
           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve" width="24px" height="24px">
                <g>
                    <path d="M12,2.162c3.204,0,3.584,0.012,4.849,0.07c1.308,0.06,2.655,0.358,3.608,1.311c0.962,0.962,1.251,2.296,1.311,3.608   c0.058,1.265,0.07,1.645,0.07,4.849c0,3.204-0.012,3.584-0.07,4.849c-0.059,1.301-0.364,2.661-1.311,3.608   c-0.962,0.962-2.295,1.251-3.608,1.311c-1.265,0.058-1.645,0.07-4.849,0.07s-3.584-0.012-4.849-0.07   c-1.291-0.059-2.669-0.371-3.608-1.311c-0.957-0.957-1.251-2.304-1.311-3.608c-0.058-1.265-0.07-1.645-0.07-4.849   c0-3.204,0.012-3.584,0.07-4.849c0.059-1.296,0.367-2.664,1.311-3.608c0.96-0.96,2.299-1.251,3.608-1.311   C8.416,2.174,8.796,2.162,12,2.162 M12,0C8.741,0,8.332,0.014,7.052,0.072C5.197,0.157,3.355,0.673,2.014,2.014   C0.668,3.36,0.157,5.198,0.072,7.052C0.014,8.332,0,8.741,0,12c0,3.259,0.014,3.668,0.072,4.948c0.085,1.853,0.603,3.7,1.942,5.038   c1.345,1.345,3.186,1.857,5.038,1.942C8.332,23.986,8.741,24,12,24c3.259,0,3.668-0.014,4.948-0.072   c1.854-0.085,3.698-0.602,5.038-1.942c1.347-1.347,1.857-3.184,1.942-5.038C23.986,15.668,24,15.259,24,12   c0-3.259-0.014-3.668-0.072-4.948c-0.085-1.855-0.602-3.698-1.942-5.038c-1.343-1.343-3.189-1.858-5.038-1.942   C15.668,0.014,15.259,0,12,0z"/>
                <path d="M12,5.838c-3.403,0-6.162,2.759-6.162,6.162c0,3.403,2.759,6.162,6.162,6.162s6.162-2.759,6.162-6.162   C18.162,8.597,15.403,5.838,12,5.838z M12,16c-2.209,0-4-1.791-4-4s1.791-4,4-4s4,1.791,4,4S14.209,16,12,16z"/>
                <circle cx="18.406" cy="5.594" r="1.44"/>
            </g>
            </svg>
        </a>

        <a href="https://twitter.com/intent/tweet?url=<?php echo $post_url_encoded; ?>&text=<?php echo $post_title_encoded; ?>"
           target="_blank"
           rel="noopener noreferrer"
           class="share-button twitter"
           title="Compartilhar no X (Twitter)">
           <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 462.799" width="24px" height="24px">
               <path fill-rule="nonzero" d="M403.229 0h78.506L310.219 196.04 512 462.799H354.002L230.261 301.007 88.669 462.799h-78.56l183.455-209.683L0 0h161.999l111.856 147.88L403.229 0zm-27.556 415.805h43.505L138.363 44.527h-46.68l283.99 371.278z"/>
           </svg>
        </a>

        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url_encoded; ?>"
           target="_blank"
           rel="noopener noreferrer"
           class="share-button facebook"
           title="Compartilhar no Facebook">
           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve" width="24px" height="24px">
                <g>
                    <path d="M24,12.073c0,5.989-4.394,10.954-10.13,11.855v-8.363h2.789l0.531-3.46H13.87V9.86c0-0.947,0.464-1.869,1.95-1.869h1.509V5.045c0,0-1.37-0.234-2.679-0.234c-2.734,0-4.52,1.657-4.52,4.656v2.637H7.091v3.46h3.039v8.363C4.395,23.025,0,18.061,0,12.073c0-6.627,5.373-12,12-12S24,5.445,24,12.073z"/>
                </g>
            </svg>
        </a>
        
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const instagramButton = document.getElementById('instagram-share-button');
    const isMobile = /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    const mobileShareUrl = 'instagram://sharesheet?text=<?php echo $post_url_encoded; ?>';
    const desktopProfileUrl = 'https://www.instagram.com/<?php echo $instagram_username; ?>/';

    if (instagramButton) {
        if (isMobile) {
            instagramButton.href = mobileShareUrl;
            instagramButton.title = "Compartilhar no Instagram Direct";
        } else {
            instagramButton.href = desktopProfileUrl;
            instagramButton.title = "Visitar nosso Instagram";
        }
    }
});
</script>
<?php
}

// 1. Força o status de comentários como aberto para todos os CPTs no PHP
add_filter( 'comments_open', function( $open, $post_id ) {
    $post = get_post( $post_id );
    
    // Lista de tipos que NÃO devem ter comentários (opcional)
    $excluded_types = array( 'page','revision', 'attachment', 'nav_menu_item' );

    if ( ! in_array( $post->post_type, $excluded_types ) ) {
        return true;
    }
    
    return $open;
}, 999, 2 );

// 2. Garante que novos posts de qualquer tipo herdem o status 'open'
add_filter( 'wp_insert_post_data', function( $data, $postarr ) {
    if ( $data['post_status'] == 'publish' && $data['post_type'] !== 'page' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}, 99, 2 );

add_filter('query_vars', function($vars) {
    $vars[] = 'cat_filtrada';
    $vars[] = 'autor_filtrado';
    $vars[] = 'mes_filtro';
    $vars[] = 'tempo';
    return $vars;
});

add_action('pre_get_posts', function($query) {
    if (is_admin() || !$query->is_main_query()) return;

    if (is_post_type_archive('item_da_agenda')) {
        $hoje = date('Y-m-d');
        $tempo = get_query_var('tempo');
        $mes = get_query_var('mes_filtro');

        $query->set('meta_key', 'data_inicio');
        $query->set('orderby', 'meta_value');
        $query->set('meta_type', 'DATE');

        if (!empty($mes)) {
            $ano = date('Y');
            $query->set('order', 'ASC');
            $query->set('meta_query', [['key' => 'data_inicio', 'value' => ["$ano-$mes-01", "$ano-$mes-31"], 'compare' => 'BETWEEN', 'type' => 'DATE']]);
        } elseif ($tempo === 'passados') {
            $query->set('order', 'DESC');
            $query->set('meta_query', [['key' => 'data_inicio', 'value' => $hoje, 'compare' => '<', 'type' => 'DATE']]);
        } else {
            $query->set('order', 'ASC');
            $query->set('meta_query', [['key' => 'data_inicio', 'value' => $hoje, 'compare' => '>=', 'type' => 'DATE']]);
        }
    }
});

add_action('pre_get_posts', function($query) {
    // 1. Segurança: Não roda no admin e apenas na query principal
    if (is_admin() || !$query->is_main_query()) return;

    // 2. Especificidade: Roda APENAS na página de busca
    if ($query->is_search()) {
        
        // Usamos get_query_var (lembre-se de manter o add_filter de query_vars que passei antes)
        $cat = get_query_var('cat_filtrada');
        $aut = get_query_var('autor_filtrado');

        // Filtro de Categoria acumulado na busca
        if (!empty($cat)) {
            $query->set('cat', intval($cat));
        }

        // Filtro de Autor acumulado na busca
        if (!empty($aut)) {
            $query->set('author', intval($aut));
        }
    }
});

add_filter( 'wpuf_add_post_args', 'direcionar_cpt_pods', 10, 2 );

function direcionar_cpt_pods( $args, $form_id ) {
    if ( $form_id == 338 ) {
        
        if ( isset( $_POST['tipo_de_conteudo'] ) ) {
            $slug_do_pod = sanitize_text_field( $_POST['tipo_de_conteudo'] );

            // Verificação de segurança para garantir que o CPT existe
            if ( post_type_exists( $slug_do_pod ) ) {
                $args['post_type'] = $slug_do_pod;
            }
        }
    }
    return $args;
}

/**
 * 1. Mantém os campos de texto acadêmicos e sociais
 */
function adicionar_campos_perfil_autor( $user_fields ) {
    $user_fields['areas_de_pesquisa'] = 'Áreas de Pesquisa';
    $user_fields['curriculo_lattes']   = 'Currículo Lattes (URL)';
    $user_fields['orcid']              = 'ORCID (URL)';
    $user_fields['link_linkedin']      = 'LinkedIn (URL)';
    $user_fields['link_twitter']       = 'Twitter/X (URL)';
    
    return $user_fields;
}
add_filter( 'user_contactmethods', 'adicionar_campos_perfil_autor' );


/**
 * 2. Adiciona o campo de Seleção de Posts no perfil do usuário
 */
function exibir_campo_principais_artigos( $user ) {
    // Puxa todos os posts que pertencem a este autor para ele poder selecionar
    $args = array(
        'author'         => $user->ID,
        'posts_per_page' => -1, // Traz todos os posts dele
        'post_status'    => 'publish'
    );
    $posts_do_autor = get_posts( $args );
    
    // Puxa os IDs que já foram salvos anteriormente (retorna uma array)
    $artigos_salvos = get_user_meta( $user->ID, 'principais_artigos_ids', true );
    if ( ! is_array( $artigos_salvos ) ) {
        $artigos_salvos = array();
    }
    ?>
    <h3>Configurações Acadêmicas Avançadas</h3>
    <table class="form-table">
        <tr>
            <th><label for="principais_artigos_ids">Principais Artigos Publicados</label></th>
            <td>
                <?php if ( ! empty( $posts_do_autor ) ) : ?>
                    <p class="description" style="margin-bottom: 8px;">Segure Ctrl (Windows) ou Command (Mac) para selecionar mais de um artigo:</p>
                    <select name="principais_artigos_ids[]" id="principais_artigos_ids" multiple style="height: 150px; width: 100%; max-width: 500px;">
                        <?php foreach ( $posts_do_autor as $post ) : ?>
                            <option value="<?php echo $post->ID; ?>" <?php selected( in_array( $post->ID, $artigos_salvos ) ); ?>>
                                <?php echo esc_html( $post->post_title ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else : ?>
                    <p class="description" style="color: #dc3232;">Este autor ainda não publicou nenhum post para ser selecionado.</p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'exibir_campo_principais_artigos' );
add_action( 'edit_user_profile', 'exibir_campo_principais_artigos' );



/**
 * 3. Salva a seleção dos artigos no banco de dados
 */
function salvar_campo_principais_artigos( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    
    if ( isset( $_POST['principais_artigos_ids'] ) && is_array( $_POST['principais_artigos_ids'] ) ) {
        // Sanatiza o array de IDs recebido
        $ids_limpos = array_map( 'intval', $_POST['principais_artigos_ids'] );
        update_user_meta( $user_id, 'principais_artigos_ids', $ids_limpos );
    } else {
        // Se desmarcar todos, remove o registro
        delete_user_meta( $user_id, 'principais_artigos_ids' );
    }
}
add_action( 'personal_options_update', 'salvar_campo_principais_artigos' );
add_action( 'edit_user_profile_update', 'salvar_campo_principais_artigos' );

//Mais lidos

/**
 * Adiciona um widget no Painel do WordPress para mostrar o ranking real dos posts mais lidos.
 * Esta é a nossa "fonte da verdade" para verificação.
 */
function adicionar_widget_ranking_views() {
    wp_add_dashboard_widget(
        'widget_ranking_views',         // ID do widget.
        'Ranking Real de Posts Mais Lidos', // Título do widget.
        'funcao_callback_widget_ranking' // Função que vai exibir o conteúdo.
    );
}
add_action( 'wp_dashboard_setup', 'adicionar_widget_ranking_views' );

/**
 * Função que gera o conteúdo para o nosso widget do painel.
 */
function funcao_callback_widget_ranking() {
    echo '<p>Esta é a lista oficial dos posts mais lidos, ordenada pela contagem de views no banco de dados.</p>';

    // Argumentos para a consulta
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 10, // Vamos pegar o Top 10 para ter uma boa amostragem.
        'meta_key'       => 'post_views_count',
        'orderby'        => 'meta_value_num', // Ordenar por valor numérico!
        'order'          => 'DESC',
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        echo '<ol style="list-style: decimal; padding-left: 20px;">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();
            $contagem = get_post_meta( $post_id, 'post_views_count', true );
            
            // Exibimos o título do post e a contagem exata de views entre parênteses.
            echo '<li>';
            echo '<a href="' . get_edit_post_link($post_id) . '" target="_blank">' . get_the_title() . '</a>';
            echo ' <strong>(' . ( ! empty( $contagem ) ? $contagem : '0' ) . ' views)</strong>';
            echo '</li>';
        }
        echo '</ol>';
    } else {
        echo '<p>Ainda não há dados de visualização suficientes.</p>';
    }
    wp_reset_postdata();
}

/**
 * Cria um shortcode [bloco_replicado_mais_lidos] que executa uma consulta
 * para os posts mais vistos e formata o HTML para imitar o bloco do Newspack.
 * VERSÃO FINAL - Baseada no "blueprint" do usuário.
 */
function replicar_bloco_mais_lidos_shortcode( $atts ) {
    // 1. Define os atributos padrão. Ex: [bloco_replicado_mais_lidos posts="3"]
    $atts = shortcode_atts( array(
        'posts' => 3, // Mostrar 3 posts por padrão.
    ), $atts, 'bloco_replicado_mais_lidos' );

    // 2. Argumentos para a consulta ao banco de dados
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => intval( $atts['posts'] ),
        'meta_key'       => 'post_views_count',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
        'ignore_sticky_posts' => 1
    );

    $query = new WP_Query( $args );

    // 3. Inicia a "captura" do HTML que vamos gerar
    ob_start();

    // 4. Verifica se a consulta retornou posts
    if ( $query->have_posts() ) {

        // --- INÍCIO DA REPLICAÇÃO DO HTML ---
        // A DIV externa que cria o grid, com todas as classes do blueprint.
        echo '<div class="wp-block-newspack-blocks-homepage-articles wpnbha is-grid columns-3 colgap-3 show-image image-aligntop is-landscape show-category has-text-align-left bloco-post-fundo-cinza">';
        echo '<div>'; // Essa div extra estava no seu blueprint.

        // Loop para gerar cada post individual
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();
            $categories = get_the_category($post_id);
            ?>

            <article data-post-id="<?php echo esc_attr($post_id); ?>" <?php post_class(); ?>>
                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>" rel="bookmark" tabindex="-1" aria-hidden="true">
                            <?php 
                            // Usamos 'large' para que o WordPress gere o srcset responsivo automaticamente, como no blueprint.
                            the_post_thumbnail('large'); 
                            ?>
                        </a>
                    </figure><?php endif; ?>

                <div class="entry-wrapper">
                    <?php if ( ! empty( $categories ) ) : ?>
                        <div class="cat-links">
                            <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
                                <?php echo esc_html( $categories[0]->name ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php // Título do post com H2 e link com rel="bookmark", como no blueprint. ?>
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h2>
                    
                    <?php // O bloco de autor e data foi REMOVIDO para corresponder ao blueprint. ?>

                </div></article>

            <?php
        } // Fim do while

        echo '</div>'; // Fim da div extra
        echo '</div>'; // Fim da DIV externa

    } else {
        echo '<p>Nenhum post popular encontrado.</p>';
    }

    // 5. Restaura os dados do post original da página
    wp_reset_postdata();

    // 6. Retorna o HTML que foi "capturado"
    return ob_get_clean();
}
// Registra o nosso novo shortcode, se ele já não existir
if ( ! shortcode_exists( 'bloco_replicado_mais_lidos' ) ) {
    add_shortcode( 'bloco_replicado_mais_lidos', 'replicar_bloco_mais_lidos_shortcode' );
}

function incluir_cpts_no_arquivo_de_autor( $query ) {
    // Garante que isso só afete o front-end, a query principal e apenas páginas de arquivo de autor
    if ( ! is_admin() && $query->is_main_query() && $query->is_author() ) {
        
        // Defina aqui quais CPTs você quer incluir junto com os posts normais
        // Exemplo: 'post', 'artigos', 'livros', 'noticias'
        $query->set( 'post_type', array( 'post', 'item_da_agenda', 'dado_ou_evidencia', 'dossie', 'livro_ou_resenha', 'publicacao_ou_analis', 'video_ou_podcast'  ) );
    }
}
add_action( 'pre_get_posts', 'incluir_cpts_no_arquivo_de_autor' );