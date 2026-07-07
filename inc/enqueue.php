<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'rozholy_enqueue_scripts' );
function rozholy_enqueue_scripts() {
	wp_enqueue_style( 'rozholy-style', get_stylesheet_uri(), array(), ROZHOLY_VERSION );

	if ( is_rtl() ) {
		wp_enqueue_style( 'rozholy-rtl', ROZHOLY_URI . '/assets/css/main-rtl.css', array( 'rozholy-style' ), ROZHOLY_VERSION );
	}

	$is_elementor = defined( 'ELEMENTOR_VERSION' ) && rozholy_is_elementor();
	$is_dashboard = is_page_template( 'page-dashboard.php' );

	if ( ! $is_elementor ) {
		$motion = rozholy_get_option( 'motion_intensity' );
		if ( 'off' !== $motion ) {
			wp_enqueue_style( 'rozholy-animations', ROZHOLY_URI . '/assets/css/animations.css', array( 'rozholy-style' ), ROZHOLY_VERSION );
		}
		wp_enqueue_style( 'rozholy-wow', ROZHOLY_URI . '/assets/css/wow.css', array( 'rozholy-style' ), ROZHOLY_VERSION );
	}
	wp_enqueue_style( 'rozholy-responsive', ROZHOLY_URI . '/assets/css/responsive.css', array( 'rozholy-style' ), ROZHOLY_VERSION );

	wp_enqueue_script( 'rozholy-navigation', ROZHOLY_URI . '/assets/js/navigation.js', array(), ROZHOLY_VERSION, array( 'strategy' => 'defer' ) );

	if ( ! $is_elementor && ! $is_dashboard && ! is_customize_preview() ) {
		wp_enqueue_script( 'rozholy-wow', ROZHOLY_URI . '/assets/js/wow.js', array(), ROZHOLY_VERSION, array( 'strategy' => 'defer' ) );
	}

	if ( is_page_template( 'page-dashboard.php' ) ) {
		wp_enqueue_style( 'rozholy-dashboard', ROZHOLY_URI . '/assets/css/dashboard.css', array( 'rozholy-style' ), ROZHOLY_VERSION );
		wp_enqueue_script( 'rozholy-dashboard', ROZHOLY_URI . '/assets/js/dashboard.js', array(), ROZHOLY_VERSION, true );

		wp_localize_script(
			'rozholy-dashboard',
			'rozholyDashboard',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'rozholy_dashboard_nonce' ),
			)
		);
	}

	if ( 'on' === rozholy_get_option( 'mobile_bottom_nav', 'on' ) ) {
		wp_enqueue_style( 'rozholy-bottom-nav', ROZHOLY_URI . '/assets/css/bottom-nav.css', array( 'rozholy-style' ), ROZHOLY_VERSION );
		wp_enqueue_script( 'rozholy-bottom-nav', ROZHOLY_URI . '/assets/js/bottom-nav.js', array(), ROZHOLY_VERSION, array( 'strategy' => 'defer' ) );
		if ( class_exists( 'WooCommerce' ) ) {
			wp_add_inline_script( 'rozholy-bottom-nav', 'window.rzCartBadgeUrl = "' . esc_url( rest_url( 'rozholy-companion/v1/cart-count' ) ) . '";' );
		}
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( class_exists( 'WooCommerce' ) && ! is_admin() ) {
		wp_enqueue_script( 'rozholy-woo-custom', ROZHOLY_URI . '/assets/js/woo-custom.js', array(), ROZHOLY_VERSION, array( 'strategy' => 'defer' ) );

		wp_localize_script(
			'rozholy-woo-custom',
			'rozholyWoo',
			array(
				'cartCount' => WC()->cart ? WC()->cart->get_cart_contents_count() : 0,
				'i18n'      => array(
					'added' => __( 'Added to cart!', 'rozholy' ),
				),
			)
		);
	}
}

add_action( 'enqueue_block_editor_assets', 'rozholy_block_editor_assets' );
function rozholy_block_editor_assets() {
	wp_enqueue_style( 'rozholy-editor', ROZHOLY_URI . '/assets/css/editor.css', array(), ROZHOLY_VERSION );
}

add_action( 'customize_preview_init', 'rozholy_customizer_preview' );
function rozholy_customizer_preview() {
	wp_enqueue_script( 'rozholy-customizer', ROZHOLY_URI . '/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), ROZHOLY_VERSION, array( 'strategy' => 'defer' ) );
}

add_action( 'wp_enqueue_scripts', 'rozholy_enqueue_woo_conditional', 9 );
function rozholy_enqueue_woo_conditional() {
	if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
		wp_enqueue_style( 'rozholy-woocommerce', ROZHOLY_URI . '/assets/css/woocommerce.css', array( 'rozholy-style' ), ROZHOLY_VERSION );
	}
}
