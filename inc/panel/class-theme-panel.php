<?php
defined( 'ABSPATH' ) || exit;

require_once get_template_directory() . '/inc/panel/defaults.php';
require_once get_template_directory() . '/inc/panel/sanitize.php';

if ( is_admin() || is_customize_preview() ) {
	require_once get_template_directory() . '/inc/panel/settings-page.php';
	require_once get_template_directory() . '/inc/panel/import-export.php';

	/* Load custom customizer controls */
	$controls_dir = get_template_directory() . '/inc/panel/customizer-controls';
	if ( is_dir( $controls_dir ) ) {
		foreach ( glob( $controls_dir . '/*.php' ) as $ctrl_file ) {
			require_once $ctrl_file;
		}
	}
}

/* ── Enqueue customize-preview.js for live preview ── */
add_action( 'customize_preview_init', 'rozholy_customize_preview_js' );
function rozholy_customize_preview_js(): void {
	wp_enqueue_script(
		'rozholy-customize-preview',
		ROZHOLY_URI . '/assets/js/customize-preview.js',
		array( 'jquery', 'customize-preview' ),
		ROZHOLY_VERSION,
		true
	);
}

/* ── Generate inline CSS from options ── */
function rozholy_generate_inline_css(): string {
	$css_ver     = (string) get_option( 'rozholy_css_cache_ver', '1' );
	$lang_suffix = function_exists( 'pll_current_language' ) ? '_' . pll_current_language() : '';
	$cache_key   = 'rozholy_css_' . $css_ver . $lang_suffix;
	$cached      = get_transient( $cache_key );
	if ( false !== $cached ) {
		return $cached;
	}

	$o   = rozholy_get_all_options();
	$css = ':root {' . "\n";

	$color_map = array(
		'primary_color'   => '--rz-primary-color',
		'primary_dark'    => '--rz-primary-dark',
		'primary_light'   => '--rz-primary-light',
		'secondary_color' => '--rz-secondary-color',
		'secondary_dark'  => '--rz-secondary-dark',
		'accent_gold'     => '--rz-accent-gold',
		'accent_light'    => '--rz-accent-light',
		'base_bg'         => '--rz-base-bg',
		'base_alt'        => '--rz-base-alt',
		'dark_color'      => '--rz-dark-color',
		'text_color'      => '--rz-text-color',
		'text_light'      => '--rz-text-light',
		'border_color'    => '--rz-border-color',
		'footer_bg'       => '--rz-footer-bg',
	);

	foreach ( $color_map as $key => $var ) {
		if ( ! empty( $o[ $key ] ) ) {
			$css .= sprintf( "  %s: %s;\n", $var, $o[ $key ] );
		}
	}

	$fonts = array(
		'playfair'  => "'Playfair Display', Georgia, serif",
		'dancing'   => "'Dancing Script', 'Brush Script MT', cursive",
		'vazirmatn' => "'Vazirmatn', 'Vazirmatn Fallback', 'IRANSans', Tahoma, sans-serif",
		'system'    => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif",
	);

	$heading = $fonts[ $o['heading_font'] ] ?? $fonts['playfair'];
	$body    = $fonts[ $o['body_font'] ] ?? $fonts['vazirmatn'];
	$css    .= sprintf( "  --rz-heading-font: %s;\n", $heading );
	$css    .= sprintf( "  --rz-body-font: %s;\n", $body );
	$css    .= sprintf( "  --rz-font-playfair: %s;\n", $fonts['playfair'] );
	$css    .= sprintf( "  --rz-font-dancing: %s;\n", $fonts['dancing'] );
	$css    .= sprintf( "  --rz-font-vazirmatn: %s;\n", $fonts['vazirmatn'] );
	$css    .= sprintf( "  --rz-font-system: %s;\n", $fonts['system'] );

	/* Typography */
	$css .= sprintf( "  --rz-base-font-size: %dpx;\n", $o['base_font_size'] );
	$css .= sprintf( "  --rz-heading-weight: %d;\n", $o['heading_weight'] );

	/* Layout */
	$css .= sprintf( "  --rz-content-width: %dpx;\n", $o['content_width'] );
	$css .= sprintf( "  --rz-wide-width: %dpx;\n", $o['wide_width'] );
	$css .= sprintf( "  --rz-button-radius: %dpx;\n", $o['button_radius'] );

	$css .= "}\n";

	$css .= "/* Font fallback: Tahoma size-adjust for Persian glyphs */\n";
	$css .= "@font-face {\n";
	$css .= "  font-family: 'Vazirmatn Fallback';\n";
	$css .= "  src: local('Tahoma');\n";
	$css .= "  size-adjust: 98%;\n";
	$css .= "  ascent-override: 78%;\n";
	$css .= "  descent-override: 22%;\n";
	$css .= "  line-gap-override: 0%;\n";
	$css .= "}\n";

	/* Custom CSS from advanced tab */
	if ( ! empty( $o['custom_css'] ) ) {
		$css .= "\n" . wp_strip_all_tags( $o['custom_css'] ) . "\n";
	}

	set_transient( $cache_key, $css, DAY_IN_SECONDS );

	return $css;
}

/* ── Output inline CSS on frontend ── */
add_action( 'wp_enqueue_scripts', 'rozholy_output_inline_css', 100 );
function rozholy_output_inline_css(): void {
	$css = rozholy_generate_inline_css();
	if ( ! empty( $css ) ) {
		wp_register_style( 'rozholy-inline', false, array(), ROZHOLY_VERSION );
		wp_enqueue_style( 'rozholy-inline' );
		wp_add_inline_style( 'rozholy-inline', $css );
	}
}

/* ── Bust CSS transient when options are saved ── */
add_action( 'update_option_rozholy_options', 'rozholy_bust_css_cache' );
function rozholy_bust_css_cache(): void {
	$new_ver = (string) ( (int) get_option( 'rozholy_css_cache_ver', '1' ) + 1 );
	update_option( 'rozholy_css_cache_ver', $new_ver );
}
