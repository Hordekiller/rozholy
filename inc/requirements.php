<?php
defined( 'ABSPATH' ) || exit;

define( 'ROZHOLY_MIN_PHP', '7.4' );
define( 'ROZHOLY_MIN_WP', '6.4' );

add_action( 'admin_init', 'rozholy_check_requirements' );
function rozholy_check_requirements(): void {
	if ( version_compare( PHP_VERSION, ROZHOLY_MIN_PHP, '<' ) || version_compare( get_bloginfo( 'version' ), ROZHOLY_MIN_WP, '<' ) ) {
		add_action( 'admin_notices', 'rozholy_requirements_notice' );
	}
}

function rozholy_requirements_notice(): void {
	$message = sprintf(
		esc_html__( 'Rozholy theme requires PHP %1$s+ and WordPress %2$s+. Your server runs PHP %3$s and WordPress %4$s.', 'rozholy' ),
		ROZHOLY_MIN_PHP,
		ROZHOLY_MIN_WP,
		PHP_VERSION,
		get_bloginfo( 'version' )
	);
	echo '<div class="notice notice-error"><p>' . $message . '</p></div>';
}

add_filter( 'xmlrpc_enabled', '__return_false' );

add_filter( 'the_generator', '__return_empty_string' );

add_action( 'send_headers', 'rozholy_security_headers' );
function rozholy_security_headers(): void {
	if ( is_admin() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}

function rozholy_log( string $message, string $level = 'notice' ): void {
	if ( ! defined( 'WP_DEBUG_LOG' ) || ! WP_DEBUG_LOG ) {
		return;
	}
	$trace  = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2 );
	$caller = $trace[1] ?? $trace[0] ?? array();
	$file   = basename( $caller['file'] ?? 'unknown' );
	$line   = $caller['line'] ?? 0;
	error_log( sprintf( '[Rozholy][%s] %s (%s:%d)', strtoupper( $level ), $message, $file, $line ) );
}
