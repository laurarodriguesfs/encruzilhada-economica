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

// Adiciona uma paleta de cores personalizada ao editor do WordPress
function meu_tema_filho_custom_palette() {
    // Substitua 'child' pelo textdomain do seu tema, se for diferente
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Dourado Principal', 'child' ),
            'slug'  => 'dourado-principal',
            'color' => '#bba265',
        ),
        array(
            'name'  => __( 'Azul Escuro', 'child' ),
            'slug'  => 'azul-escuro',
            'color' => '#00305c',
        ),
        array(
            'name'  => __( 'Azul Médio', 'child' ),
            'slug'  => 'azul-medio',
            'color' => '#286090',
        ),
        array(
            'name'  => __( 'Cinza Claro', 'child' ),
            'slug'  => 'cinza-claro',
            'color' => '#d1d8e0',
        ),
         array(
            'name'  => __( 'Cinza Base', 'child' ),
            'slug'  => 'cinza-base',
            'color' => '#f2f3f5',
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

function emmovimento_customizer_register( $wp_customize ) {
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
add_action( 'customize_register', 'emmovimento_customizer_register' );


/**
 * Altera o número de posts por página no arquivo de "Revistas".
 */
function tema_emmovimento_limite_posts_revista( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'revista' ) ) {
        
        $query->set( 'posts_per_page', 8 );
    }
}
add_action( 'pre_get_posts', 'tema_emmovimento_limite_posts_revista' );

/**
 * Adiciona uma Paleta de Cores de Referência diretamente na seção "Cores" do Personalizador.
 *
 */
function meu_tema_filho_customizer_palette_section( $wp_customize ) {

    // ===== INÍCIO DA ALTERAÇÃO =====
    // Paleta de cores atualizada com as novas cores do tema.
    $color_palette = [
        'Dourado'           => '#bba265',
        'Azul Escuro'       => '#00305c',
        'Azul Médio'        => '#286090',
        'Cinza Claro'       => '#d1d8e0',
        'Cinza Base'        => '#f2f3f5',
        'Preto'             => '#000000',
        'Branco'            => '#ffffff',
    ];
    // ===== FIM DA ALTERAÇÃO =====


    //ADICIONA UM TÍTULO DENTRO DA SEÇÃO "CORES"
    $wp_customize->add_setting( 'meu_tema_paleta_header_setting' ); // Setting fantasma
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'meu_tema_paleta_header_control',
        [
            'section'     => 'colors', 
            'settings'    => 'meu_tema_paleta_header_setting',
            'type'        => 'hidden',
            'priority'    => 5, 
            'description' => '<hr><h3 style="margin-top:15px;">Paleta de Referência</h3><p class="description">Clique em uma cor para copiar o código.</p>',
        ]
    ) );


    // GERA O HTML DA PALETA DE CORES
    $palette_html = '<div id="custom-palette-container">';
    foreach ( $color_palette as $name => $hex_code ) {
        $border_style = ( strtolower( $hex_code ) === '#ffffff' || strtolower( $hex_code ) === '#f2f3f5' ) ? 'border: 1px solid #ddd;' : '';
        $palette_html .= sprintf(
            '<div class="custom-palette-swatch-wrapper" title="Clique para copiar %s">
                <div class="custom-palette-color-name">%s</div>
                <div class="custom-palette-color-box" style="background-color: %s; %s" data-hex-code="%s"></div>
                <div class="custom-palette-hex-code">%s</div>
            </div>',
            esc_attr( $hex_code ), esc_html( $name ), esc_attr( $hex_code ), $border_style, esc_attr( $hex_code ), esc_html( $hex_code )
        );
    }
    $palette_html .= '</div><div id="custom-palette-copy-feedback"></div>';


    //ADICIONA O CONTROLE DA PALETA DENTRO DA SEÇÃO "CORES"
    $wp_customize->add_setting( 'meu_tema_paleta_dummy_setting' ); // Setting fantasma
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'meu_tema_paleta_control',
        [
            'section'     => 'colors',
            'settings'    => 'meu_tema_paleta_dummy_setting',
            'type'        => 'hidden',
            'priority'    => 6, 
            'description' => $palette_html,
        ]
    ) );
}
add_action( 'customize_register', 'meu_tema_filho_customizer_palette_section' );


/**
 * Adiciona o CSS e o JavaScript necessários para a nossa paleta customizada.
 */
