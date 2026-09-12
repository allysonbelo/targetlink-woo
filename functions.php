<?php
/**
 * TargetLink Woo Demo functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Setup Theme and WooCommerce Support
 */
function targetlink_woo_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// WooCommerce Support - ESSENCIAL PARA A VAGA
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 300,
		'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
	) );

    // WooCommerce Features
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'targetlink_woo_setup' );

/**
 * Enqueue scripts and styles.
 */
function targetlink_woo_scripts() {
	wp_enqueue_style( 'targetlink-woo-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    // Podemos enfileirar JS aqui depois para otimizações específicas de checkout
}
add_action( 'wp_enqueue_scripts', 'targetlink_woo_scripts' );

/**
 * Remover CSS padrão do WordPress que não usamos para melhorar velocidade (Performance Requirement)
 */
function targetlink_woo_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove blocks do Woo se for usar layout classico focado em vel
}
// Descomentar a linha abaixo para habilitar otimização extrema de CSS
// add_action( 'wp_enqueue_scripts', 'targetlink_woo_remove_wp_block_library_css', 100 );
