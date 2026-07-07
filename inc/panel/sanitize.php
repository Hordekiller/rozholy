<?php
defined( 'ABSPATH' ) || exit;

function rozholy_option_manifest(): array {
	return array(
		'schema_version'       => array(
			'type'    => 'number',
			'default' => 1,
		),
		'primary_color'        => array( 'type' => 'color' ),
		'primary_dark'         => array( 'type' => 'color' ),
		'primary_light'        => array( 'type' => 'color' ),
		'secondary_color'      => array( 'type' => 'color' ),
		'secondary_dark'       => array( 'type' => 'color' ),
		'accent_gold'          => array( 'type' => 'color' ),
		'accent_light'         => array( 'type' => 'color' ),
		'base_bg'              => array( 'type' => 'color' ),
		'base_alt'             => array( 'type' => 'color' ),
		'dark_color'           => array( 'type' => 'color' ),
		'text_color'           => array( 'type' => 'color' ),
		'text_light'           => array( 'type' => 'color' ),
		'border_color'         => array( 'type' => 'color' ),
		'heading_font'         => array(
			'type'    => 'select',
			'choices' => array( 'playfair', 'dancing', 'vazirmatn', 'system' ),
		),
		'body_font'            => array(
			'type'    => 'select',
			'choices' => array( 'vazirmatn', 'playfair', 'system' ),
		),
		'base_font_size'       => array(
			'type' => 'number',
			'min'  => 12,
			'max'  => 24,
		),
		'heading_weight'       => array(
			'type'    => 'select',
			'choices' => array( '400', '500', '600', '700', '800', '900' ),
		),
		'header_layout'        => array(
			'type'    => 'select',
			'choices' => array( 'default', 'transparent' ),
		),
		'sticky_header'        => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'header_cta_text'      => array( 'type' => 'text' ),
		'header_cta_url'       => array( 'type' => 'url' ),
		'header_search'        => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'footer_layout'        => array(
			'type' => 'number',
			'min'  => 1,
			'max'  => 4,
		),
		'footer_text'          => array( 'type' => 'html' ),
		'footer_social'        => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'footer_bg'            => array( 'type' => 'color' ),
		'social_instagram'     => array( 'type' => 'url' ),
		'social_telegram'      => array( 'type' => 'url' ),
		'social_whatsapp'      => array( 'type' => 'url' ),
		'social_youtube'       => array( 'type' => 'url' ),
		'social_facebook'      => array( 'type' => 'url' ),
		'social_twitter'       => array( 'type' => 'url' ),
		'social_linkedin'      => array( 'type' => 'url' ),
		'social_pinterest'     => array( 'type' => 'url' ),
		'content_width'        => array(
			'type' => 'number',
			'min'  => 600,
			'max'  => 1400,
		),
		'wide_width'           => array(
			'type' => 'number',
			'min'  => 800,
			'max'  => 1600,
		),
		'blog_columns'         => array(
			'type'    => 'select',
			'choices' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		),
		'shop_columns'         => array(
			'type'    => 'select',
			'choices' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		),
		'products_per_page'    => array(
			'type' => 'number',
			'min'  => 3,
			'max'  => 48,
		),
		'show_hero'            => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_services'        => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_testimonials'    => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_gallery'         => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_booking'         => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_contact'         => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'excerpt_length'       => array(
			'type' => 'number',
			'min'  => 10,
			'max'  => 100,
		),
		'show_author'          => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_date'            => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_categories'      => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_tags'            => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_thumb'           => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'show_comments'        => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'button_radius'        => array(
			'type' => 'number',
			'min'  => 0,
			'max'  => 50,
		),
		'button_hover'         => array(
			'type'    => 'select',
			'choices' => array( 'brighten', 'darken', 'scale', 'none' ),
		),
		'dashboard_page'       => array(
			'type' => 'number',
			'min'  => 0,
		),
		'avatar_size'          => array(
			'type' => 'number',
			'min'  => 32,
			'max'  => 200,
		),
		'motion_intensity'     => array(
			'type'    => 'select',
			'choices' => array( 'full', 'subtle', 'off' ),
		),
		'parallax'             => array(
			'type'    => 'select',
			'choices' => array( 'on', 'off' ),
		),
		'persian_slugs'        => array(
			'type'           => 'checkbox',
			'checkbox_label' => __( 'Convert Persian slug characters to Latin (Pinglish)', 'rozholy' ),
		),
		'seo_business_name'    => array( 'type' => 'text' ),
		'seo_business_address' => array( 'type' => 'text' ),
		'seo_business_phone'   => array( 'type' => 'text' ),
		'seo_enamad_code'      => array( 'type' => 'html' ),
		'custom_css'           => array( 'type' => 'css' ),
		'header_scripts'       => array( 'type' => 'scripts' ),
		'footer_scripts'       => array( 'type' => 'scripts' ),
	);
}

