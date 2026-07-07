<?php
defined( 'ABSPATH' ) || exit;

/* ── Remove WP version from head and feeds ── */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/* ── Disable XML-RPC ── */
add_filter( 'xmlrpc_enabled', '__return_false' );

/* ── Unified login error message ── */
add_filter( 'login_errors', 'rozholy_login_errors' );
function rozholy_login_errors() {
	return __( 'اطلاعات وارد شده صحیح نیست. لطفا دوباره تلاش کنید.', 'rozholy' );
}

/* ── Remove Windows Live Writer manifest ── */
remove_action( 'wp_head', 'wlwmanifest_link' );

/* ── Remove RSD link ── */
remove_action( 'wp_head', 'rsd_link' );

/* ── Remove shortlink ── */
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/* ── Disable REST API user endpoint for non-authenticated ── */
add_filter( 'rest_authentication_errors', 'rozholy_rest_auth' );
function rozholy_rest_auth( $result ) {
	if ( ! empty( $result ) ) {
		return $result;
	}

	if ( ! is_user_logged_in() ) {
		$rest_route = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		if ( strpos( $rest_route, '/wp/v2/users' ) !== false ) {
			return new WP_Error( 'rest_not_logged_in', __( 'You must be logged in to access this endpoint.', 'rozholy' ), array( 'status' => 401 ) );
		}
	}

	return $result;
}
