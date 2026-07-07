<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'rozholy_setup' );
function rozholy_setup() {
	load_theme_textdomain( 'rozholy', ROZHOLY_DIR . '/languages' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-spacing' );
	add_theme_support( 'custom-units' );
	add_theme_support( 'link-color' );
	add_theme_support( 'appearance-tools' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'rozholy-card', 400, 300, true );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 280,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support(
		'custom-header',
		array(
			'default-image' => '',
			'width'         => 1920,
			'height'        => 600,
			'flex-height'   => true,
			'header-text'   => false,
		)
	);

	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'faf5f0',
		)
	);

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

	add_theme_support( 'automatic-feed-links' );

	if ( class_exists( 'WooCommerce' ) ) {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	register_nav_menus(
		array(
			'primary' => esc_html__( 'منوی اصلی', 'rozholy' ),
			'footer'  => esc_html__( 'منوی فوتر', 'rozholy' ),
		)
	);
}

add_action( 'after_setup_theme', 'rozholy_content_width', 0 );
function rozholy_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rozholy_content_width', 1200 );
}
