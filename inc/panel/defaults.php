<?php
defined( 'ABSPATH' ) || exit;

function rozholy_default_options(): array {
	return array(
		'schema_version'         => 2,
		/* Colors */
		'primary_color'          => '#d4a0a0',
		'primary_dark'           => '#c08080',
		'primary_light'          => '#f0d0d0',
		'secondary_color'        => '#b8a0c0',
		'secondary_dark'         => '#9870a8',
		'accent_gold'            => '#c8a87c',
		'accent_light'           => '#e8d0b8',
		'base_bg'                => '#faf5f0',
		'base_alt'               => '#f5ece4',
		'dark_color'             => '#2d2d2d',
		'text_color'             => '#4a4a4a',
		'text_light'             => '#7a7a7a',
		'border_color'           => '#e8ddd5',
		/* Typography */
		'heading_font'           => 'playfair',
		'body_font'              => 'vazirmatn',
		'base_font_size'         => 16,
		'heading_weight'         => 700,
		/* Header */
		'header_layout'          => 'default',
		'sticky_header'          => 'on',
		'header_cta_text'        => '',
		'header_cta_url'         => '#',
		'header_search'          => 'on',
		/* Footer */
		'footer_layout'          => 4,
		'footer_text'            => '© 2026 Rozholy. تمامی حقوق محفوظ است.',
		'footer_social'          => 'on',
		'footer_bg'              => '#2d2d2d',
		/* Social */
		'social_instagram'       => '',
		'social_telegram'        => '',
		'social_whatsapp'        => '',
		'social_youtube'         => '',
		'social_facebook'        => '',
		'social_twitter'         => '',
		'social_linkedin'        => '',
		'social_pinterest'       => '',
		/* Layout */
		'content_width'          => 800,
		'wide_width'             => 1200,
		'blog_columns'           => 3,
		'shop_columns'           => 3,
		'products_per_page'      => 12,
		/* Homepage */
		'show_hero'              => 'on',
		'show_services'          => 'on',
		'show_testimonials'      => 'on',
		'show_gallery'           => 'on',
		'show_booking'           => 'on',
		'show_contact'           => 'on',
		/* Blog */
		'excerpt_length'         => 25,
		'show_author'            => 'on',
		'show_date'              => 'on',
		'show_categories'        => 'on',
		'show_tags'              => 'on',
		'show_thumb'             => 'on',
		'show_comments'          => 'on',
		/* Buttons */
		'button_radius'          => 9999,
		'button_hover'           => 'brighten',
		/* Dashboard */
		'dashboard_page'         => 0,
		'avatar_size'            => 80,
		/* Motion */
		'motion_intensity'       => 'full',
		'parallax'               => 'on',
		/* SEO */
		'persian_slugs'          => '0',
		'seo_business_name'      => '',
		'seo_business_address'   => '',
		'seo_business_phone'     => '',
		'seo_enamad_code'        => '',
		/* Bottom Nav */
		'mobile_bottom_nav'      => 'on',
		'bottom_nav_home'        => 'on',
		'bottom_nav_services'    => 'on',
		'bottom_nav_booking'     => 'on',
		'bottom_nav_shop'        => 'on',
		'bottom_nav_account'     => 'on',
		'bottom_nav_hide_scroll' => 'on',
		/* Advanced */
		'custom_css'             => '',
		'header_scripts'         => '',
		'footer_scripts'         => '',
	);
}

function rozholy_get_option( string $key, mixed $fallback = null ): mixed {
	$options = rozholy_get_all_options();
	return $options[ $key ] ?? $fallback;
}

function rozholy_get_all_options(): array {
	return wp_parse_args(
		(array) get_option( 'rozholy_options', array() ),
		rozholy_default_options()
	);
}

add_action( 'after_switch_theme', 'rozholy_theme_activation' );
function rozholy_theme_activation(): void {
	$saved   = (array) get_option( 'rozholy_options', array() );
	$version = (int) ( $saved['schema_version'] ?? 0 );

	if ( $version >= 2 ) {
		return;
	}

	if ( $version < 2 ) {
		$theme_mod_keys = array(
			'rozholy_primary_color'    => 'primary_color',
			'rozholy_secondary_color'  => 'secondary_color',
			'rozholy_accent_gold'      => 'accent_gold',
			'rozholy_heading_font'     => 'heading_font',
			'rozholy_body_font'        => 'body_font',
			'rozholy_header_layout'    => 'header_layout',
			'rozholy_sticky_header'    => 'sticky_header',
			'rozholy_header_cta_text'  => 'header_cta_text',
			'rozholy_header_cta_url'   => 'header_cta_url',
			'rozholy_footer_layout'    => 'footer_layout',
			'rozholy_footer_text'      => 'footer_text',
			'rozholy_social_instagram' => 'social_instagram',
			'rozholy_social_telegram'  => 'social_telegram',
			'rozholy_content_width'    => 'content_width',
			'rozholy_blog_columns'     => 'blog_columns',
			'rozholy_shop_columns'     => 'shop_columns',
			'rozholy_excerpt_length'   => 'excerpt_length',
			'rozholy_dashboard_page'   => 'dashboard_page',
			'rozholy_custom_css'       => 'custom_css',
			'rozholy_motion_intensity' => 'motion_intensity',
			'rozholy_parallax'         => 'parallax',
		);
		$defaults       = rozholy_default_options();
		$migrated       = false;

		foreach ( $theme_mod_keys as $mod => $opt_key ) {
			$mod_value = get_theme_mod( $mod, '__NOTSET__' );
			if ( '__NOTSET__' !== $mod_value && $mod_value !== $defaults[ $opt_key ] ) {
				$saved[ $opt_key ] = $mod_value;
				$migrated          = true;
			}
		}

		$saved['schema_version'] = 2;
		update_option( 'rozholy_options', $saved );

		if ( $migrated ) {
			foreach ( array_keys( $theme_mod_keys ) as $mod ) {
				remove_theme_mod( $mod );
			}
		}
	}
}
