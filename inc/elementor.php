<?php
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	return;
}

add_action( 'after_setup_theme', 'rozholy_elementor_support' );
function rozholy_elementor_support() {
	add_theme_support( 'elementor' );

	if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
		add_theme_support( 'elementor-pro' );
	}
}

add_action( 'elementor/theme/register_locations', 'rozholy_register_elementor_locations' );
function rozholy_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}

add_action( 'elementor/page_templates/canvas/before_content', 'rozholy_elementor_canvas_before' );
add_action( 'elementor/page_templates/canvas/after_content', 'rozholy_elementor_canvas_after' );

function rozholy_elementor_canvas_before() {
	echo '<div class="rozholy-elementor-canvas">';
}

function rozholy_elementor_canvas_after() {
	echo '</div>';
}

add_action( 'elementor/elements/categories_registered', 'rozholy_elementor_category' );
function rozholy_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'rozholy',
		array(
			'title' => esc_html__( 'Rozholy', 'rozholy' ),
			'icon'  => 'eicon-gallery-grid',
		)
	);
}

add_action( 'elementor/widgets/register', 'rozholy_register_elementor_widgets' );
function rozholy_register_elementor_widgets( $widgets_manager ) {
	$widget_dir = get_template_directory() . '/inc/elementor/widgets';
	if ( is_dir( $widget_dir ) ) {
		foreach ( glob( $widget_dir . '/class-*.php' ) as $file ) {
			require_once $file;
		}
	}

	$widgets = array(
		'Rozholy_Header_Widget',
		'Rozholy_Footer_Widget',
		'Rozholy_Products_Widget',
		'Rozholy_Services_Widget',
	);

	foreach ( $widgets as $class ) {
		if ( class_exists( $class ) ) {
			$widgets_manager->register( new $class() );
		}
	}
}

add_filter( 'body_class', 'rozholy_elementor_body_class' );
function rozholy_elementor_body_class( $classes ) {
	if ( rozholy_is_elementor() ) {
		$classes[] = 'rozholy-elementor';
	}
	return $classes;
}

function rozholy_is_elementor() {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return false;
	}
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		if ( is_front_page() && 'page' === get_option( 'show_on_front', 'posts' ) ) {
			$post_id = (int) get_option( 'page_on_front', 0 );
		}
	}
	if ( ! $post_id ) {
		return false;
	}

	$document = \Elementor\Plugin::$instance->documents->get( $post_id );
	return $document && $document->is_built_with_elementor();
}

add_action( 'elementor/editor/before_enqueue_scripts', 'rozholy_elementor_editor_styles' );
function rozholy_elementor_editor_styles() {
	wp_enqueue_style( 'rozholy-editor', ROZHOLY_URI . '/assets/css/editor.css', array(), ROZHOLY_VERSION );
}

add_action( 'wp', 'rozholy_elementor_disable_fse' );
function rozholy_elementor_disable_fse() {
	if ( rozholy_is_elementor() ) {
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	}
}

add_action( 'elementor/theme/after_do_header', 'rozholy_elementor_after_header' );
function rozholy_elementor_after_header() {
	echo '<main class="rozholy-elementor-content">';
}

add_action( 'elementor/theme/before_do_footer', 'rozholy_elementor_before_footer' );
function rozholy_elementor_before_footer() {
	echo '</main>';
}
