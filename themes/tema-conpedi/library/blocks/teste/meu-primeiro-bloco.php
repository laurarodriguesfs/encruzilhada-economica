<?php

/**

 * Plugin Name: Meu Primeiro Bloco

 */

 

defined( 'ABSPATH' ) || exit;

 

function init_meu_primeiro_bloco() {

	// JavaScript para o editor.

	wp_register_script(

		'meu-primeiro-bloco',

		plugins_url( 'meu-primeiro-bloco.js', __FILE__ ),

		array( 'wp-blocks', 'wp-element', 'wp-editor' ),

		filemtime( plugin_dir_path( __FILE__ ) . 'meu-primeiro-bloco.js' )

	);

 

	// CSS para o frontend e editor.

	wp_register_style(

		'meu-primeiro-bloco',

		plugins_url( 'frontend.css', __FILE__ ),

		array(),

		filemtime( plugin_dir_path( __FILE__ ) . 'frontend.css' )

	);

 

	// CSS para o editor.

	wp_register_style(

		'meu-primeiro-bloco-editor',

		plugins_url( 'editor.css', __FILE__ ),

		array( 'wp-edit-blocks' ),

		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )

	);

 

	// Registra o bloco.

	register_block_type(

		'teste/meu-primeiro-bloco',

		array(

			'style'         => 'meu-primeiro-bloco',

			'editor_style'  => 'meu-primeiro-bloco-editor',

			'editor_script' => 'meu-primeiro-bloco',

		)

	);

}

add_action( 'init', 'init_meu_primeiro_bloco' );