function meu_tema_customizer_palette_assets(){
    ?>
    <style>
        #custom-palette-container { display: flex; flex-wrap: wrap; gap: 10px; padding: 10px; background-color: #f0f0f1; border-radius: 4px; }
        .custom-palette-swatch-wrapper { flex-basis: calc(33.33% - 7px); text-align: center; } /* Ajustado para 3 colunas */
        .custom-palette-color-name { font-size: 12px; color: #50575e; margin-bottom: 4px; }
        .custom-palette-color-box { width: 100%; height: 50px; border-radius: 3px; cursor: pointer; transition: transform 0.1s ease-in-out; }
        .custom-palette-color-box:hover { transform: scale(1.05); box-shadow: 0 0 0 2px #fff, 0 0 0 4px #007cba; }
        .custom-palette-hex-code { font-family: monospace; font-size: 13px; margin-top: 4px; color: #50575e; }
        #custom-palette-copy-feedback { width: 100%; text-align: center; margin-top: 10px; font-weight: bold; color: #007cba; transition: opacity 0.3s; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Garante que o script só rode uma vez
            if (document.body.dataset.paletteScriptLoaded) return;
            document.body.dataset.paletteScriptLoaded = 'true';

            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('custom-palette-color-box')) {
                    const hexCode = event.target.getAttribute('data-hex-code');
                    navigator.clipboard.writeText(hexCode).then(function() {
                        let feedback = document.getElementById('custom-palette-copy-feedback');
                        if (feedback) {
                            feedback.textContent = 'Copiado: ' + hexCode;
                            setTimeout(() => { feedback.textContent = ''; }, 1500);
                        }
                    }, function(err) { console.error('Falha ao copiar o texto: ', err); });
                }
            });
        });
    </script>
    <?php
}
add_action( 'customize_controls_print_styles', 'meu_tema_customizer_palette_assets' );

/**
 * Função para enfileirar o script de abas customizadas (tabs)
 */
function enfileirar_script_abas_customizadas() {
    wp_enqueue_script( 
        'abas-customizadas-script', 
        get_stylesheet_directory_uri() . '/assets/javascript/abas-customizadas.js', 
        array('jquery'), 
        '1.0',          
        true           
    );
}
add_action( 'wp_enqueue_scripts', 'enfileirar_script_abas_customizadas' );


/**
 * Adiciona o script de rolagem do header transparente no rodapé do site,
 * apenas na página inicial e na página "Quem Somos".
 */
function meu_tema_filho_header_scroll_script() {

    // Condição para Home ou Quem Somos (Slug 'quem-somos')
    if ( ! is_front_page() && ! is_page('quem-somos') ) {
        return;
    }
    
    // Imprime o script no rodapé da página.
    ?>
    <script id="header-scroll-script">
        document.addEventListener("DOMContentLoaded", function() {
            
            // ... [Lógica para voltar ao topo] ...
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
            window.scrollTo(0, 0);
            // ...

            const header = document.getElementById('masthead');
            let heroSection = null;
            let triggerPoint = 0;

            // Tenta encontrar a seção Home (Carrossel Newspack)
            const isHome = document.body.classList.contains('home');
            heroSection = document.querySelector('.wp-block-newspack-blocks-carousel');

            if (heroSection) {
                // Se for a Home (Carrossel): Ativar o 'scrolled' quando rolar 60% da altura do carrossel.
                triggerPoint = heroSection.offsetHeight * 0.6; 
            } else {
                // Tenta encontrar o bloco de Cobertura (Para Quem Somos)
                heroSection = document.querySelector('.wp-block-cover'); 
                
                if (heroSection) {
                    // Se for a Cobertura: Ativar o 'scrolled' quando rolar 40% da altura da cobertura.
                    // Ajuste este percentual (0.4) conforme o tamanho do seu bloco de Cobertura.
                    triggerPoint = heroSection.offsetHeight * 0.4;
                }
            }

            // Se não encontrar o cabeçalho ou o elemento de gatilho, saia do script
            if (!header || !heroSection) {
                return;
            }
            
            // 💡 A LÓGICA PRINCIPAL DE SCROLL 💡
            function handleHeaderScroll() {
                if (window.scrollY > triggerPoint) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            }

            // Executa na carga (para o caso de já estar em alguma posição) e adiciona o listener.
            handleHeaderScroll();
            window.addEventListener('scroll', handleHeaderScroll);
        });
    </script>
    <?php
}
add_action( 'wp_footer', 'meu_tema_filho_header_scroll_script' );

/**
 * Injeta o CSS customizado diretamente na tela de login 
 * para sobrescrever o estilo inline.
 */
function meu_tema_filho_estilos_login_garantido() {
    // A classe 'body.login' é a mais básica e precisa do !important
    // para competir com um estilo inline aplicado diretamente ao <body>.
    ?>
    <style type="text/css">
        body.login {
            background-color: #00305c !important; /* Mude para sua cor ou use imagem! */
        }
        
        /* Opcional: A caixa de login em si pode precisar de um ajuste de fundo/sombra */
        .login form {
            background: #ffffff; /* Fundo do formulário para garantir contraste */
        }
    </style>
    <?php
}
// Este é o HOOK correto para a página de login
add_action( 'login_enqueue_scripts', 'meu_tema_filho_estilos_login_garantido' );