function rozholy_sanitize_options( array $input ): array {
	$manifest = rozholy_option_manifest();
	$defaults = rozholy_default_options();
	$clean    = $defaults;

	foreach ( $manifest as $key => $rule ) {
		if ( ! array_key_exists( $key, $input ) ) {
			continue;
		}
		$value = $input[ $key ];

		switch ( $rule['type'] ) {
			case 'text':
				$clean[ $key ] = sanitize_text_field( $value );
				break;
			case 'html':
				$allowed       = $key === 'seo_enamad_code'
					? array(
						'img' => array(
							'src'    => array(),
							'alt'    => array(),
							'width'  => array(),
							'height' => array(),
							'dir'    => array(),
							'lang'   => array(),
						),
						'a'   => array(
							'href'  => array(),
							'title' => array(),
							'rel'   => array(),
							'dir'   => array(),
							'lang'  => array(),
						),
					)
					: array();
				$clean[ $key ] = empty( $allowed ) ? wp_kses_post( $value ) : wp_kses( $value, $allowed );
				break;
			case 'url':
				$clean[ $key ] = esc_url_raw( $value );
				break;
			case 'color':
				$sanitized     = sanitize_hex_color( $value );
				$clean[ $key ] = $sanitized ?: $defaults[ $key ];
				break;
			case 'number':
				$num = floatval( $value );
				if ( isset( $rule['min'] ) ) {
					$num = max( $rule['min'], $num );
				}
				if ( isset( $rule['max'] ) ) {
					$num = min( $rule['max'], $num );
				}
				$clean[ $key ] = $num;
				break;
			case 'select':
				$choices = array_values( $rule['choices'] );
				if ( in_array( (string) $value, $choices, true ) ) {
					$clean[ $key ] = $value;
				} else {
					$clean[ $key ] = $defaults[ $key ];
					add_settings_error(
						'rozholy_options',
						$key . '_invalid',
						sprintf( __( 'Invalid value for "%s". Reset to default.', 'rozholy' ), $key )
					);
				}
				break;
			case 'checkbox':
				$clean[ $key ] = $value ? '1' : '0';
				break;
			case 'image':
				$clean[ $key ] = absint( $value );
				break;
			case 'css':
				$clean[ $key ] = wp_strip_all_tags( $value );
				break;
			case 'scripts':
				$clean[ $key ] = wp_kses(
					$value,
					array(
						'script'   => array(
							'src'   => array(),
							'async' => array(),
							'defer' => array(),
							'type'  => array(),
						),
						'meta'     => array(
							'name'     => array(),
							'content'  => array(),
							'property' => array(),
							'charset'  => array(),
						),
						'link'     => array(
							'href'        => array(),
							'rel'         => array(),
							'type'        => array(),
							'media'       => array(),
							'crossorigin' => array(),
						),
						'noscript' => array(),
						'style'    => array( 'type' => array() ),
						'iframe'   => array(
							'src'     => array(),
							'width'   => array(),
							'height'  => array(),
							'style'   => array(),
							'allow'   => array(),
							'loading' => array(),
						),
					)
				);
				break;
			default:
				$clean[ $key ] = sanitize_text_field( $value );
		}
	}

	$clean['schema_version'] = $defaults['schema_version'];

	return $clean;
}
