<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'rozholy_disable_emoji' );
function rozholy_disable_emoji(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
}

add_filter( 'wp_headers', 'rozholy_disable_emoji_dns_prefetch' );
function rozholy_disable_emoji_dns_prefetch( array $headers ): array {
	if ( is_admin() ) {
		return $headers;
	}
	unset( $headers['Link'] );
	return $headers;
}

add_action( 'init', 'rozholy_throttle_heartbeat' );
function rozholy_throttle_heartbeat(): void {
	if ( is_admin() ) {
		return;
	}
	add_filter(
		'heartbeat_settings',
		function ( array $settings ): array {
			$settings['interval'] = 60;
			return $settings;
		}
	);
}

add_action( 'wp_enqueue_scripts', 'rozholy_preload_fonts', 1 );
function rozholy_preload_fonts(): void {
	$fonts = array(
		'vazirmatn-arabic.woff2' => 'Vazirmatn',
	);

	foreach ( $fonts as $file => $family ) {
		$path = ROZHOLY_URI . '/assets/fonts/' . $file;
		echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url( $path ) . '" crossorigin>' . "\n";
	}
}

add_filter( 'style_loader_tag', 'rozholy_defer_block_styles', 10, 4 );
function rozholy_defer_block_styles( string $html, string $handle, string $href, string $media ): string {
	if ( str_starts_with( $handle, 'wp-block-' ) && 'print' !== $media ) {
		$html = str_replace(
			"media='all'",
			"media='print' onload=\"this.media='all'\"",
			$html
		);
	}
	return $html;
}

add_action( 'wp_default_scripts', 'rozholy_move_jquery_to_footer' );
function rozholy_move_jquery_to_footer( WP_Scripts $scripts ): void {
	if ( is_admin() ) {
		return;
	}
	$scripts->add_data( 'jquery', 'group', 1 );
	$scripts->add_data( 'jquery-core', 'group', 1 );
	$scripts->add_data( 'jquery-migrate', 'group', 1 );
}

add_action( 'after_setup_theme', 'rozholy_add_fetchpriority_support' );
function rozholy_add_fetchpriority_support(): void {
	add_theme_support( 'post-thumbnails' );
}