/**
 * Adiciona o resumo (excerpt) aos artigos dentro do bloco Newspack Carousel.
 *
 * @param string $block_content O HTML renderizado do bloco.
 * @param array  $block O array completo do bloco (nome, atributos, etc.).
 * @return string O HTML do bloco modificado.
 */
function meu_tema_filho_adicionar_resumo_carousel( $block_content, $block ) {
    if ( 'newspack-blocks/carousel' !== $block['blockName'] ) {
        return $block_content;
    }

    $excerpt_to_inject = '<div class="entry-excerpt">';

    preg_match( '/data-post-id="(\d+)"/', $block_content, $matches );

    if ( ! empty( $matches[1] ) ) {
        $post_id = intval( $matches[1] );
        
        // Temporariamente configura o post global para garantir que the_excerpt funcione.
        $original_post = $GLOBALS['post'];
        $GLOBALS['post'] = get_post( $post_id );
        setup_postdata( $GLOBALS['post'] );
        
        // Adquire o resumo (excerpt)
        $excerpt = get_the_excerpt( $post_id );
        
        // Remove quebras de linha e injeta a classe CSS customizada
        $excerpt_clean = '<div class="slide-excerpt">' . $excerpt . '</div>';
        
        // Reverte o post global.
        wp_reset_postdata();
        $GLOBALS['post'] = $original_post; 

        // 3. Injeta o resumo (excerpt) no HTML.
        // Tente injetar o excerpt logo após a tag de fechamento do título (</h3>).
        $h3_tag_pattern = '</h3>';
        $block_content = str_replace( $h3_tag_pattern, $h3_tag_pattern . $excerpt_clean, $block_content );
    }

    return $block_content;
}
add_filter( 'render_block', 'meu_tema_filho_adicionar_resumo_carousel', 10, 2 );

add_filter( 'gettext', 'traduzir_botao_carregar_mais_newspack', 20, 3 );

function traduzir_botao_carregar_mais_newspack( $translated_text, $text, $domain ) {
    
    // Verifica o texto exato que você encontrou (com 'm' minúsculo)
    // E o text domain mais provável do plugin.
    if ( 'Load more posts' === $text && 'newspack-blocks' === $domain ) {
        
        // Coloque a sua tradução aqui
        $translated_text = 'Carregar mais'; 
    }
    
    return $translated_text;
}

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
 * Adiciona o termo da taxonomia 'formato' ao lado da categoria no bloco Newspack.
 */
function adicionar_taxonomia_formato_newspack() {
    // Verifica se estamos no loop principal e se o post tem a taxonomia 'formato'.
    if ( is_single() || ! in_the_loop() ) {
        return;
    }

    $taxonomia = 'formato'; // Sua taxonomia personalizada.

    // Pega os termos para a taxonomia 'formato' no post atual.
    $termos = get_the_terms( get_the_ID(), $taxonomia );

    // Se houver termos, exibe-os.
    if ( $termos && ! is_wp_error( $termos ) ) {
        // Encontra o primeiro termo (geralmente é o que você quer para metadados).
        $termo = array_shift( $termos );

        // Cria o link do termo.
        $formato_link = sprintf(
            '<a href="%1$s">%2$s</a>',
            esc_url( get_term_link( $termo ) ),
            esc_html( $termo->name )
        );

        // Gera o HTML final para injetar.
        $html_injecao = '<div class="formato-links-newspack">' . $formato_link . '</div>';

        // Imprime o HTML, que deve aparecer antes de outras meta informações.
        echo $html_injecao;
    }
}

/**
 * Enfileira (enqueue) o script JavaScript para injetar o formato no bloco Newspack.
 */
function enfileirar_script_formato_newspack() {
    // Registra e enfileira o script.
    wp_enqueue_script(
        'newspack-formato-injector', // Nome do handle (identificador)
        get_stylesheet_directory_uri() . '/assets/javascript/newspack-formato-injector.js', // Caminho para o arquivo JS
        array('jquery'), // Dependências (garante que carrega depois do jQuery, se necessário)
        '1.0', // Versão
        true // Carrega o script no rodapé (footer) da página
    );
}
add_action( 'wp_enqueue_scripts', 'enfileirar_script_formato_newspack' );

/**
 * Exibe uma seção de posts relacionados com base na primeira categoria do post atual.
 *
 * @param array $args Argumentos para personalizar a saída.
 * 'posts_per_page' => (int) Número de posts a serem exibidos. Padrão 3.
 * 'title'          => (string) O título da seção. Padrão 'Relacionados'.
 */
