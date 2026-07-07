<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'rozholy_polylang_strings' );
function rozholy_polylang_strings(): void {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$strings = array(
		'footer_text'          => __( 'Copyright Text', 'rozholy' ),
		'header_cta_text'      => __( 'CTA Button Text', 'rozholy' ),
		'seo_business_name'    => __( 'Business Name', 'rozholy' ),
		'seo_business_address' => __( 'Business Address', 'rozholy' ),
	);

	foreach ( $strings as $key => $label ) {
		$value = rozholy_get_option( $key );
		if ( ! empty( $value ) ) {
			pll_register_string( $key, $value, 'Rozholy', true );
		}
	}
}

add_filter( 'sanitize_title', 'rozholy_persian_slugs', 9, 3 );
function rozholy_persian_slugs( string $title, string $raw_title, string $context ): string {
	if ( 'save' !== $context ) {
		return $title;
	}

	$o = rozholy_get_option( 'persian_slugs' );
	if ( '1' !== $o ) {
		return $title;
	}

	$persian_map = array(
		'آ' => 'ا',
		'ا' => 'a',
		'ب' => 'b',
		'پ' => 'p',
		'ت' => 't',
		'ث' => 's',
		'ج' => 'j',
		'چ' => 'ch',
		'ح' => 'h',
		'خ' => 'kh',
		'د' => 'd',
		'ذ' => 'z',
		'ر' => 'r',
		'ز' => 'z',
		'ژ' => 'zh',
		'س' => 's',
		'ش' => 'sh',
		'ص' => 's',
		'ض' => 'z',
		'ط' => 't',
		'ظ' => 'z',
		'ع' => '',
		'غ' => 'gh',
		'ف' => 'f',
		'ق' => 'gh',
		'ک' => 'k',
		'گ' => 'g',
		'ل' => 'l',
		'م' => 'm',
		'ن' => 'n',
		'و' => 'v',
		'ه' => 'h',
		'ی' => 'y',
		'ئ' => 'y',
		'ء' => '',
		'ة' => 't',
	);

	$title = strtr( mb_strtolower( $raw_title, 'UTF-8' ), $persian_map );
	$title = preg_replace( '/[^a-z0-9\-_\/]/', '-', $title );
	$title = preg_replace( '/-+/', '-', $title );
	$title = trim( $title, '-' );

	return $title;
}
