<?php
defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', 'rozholy_customize_register' );
function rozholy_customize_register( $wp_customize ) {

	$wp_customize->add_panel(
		'rozholy_theme_options',
		array(
			'title'       => esc_html__( 'Rozholy Settings', 'rozholy' ),
			'description' => esc_html__( 'All theme settings stored in a single options array.', 'rozholy' ),
			'priority'    => 30,
		)
	);

	$sections = array(
		'rozholy_colors'     => array(
			'title'    => __( 'Colors', 'rozholy' ),
			'priority' => 10,
		),
		'rozholy_typography' => array(
			'title'    => __( 'Typography', 'rozholy' ),
			'priority' => 15,
		),
		'rozholy_header'     => array(
			'title'    => __( 'Header', 'rozholy' ),
			'priority' => 20,
		),
		'rozholy_footer'     => array(
			'title'    => __( 'Footer', 'rozholy' ),
			'priority' => 30,
		),
		'rozholy_social'     => array(
			'title'    => __( 'Social Links', 'rozholy' ),
			'priority' => 40,
		),
		'rozholy_layout'     => array(
			'title'    => __( 'Layout', 'rozholy' ),
			'priority' => 45,
		),
		'rozholy_homepage'   => array(
			'title'    => __( 'Homepage', 'rozholy' ),
			'priority' => 48,
		),
		'rozholy_blog'       => array(
			'title'    => __( 'Blog', 'rozholy' ),
			'priority' => 50,
		),
		'rozholy_buttons'    => array(
			'title'    => __( 'Buttons', 'rozholy' ),
			'priority' => 52,
		),
		'rozholy_dashboard'  => array(
			'title'    => __( 'Dashboard', 'rozholy' ),
			'priority' => 55,
		),
		'rozholy_motion'     => array(
			'title'    => __( 'Motion', 'rozholy' ),
			'priority' => 60,
		),
		'rozholy_bottom_nav' => array(
			'title'    => __( 'Mobile Bottom Nav', 'rozholy' ),
			'priority' => 65,
		),
		'rozholy_advanced'   => array(
			'title'    => __( 'Advanced', 'rozholy' ),
			'priority' => 99,
		),
	);

	foreach ( $sections as $id => $data ) {
		$wp_customize->add_section(
			$id,
			array(
				'title'    => $data['title'],
				'panel'    => 'rozholy_theme_options',
				'priority' => $data['priority'],
			)
		);
	}

	$manifest = rozholy_option_manifest();
	$defaults = rozholy_default_options();

	$field_map = array(
		'primary_color'          => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Primary Pink', 'rozholy' ),
			'control' => 'color',
		),
		'primary_dark'           => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Primary Dark', 'rozholy' ),
			'control' => 'color',
		),
		'primary_light'          => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Primary Light', 'rozholy' ),
			'control' => 'color',
		),
		'secondary_color'        => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Secondary Purple', 'rozholy' ),
			'control' => 'color',
		),
		'secondary_dark'         => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Secondary Dark', 'rozholy' ),
			'control' => 'color',
		),
		'accent_gold'            => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Accent Gold', 'rozholy' ),
			'control' => 'color',
		),
		'accent_light'           => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Accent Light', 'rozholy' ),
			'control' => 'color',
		),
		'base_bg'                => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Base Background', 'rozholy' ),
			'control' => 'color',
		),
		'base_alt'               => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Base Alt', 'rozholy' ),
			'control' => 'color',
		),
		'dark_color'             => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Dark', 'rozholy' ),
			'control' => 'color',
		),
		'text_color'             => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Text Color', 'rozholy' ),
			'control' => 'color',
		),
		'text_light'             => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Text Light', 'rozholy' ),
			'control' => 'color',
		),
		'border_color'           => array(
			'section' => 'rozholy_colors',
			'label'   => __( 'Border Color', 'rozholy' ),
			'control' => 'color',
		),
		'footer_bg'              => array(
			'section' => 'rozholy_footer',
			'label'   => __( 'Footer Background', 'rozholy' ),
			'control' => 'color',
		),
		'heading_font'           => array(
			'section' => 'rozholy_typography',
			'label'   => __( 'Heading Font', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'playfair'  => 'Playfair Display',
				'dancing'   => 'Dancing Script',
				'vazirmatn' => 'Vazirmatn',
				'system'    => 'System Stack',
			),
		),
		'body_font'              => array(
			'section' => 'rozholy_typography',
			'label'   => __( 'Body Font', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'vazirmatn' => 'Vazirmatn',
				'playfair'  => 'Playfair Display',
				'system'    => 'System Stack',
			),
		),
		'base_font_size'         => array(
			'section'     => 'rozholy_typography',
			'label'       => __( 'Base Font Size (px)', 'rozholy' ),
			'control'     => 'number',
			'input_attrs' => array(
				'min'  => 12,
				'max'  => 24,
				'step' => 1,
			),
		),
		'heading_weight'         => array(
			'section' => 'rozholy_typography',
			'label'   => __( 'Heading Weight', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900',
			),
		),
		'header_layout'          => array(
			'section' => 'rozholy_header',
			'label'   => __( 'Header Layout', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'default'     => __( 'Default (Solid)', 'rozholy' ),
				'transparent' => __( 'Transparent', 'rozholy' ),
			),
		),
		'sticky_header'          => array(
			'section' => 'rozholy_header',
			'label'   => __( 'Sticky Header', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'On', 'rozholy' ),
				'off' => __( 'Off', 'rozholy' ),
			),
		),
		'header_cta_text'        => array(
			'section' => 'rozholy_header',
			'label'   => __( 'CTA Button Text', 'rozholy' ),
			'control' => 'text',
		),
		'header_cta_url'         => array(
			'section' => 'rozholy_header',
			'label'   => __( 'CTA Button URL', 'rozholy' ),
			'control' => 'url',
		),
		'header_search'          => array(
			'section' => 'rozholy_header',
			'label'   => __( 'Show Search', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'footer_layout'          => array(
			'section' => 'rozholy_footer',
			'label'   => __( 'Footer Columns', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1',
			),
		),
		'footer_text'            => array(
			'section' => 'rozholy_footer',
			'label'   => __( 'Copyright Text', 'rozholy' ),
			'control' => 'textarea',
		),
		'footer_social'          => array(
			'section' => 'rozholy_footer',
			'label'   => __( 'Show Social Icons', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'social_instagram'       => array(
			'section' => 'rozholy_social',
			'label'   => 'Instagram URL',
			'control' => 'url',
		),
		'social_telegram'        => array(
			'section' => 'rozholy_social',
			'label'   => 'Telegram URL',
			'control' => 'url',
		),
		'social_whatsapp'        => array(
			'section' => 'rozholy_social',
			'label'   => 'WhatsApp URL',
			'control' => 'url',
		),
		'social_youtube'         => array(
			'section' => 'rozholy_social',
			'label'   => 'YouTube URL',
			'control' => 'url',
		),
		'social_facebook'        => array(
			'section' => 'rozholy_social',
			'label'   => 'Facebook URL',
			'control' => 'url',
		),
		'social_twitter'         => array(
			'section' => 'rozholy_social',
			'label'   => 'Twitter / X URL',
			'control' => 'url',
		),
		'social_linkedin'        => array(
			'section' => 'rozholy_social',
			'label'   => 'LinkedIn URL',
			'control' => 'url',
		),
		'social_pinterest'       => array(
			'section' => 'rozholy_social',
			'label'   => 'Pinterest URL',
			'control' => 'url',
		),
		'content_width'          => array(
			'section'     => 'rozholy_layout',
			'label'       => __( 'Content Width (px)', 'rozholy' ),
			'control'     => 'number',
			'input_attrs' => array(
				'min'  => 600,
				'max'  => 1400,
				'step' => 20,
			),
		),
		'wide_width'             => array(
			'section'     => 'rozholy_layout',
			'label'       => __( 'Wide Width (px)', 'rozholy' ),
			'control'     => 'number',
			'input_attrs' => array(
				'min'  => 800,
				'max'  => 1600,
				'step' => 20,
			),
		),
		'blog_columns'           => array(
			'section' => 'rozholy_layout',
			'label'   => __( 'Blog Columns', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		),
		'shop_columns'           => array(
			'section' => 'rozholy_layout',
			'label'   => __( 'Shop Columns', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		),
		'products_per_page'      => array(
			'section'     => 'rozholy_layout',
			'label'       => __( 'Products Per Page', 'rozholy' ),
			'control'     => 'number',
			'input_attrs' => array(
				'min'  => 3,
				'max'  => 48,
				'step' => 3,
			),
		),
		'show_hero'              => array(
			'section' => 'rozholy_homepage',
			'label'   => __( 'Show Hero', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_services'          => array(
			'section' => 'rozholy_homepage',
			'label'   => __( 'Show Services', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_testimonials'      => array(
			'section' => 'rozholy_homepage',
			'label'   => __( 'Show Testimonials', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_gallery'           => array(
			'section' => 'rozholy_homepage',
			'label'   => __( 'Show Gallery', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_booking'           => array(
			'section' => 'rozholy_homepage',
			'label'   => __( 'Show Booking', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_contact'           => array(
			'section' => 'rozholy_homepage',
			'label'   => __( 'Show Contact', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'excerpt_length'         => array(
			'section'     => 'rozholy_blog',
			'label'       => __( 'Excerpt Length', 'rozholy' ),
			'control'     => 'number',
			'input_attrs' => array(
				'min'  => 10,
				'max'  => 100,
				'step' => 5,
			),
		),
		'show_author'            => array(
			'section' => 'rozholy_blog',
			'label'   => __( 'Show Author', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_date'              => array(
			'section' => 'rozholy_blog',
			'label'   => __( 'Show Date', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_categories'        => array(
			'section' => 'rozholy_blog',
			'label'   => __( 'Show Categories', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_tags'              => array(
			'section' => 'rozholy_blog',
			'label'   => __( 'Show Tags', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_thumb'             => array(
			'section' => 'rozholy_blog',
			'label'   => __( 'Show Featured Image', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'show_comments'          => array(
			'section' => 'rozholy_blog',
			'label'   => __( 'Show Comments', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'button_radius'          => array(
			'section'     => 'rozholy_buttons',
			'label'       => __( 'Button Radius (px)', 'rozholy' ),
			'control'     => 'range',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
		),
		'button_hover'           => array(
			'section' => 'rozholy_buttons',
			'label'   => __( 'Hover Effect', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'brighten' => __( 'Brighten', 'rozholy' ),
				'darken'   => __( 'Darken', 'rozholy' ),
				'scale'    => __( 'Scale', 'rozholy' ),
				'none'     => __( 'None', 'rozholy' ),
			),
		),
		'dashboard_page'         => array(
			'section' => 'rozholy_dashboard',
			'label'   => __( 'Dashboard Page', 'rozholy' ),
			'control' => 'dropdown-pages',
		),
		'avatar_size'            => array(
			'section'     => 'rozholy_dashboard',
			'label'       => __( 'Avatar Size (px)', 'rozholy' ),
			'control'     => 'range',
			'input_attrs' => array(
				'min'  => 32,
				'max'  => 200,
				'step' => 8,
			),
		),
		'motion_intensity'       => array(
			'section' => 'rozholy_motion',
			'label'   => __( 'Motion Intensity', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'full'   => __( 'Full', 'rozholy' ),
				'subtle' => __( 'Subtle', 'rozholy' ),
				'off'    => __( 'Off', 'rozholy' ),
			),
		),
		'parallax'               => array(
			'section' => 'rozholy_motion',
			'label'   => __( 'Parallax', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'On', 'rozholy' ),
				'off' => __( 'Off', 'rozholy' ),
			),
		),
		'mobile_bottom_nav'      => array(
			'section' => 'rozholy_bottom_nav',
			'label'   => __( 'Enable Mobile Bottom Nav', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'Show', 'rozholy' ),
				'off' => __( 'Hide', 'rozholy' ),
			),
		),
		'bottom_nav_hide_scroll' => array(
			'section' => 'rozholy_bottom_nav',
			'label'   => __( 'Hide on Scroll Down', 'rozholy' ),
			'control' => 'select',
			'choices' => array(
				'on'  => __( 'On', 'rozholy' ),
				'off' => __( 'Off', 'rozholy' ),
			),
		),
		'custom_css'             => array(
			'section'     => 'rozholy_advanced',
			'label'       => __( 'Custom CSS', 'rozholy' ),
			'control'     => 'textarea',
			'input_attrs' => array( 'style' => 'font-family:monospace;direction:ltr' ),
		),
		'header_scripts'         => array(
			'section'     => 'rozholy_advanced',
			'label'       => __( 'Header Scripts', 'rozholy' ),
			'control'     => 'textarea',
			'input_attrs' => array( 'style' => 'font-family:monospace;direction:ltr' ),
		),
		'footer_scripts'         => array(
			'section'     => 'rozholy_advanced',
			'label'       => __( 'Footer Scripts', 'rozholy' ),
			'control'     => 'textarea',
			'input_attrs' => array( 'style' => 'font-family:monospace;direction:ltr' ),
		),
	);

	$transport_map = array(
		'color'    => 'postMessage',
		'select'   => 'refresh',
		'text'     => 'postMessage',
		'url'      => 'refresh',
		'number'   => 'postMessage',
		'range'    => 'postMessage',
		'textarea' => 'postMessage',
	);

	foreach ( $field_map as $key => $field ) {
		$setting_id = 'rozholy_options[' . $key . ']';
		$transport  = $transport_map[ $field['control'] ] ?? 'refresh';

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $defaults[ $key ] ?? '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => $transport,
				'sanitize_callback' => 'rozholy_sanitize_customizer_setting',
			)
		);

		switch ( $field['control'] ) {
			case 'color':
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						$setting_id,
						array(
							'label'   => $field['label'],
							'section' => $field['section'],
						)
					)
				);
				break;
			case 'range':
				if ( class_exists( 'Rozholy_Range_Control' ) ) {
					$field['input_attrs']['data-setting-key'] = $key;
					$wp_customize->add_control(
						new Rozholy_Range_Control(
							$wp_customize,
							$setting_id,
							array(
								'label'       => $field['label'],
								'section'     => $field['section'],
								'input_attrs' => $field['input_attrs'] ?? array(),
							)
						)
					);
				} else {
					$wp_customize->add_control(
						$setting_id,
						array(
							'label'       => $field['label'],
							'section'     => $field['section'],
							'type'        => 'range',
							'input_attrs' => $field['input_attrs'] ?? array(),
						)
					);
				}
				break;
			case 'dropdown-pages':
				$wp_customize->add_control(
					$setting_id,
					array(
						'label'   => $field['label'],
						'section' => $field['section'],
						'type'    => 'dropdown-pages',
					)
				);
				break;
			case 'select':
				$wp_customize->add_control(
					$setting_id,
					array(
						'label'   => $field['label'],
						'section' => $field['section'],
						'type'    => 'select',
						'choices' => $field['choices'],
					)
				);
				break;
			case 'textarea':
				$wp_customize->add_control(
					$setting_id,
					array(
						'label'       => $field['label'],
						'section'     => $field['section'],
						'type'        => 'textarea',
						'input_attrs' => $field['input_attrs'] ?? array(),
					)
				);
				break;
			default:
				$wp_customize->add_control(
					$setting_id,
					array(
						'label'       => $field['label'],
						'section'     => $field['section'],
						'type'        => $field['control'],
						'input_attrs' => $field['input_attrs'] ?? array(),
					)
				);
		}
	}

	/* ── Selective refresh: footer copyright text ── */
	$wp_customize->selective_refresh->add_partial(
		'rozholy_options[footer_text]',
		array(
			'selector'        => '.site-footer__copyright',
			'render_callback' => function () {
				return wp_kses_post( rozholy_get_option( 'footer_text' ) );
			},
		)
	);
}

add_filter( 'customize_sanitize_js_rozholy_options', 'rozholy_sanitize_customizer_js' );
function rozholy_sanitize_customizer_js( $value ) {
	return $value;
}

function rozholy_sanitize_customizer_setting( $value, $setting ) {
	preg_match( '/rozholy_options\[(.+?)\]/', $setting->id, $matches );
	if ( empty( $matches[1] ) ) {
		return $value;
	}
	$key      = $matches[1];
	$manifest = rozholy_option_manifest();
	if ( ! isset( $manifest[ $key ] ) ) {
		return $value;
	}
	$rule = $manifest[ $key ];
	switch ( $rule['type'] ) {
		case 'color':
			return sanitize_hex_color( $value ) ?: $value;
		case 'number':
			$num = floatval( $value );
			if ( isset( $rule['min'] ) ) {
				$num = max( $rule['min'], $num );
			}
			if ( isset( $rule['max'] ) ) {
				$num = min( $rule['max'], $num );
			}
			return $num;
		case 'checkbox':
			return $value ? '1' : '0';
		case 'image':
			return absint( $value );
		case 'html':
			return wp_kses_post( $value );
		case 'url':
			return esc_url_raw( $value );
		case 'text':
			return sanitize_text_field( $value );
		case 'select':
			$choices = array_values( $rule['choices'] );
			return in_array( (string) $value, $choices, true ) ? $value : '';
		case 'css':
			return wp_strip_all_tags( $value );
		case 'scripts':
			return wp_kses(
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
		default:
			return sanitize_text_field( $value );
	}
}