function exibir_posts_relacionados_por_categoria( $args = [] ) {
    // Garante que a função só execute em páginas de post
    if ( ! is_single() ) {
        return;
    }

    global $post;
    $current_post_id = $post->ID;

    // Define os valores padrão para corresponder ao novo layout
    $defaults = [
        'posts_per_page' => 3, // O layout de exemplo tem 3 colunas
        'title'          => 'Relacionados', // O título na imagem
    ];
    // Mescla os argumentos passados com os padrões
    $args = wp_parse_args( $args, $defaults );

    // Pega as categorias do post atual
    $categories = get_the_category( $current_post_id );

    if ( empty( $categories ) ) {
        return; // Sai da função se o post não tiver categorias
    }

    $first_category_id = $categories[0]->term_id;

    // Argumentos para a consulta WP_Query
    $query_args = [
        'category__in'        => [ $first_category_id ],
        'post__not_in'        => [ $current_post_id ],
        'posts_per_page'      => intval( $args['posts_per_page'] ),
        'ignore_sticky_posts' => 1,
    ];

    $related_posts = new WP_Query( $query_args );

    // Se encontrar posts, exibe o HTML
    if ( $related_posts->have_posts() ) {
        echo '<section class="related-posts-section">'; // Usamos <section> para semântica
        echo '<div class="related-posts-container">';
        echo '<h2 class="related-posts-title">' . esc_html( $args['title'] ) . '</h2>';
        echo '<div class="related-posts-grid">';

        while ( $related_posts->have_posts() ) {
            $related_posts->the_post();
            // Pega a primeira categoria do post relacionado
            $related_post_categories = get_the_category();
            ?>
            <article class="related-post-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( ! empty( $related_post_categories ) ) : ?>
                        <span class="related-post-category"><?php echo esc_html( $related_post_categories[0]->name ); ?></span>
                    <?php endif; ?>
                    <h3 class="related-post-item-title"><?php the_title(); ?></h3>
                    <div class="related-post-excerpt">
                        <?php the_excerpt(); // Adiciona o resumo do post ?>
                    </div>
                </a>
            </article>
            <?php
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }

    // Restaura os dados do post original
    wp_reset_postdata();
}

// O WordPress por padrão adiciona [...] ao final do resumo. 
// Vamos remover isso para um visual mais limpo como na imagem.
add_filter( 'excerpt_more', '__return_empty_string' );

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
    if ( is_page_template('template-blog-com-filtros.php') || is_archive() ) {

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
        if ( is_archive() ) {
            $params['max_pages']     = $wp_query->max_num_pages;
            $params['initial_query'] = $wp_query->query_vars;

        // Se for a página de filtros, a initial_query permanece vazia.
        } elseif ( is_page_template('template-blog-com-filtros.php') ) {
            $posts_query = new WP_Query([
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => get_option('posts_per_page'),
            ]);
            $params['max_pages'] = $posts_query->max_num_pages;
            wp_reset_postdata();

            // Personaliza os parâmetros para o template de filtros
            $params['is_filter_page'] = true;
            $params['template_part']  = 'template-parts/content/content-excerpt';
            $params['container']      = '#posts-list-container';
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


/**
 * ===================================================================
 * SISTEMA UNIFICADO DE AJAX - VERSÃO FINAL E FUNCIONAL
 * ===================================================================
 */

// A função tema_unificado_ajax_scripts() continua a mesma, não precisa mexer.

/**
 * Manipulador AJAX unificado que responde a todas as requisições.
 * VERSÃO COM CATEGORIAS E FORMATOS ANTES DO TÍTULO
 */
function tema_unificado_ajax_handler() {
    ob_clean(); // ADICIONE ESTA LINHA PARA LIMPAR QUALQUER SAÍDA ANTERIOR

    // check_ajax_referer( 'unificado_ajax_nonce', 'nonce' );

    $paged    = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $formato  = isset($_POST['formato']) ? sanitize_text_field($_POST['formato']) : '';

    $args = [
        'paged'               => $paged,
        'post_status'         => 'publish',
        'post_type'           => 'post',
        'posts_per_page'      => get_option('posts_per_page'),
        'ignore_sticky_posts' => 1,
    ];

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
            get_template_part( 'template-parts/content/content-excerpt' );
        }
    } else {
        if ( 1 === $paged ) {
            echo '<p style="text-align: center; width: 100%;">Nenhum post encontrado com estes filtros.</p>';
        }
    }

    wp_reset_postdata();
    $html = ob_get_clean();

    $data_to_send = [
        'html' => $html,
        'max_pages' => $query->max_num_pages,
    ];

    wp_send_json_success( $data_to_send );
}
// Mantenha os add_action abaixo da função
add_action( 'wp_ajax_unificado_load_posts', 'tema_unificado_ajax_handler' );
add_action( 'wp_ajax_nopriv_unificado_load_posts', 'tema_unificado_ajax_handler' );