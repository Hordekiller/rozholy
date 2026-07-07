<?php
defined('ABSPATH') || exit;

add_action('customize_register', 'rozholy_customize_register');
function rozholy_customize_register($wp_customize) {

    /* ── Rozholy Panel ── */
    $wp_customize->add_panel('rozholy_theme_options', [
        'title'       => esc_html__('Rozholy Settings', 'rozholy'),
        'description' => esc_html__('تنظیمات اختصاصی قالب Rozholy', 'rozholy'),
        'priority'    => 30,
    ]);

    /* ── Colors Section ── */
    $wp_customize->add_section('rozholy_colors', [
        'title'    => esc_html__('Colors', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 10,
    ]);

    $wp_customize->add_setting('rozholy_primary_color', [
        'default'           => '#d4a0a0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rozholy_primary_color', [
        'label'    => esc_html__('Primary Color', 'rozholy'),
        'section'  => 'rozholy_colors',
    ]));

    $wp_customize->add_setting('rozholy_secondary_color', [
        'default'           => '#c49a6c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rozholy_secondary_color', [
        'label'    => esc_html__('Secondary Color', 'rozholy'),
        'section'  => 'rozholy_colors',
    ]));

    /* ── Header Section ── */
    $wp_customize->add_section('rozholy_header', [
        'title'    => esc_html__('Header', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 20,
    ]);

    $wp_customize->add_setting('rozholy_header_layout', [
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('rozholy_header_layout', [
        'label'    => esc_html__('Header Layout', 'rozholy'),
        'section'  => 'rozholy_header',
        'type'     => 'select',
        'choices'  => [
            'default'     => esc_html__('Default (Solid)', 'rozholy'),
            'transparent' => esc_html__('Transparent', 'rozholy'),
        ],
    ]);

    /* ── Footer Section ── */
    $wp_customize->add_section('rozholy_footer', [
        'title'    => esc_html__('Footer', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('rozholy_footer_text', [
        'default'           => '© 2025 Rozholy. تمامی حقوق محفوظ است.',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('rozholy_footer_text', [
        'label'    => esc_html__('Footer Copyright Text', 'rozholy'),
        'section'  => 'rozholy_footer',
        'type'     => 'textarea',
    ]);

    /* ── Social Links Section ── */
    $wp_customize->add_section('rozholy_social', [
        'title'    => esc_html__('Social Links', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 40,
    ]);

    $socials = [
        'instagram' => esc_html__('Instagram URL', 'rozholy'),
        'telegram'  => esc_html__('Telegram URL', 'rozholy'),
        'whatsapp'  => esc_html__('WhatsApp URL', 'rozholy'),
        'youtube'   => esc_html__('YouTube URL', 'rozholy'),
    ];

    foreach ($socials as $key => $label) {
        $wp_customize->add_setting("rozholy_social_{$key}", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ]);

        $wp_customize->add_control("rozholy_social_{$key}", [
            'label'    => $label,
            'section'  => 'rozholy_social',
            'type'     => 'url',
        ]);
    }

    /* ── Dashboard Section ── */
    $wp_customize->add_section('rozholy_dashboard', [
        'title'    => esc_html__('User Dashboard', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 50,
    ]);

    $wp_customize->add_setting('rozholy_dashboard_page', [
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('rozholy_dashboard_page', [
        'label'    => esc_html__('Dashboard Page', 'rozholy'),
        'section'  => 'rozholy_dashboard',
        'type'     => 'dropdown-pages',
    ]);

    /* ── Motion Section ── */
    $wp_customize->add_section('rozholy_motion', [
        'title'    => esc_html__('Motion & Effects', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 60,
        'description' => esc_html__('کنترل شدت انیمیشن‌ها و افکت‌های بصری', 'rozholy'),
    ]);

    $wp_customize->add_setting('rozholy_motion_intensity', [
        'default'           => 'full',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('rozholy_motion_intensity', [
        'label'    => esc_html__('Motion Intensity', 'rozholy'),
        'section'  => 'rozholy_motion',
        'type'     => 'select',
        'choices'  => [
            'full'   => esc_html__('Full (recommended)', 'rozholy'),
            'subtle' => esc_html__('Subtle', 'rozholy'),
            'off'    => esc_html__('Off', 'rozholy'),
        ],
    ]);
}
