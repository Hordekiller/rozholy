<?php
defined('ABSPATH') || exit;

add_action('customize_register', 'rozholy_customize_register');
function rozholy_customize_register($wp_customize) {

    /* ═══════════════════════════════════
       Rozholy Master Panel
    ═══════════════════════════════════ */
    $wp_customize->add_panel('rozholy_theme_options', [
        'title'       => esc_html__('Rozholy Settings', 'rozholy'),
        'description' => esc_html__('تمامی تنظیمات قالب Rozholy', 'rozholy'),
        'priority'    => 30,
    ]);

    /* ═══════════════════════════════════
       1. COLORS
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_colors', [
        'title'    => esc_html__('Colors', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 10,
    ]);

    $colors = [
        'rozholy_primary_color'       => ['label' => __('Primary Pink', 'rozholy'),       'default' => '#d4a0a0'],
        'rozholy_primary_dark'        => ['label' => __('Primary Dark', 'rozholy'),        'default' => '#c08080'],
        'rozholy_primary_light'       => ['label' => __('Primary Light', 'rozholy'),       'default' => '#f0d0d0'],
        'rozholy_secondary_color'     => ['label' => __('Secondary Purple', 'rozholy'),    'default' => '#b8a0c0'],
        'rozholy_secondary_dark'      => ['label' => __('Secondary Dark', 'rozholy'),      'default' => '#9870a8'],
        'rozholy_accent_gold'         => ['label' => __('Accent Gold', 'rozholy'),         'default' => '#c8a87c'],
        'rozholy_accent_light'        => ['label' => __('Accent Light', 'rozholy'),        'default' => '#e8d0b8'],
        'rozholy_base_bg'             => ['label' => __('Base Background', 'rozholy'),     'default' => '#faf5f0'],
        'rozholy_base_alt'            => ['label' => __('Base Alt', 'rozholy'),            'default' => '#f5ece4'],
        'rozholy_dark_color'          => ['label' => __('Dark', 'rozholy'),                'default' => '#2d2d2d'],
        'rozholy_text_color'          => ['label' => __('Text Color', 'rozholy'),          'default' => '#4a4a4a'],
        'rozholy_text_light'          => ['label' => __('Text Light', 'rozholy'),          'default' => '#7a7a7a'],
        'rozholy_border_color'        => ['label' => __('Border Color', 'rozholy'),        'default' => '#e8ddd5'],
    ];

    foreach ($colors as $key => $data) {
        $wp_customize->add_setting($key, [
            'default'           => $data['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $key, [
            'label'    => $data['label'],
            'section'  => 'rozholy_colors',
        ]));
    }

    /* ═══════════════════════════════════
       2. TYPOGRAPHY
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_typography', [
        'title'    => esc_html__('Typography', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 15,
    ]);

    $wp_customize->add_setting('rozholy_heading_font', [
        'default'           => 'playfair',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_heading_font', [
        'label'    => esc_html__('Heading Font', 'rozholy'),
        'section'  => 'rozholy_typography',
        'type'     => 'select',
        'choices'  => [
            'playfair'    => esc_html__('Playfair Display', 'rozholy'),
            'dancing'     => esc_html__('Dancing Script', 'rozholy'),
            'vazirmatn'   => esc_html__('Vazirmatn', 'rozholy'),
            'system'      => esc_html__('System Stack', 'rozholy'),
        ],
    ]);

    $wp_customize->add_setting('rozholy_body_font', [
        'default'           => 'vazirmatn',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_body_font', [
        'label'    => esc_html__('Body Font', 'rozholy'),
        'section'  => 'rozholy_typography',
        'type'     => 'select',
        'choices'  => [
            'vazirmatn'   => esc_html__('Vazirmatn', 'rozholy'),
            'playfair'    => esc_html__('Playfair Display', 'rozholy'),
            'system'      => esc_html__('System Stack', 'rozholy'),
        ],
    ]);

    $wp_customize->add_setting('rozholy_base_font_size', [
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ]);
    $wp_customize->add_control('rozholy_base_font_size', [
        'label'       => esc_html__('Base Font Size (px)', 'rozholy'),
        'section'     => 'rozholy_typography',
        'type'        => 'number',
        'input_attrs' => ['min' => 12, 'max' => 24, 'step' => 1],
    ]);

    $wp_customize->add_setting('rozholy_heading_weight', [
        'default'           => '700',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ]);
    $wp_customize->add_control('rozholy_heading_weight', [
        'label'       => esc_html__('Heading Font Weight', 'rozholy'),
        'section'     => 'rozholy_typography',
        'type'        => 'select',
        'choices'     => [
            '400' => '400',
            '500' => '500',
            '600' => '600',
            '700' => '700',
            '800' => '800',
            '900' => '900',
        ],
    ]);

    /* ═══════════════════════════════════
       3. HEADER
    ═══════════════════════════════════ */
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

    $wp_customize->add_setting('rozholy_sticky_header', [
        'default'           => 'on',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_sticky_header', [
        'label'    => esc_html__('Sticky Header', 'rozholy'),
        'section'  => 'rozholy_header',
        'type'     => 'select',
        'choices'  => [
            'on'  => esc_html__('On', 'rozholy'),
            'off' => esc_html__('Off', 'rozholy'),
        ],
    ]);

    $wp_customize->add_setting('rozholy_header_cta_text', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_header_cta_text', [
        'label'       => esc_html__('Header CTA Button Text', 'rozholy'),
        'section'     => 'rozholy_header',
        'type'        => 'text',
        'description' => esc_html__('Leave empty to hide the CTA button', 'rozholy'),
    ]);

    $wp_customize->add_setting('rozholy_header_cta_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_header_cta_url', [
        'label'   => esc_html__('Header CTA Button URL', 'rozholy'),
        'section' => 'rozholy_header',
        'type'    => 'url',
    ]);

    $wp_customize->add_setting('rozholy_header_search', [
        'default'           => 'on',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_header_search', [
        'label'    => esc_html__('Show Search in Header', 'rozholy'),
        'section'  => 'rozholy_header',
        'type'     => 'select',
        'choices'  => [
            'on'  => esc_html__('Show', 'rozholy'),
            'off' => esc_html__('Hide', 'rozholy'),
        ],
    ]);

    /* ═══════════════════════════════════
       4. FOOTER
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_footer', [
        'title'    => esc_html__('Footer', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('rozholy_footer_layout', [
        'default'           => '4',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_footer_layout', [
        'label'    => esc_html__('Footer Columns', 'rozholy'),
        'section'  => 'rozholy_footer',
        'type'     => 'select',
        'choices'  => [
            '4' => esc_html__('4 Columns', 'rozholy'),
            '3' => esc_html__('3 Columns', 'rozholy'),
            '2' => esc_html__('2 Columns', 'rozholy'),
            '1' => esc_html__('1 Column', 'rozholy'),
        ],
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

    $wp_customize->add_setting('rozholy_footer_social', [
        'default'           => 'on',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_footer_social', [
        'label'    => esc_html__('Show Social Icons in Footer', 'rozholy'),
        'section'  => 'rozholy_footer',
        'type'     => 'select',
        'choices'  => [
            'on'  => esc_html__('Show', 'rozholy'),
            'off' => esc_html__('Hide', 'rozholy'),
        ],
    ]);

    $wp_customize->add_setting('rozholy_footer_bg', [
        'default'           => '#2d2d2d',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rozholy_footer_bg', [
        'label'    => esc_html__('Footer Background Color', 'rozholy'),
        'section'  => 'rozholy_footer',
    ]));

    /* ═══════════════════════════════════
       5. SOCIAL LINKS
    ═══════════════════════════════════ */
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
        'facebook'  => esc_html__('Facebook URL', 'rozholy'),
        'twitter'   => esc_html__('Twitter / X URL', 'rozholy'),
        'linkedin'  => esc_html__('LinkedIn URL', 'rozholy'),
        'pinterest' => esc_html__('Pinterest URL', 'rozholy'),
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

    /* ═══════════════════════════════════
       6. LAYOUT
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_layout', [
        'title'    => esc_html__('Layout', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 45,
    ]);

    $wp_customize->add_setting('rozholy_content_width', [
        'default'           => '800',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_content_width', [
        'label'       => esc_html__('Content Width (px)', 'rozholy'),
        'section'     => 'rozholy_layout',
        'type'        => 'number',
        'input_attrs' => ['min' => 600, 'max' => 1400, 'step' => 20],
    ]);

    $wp_customize->add_setting('rozholy_wide_width', [
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_wide_width', [
        'label'       => esc_html__('Wide Width (px)', 'rozholy'),
        'section'     => 'rozholy_layout',
        'type'        => 'number',
        'input_attrs' => ['min' => 800, 'max' => 1600, 'step' => 20],
    ]);

    $wp_customize->add_setting('rozholy_blog_columns', [
        'default'           => '3',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_blog_columns', [
        'label'    => esc_html__('Blog Grid Columns', 'rozholy'),
        'section'  => 'rozholy_layout',
        'type'     => 'select',
        'choices'  => [
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ],
    ]);

    $wp_customize->add_setting('rozholy_shop_columns', [
        'default'           => '3',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_shop_columns', [
        'label'    => esc_html__('Shop Grid Columns', 'rozholy'),
        'section'  => 'rozholy_layout',
        'type'     => 'select',
        'choices'  => [
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ],
    ]);

    $wp_customize->add_setting('rozholy_products_per_page', [
        'default'           => '12',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_products_per_page', [
        'label'       => esc_html__('Products Per Page', 'rozholy'),
        'section'     => 'rozholy_layout',
        'type'        => 'number',
        'input_attrs' => ['min' => 3, 'max' => 48, 'step' => 3],
    ]);

    /* ═══════════════════════════════════
       7. HOMEPAGE SECTIONS
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_homepage', [
        'title'    => esc_html__('Homepage Sections', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 48,
    ]);

    $sections = [
        'hero'       => __('Show Hero Section', 'rozholy'),
        'services'   => __('Show Services Grid', 'rozholy'),
        'testimonials' => __('Show Testimonials', 'rozholy'),
        'gallery'    => __('Show Gallery', 'rozholy'),
        'booking'    => __('Show Booking Form', 'rozholy'),
        'contact'    => __('Show Contact Info', 'rozholy'),
    ];

    foreach ($sections as $key => $label) {
        $wp_customize->add_setting("rozholy_show_{$key}", [
            'default'           => 'on',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control("rozholy_show_{$key}", [
            'label'   => $label,
            'section' => 'rozholy_homepage',
            'type'    => 'select',
            'choices' => [
                'on'  => esc_html__('Show', 'rozholy'),
                'off' => esc_html__('Hide', 'rozholy'),
            ],
        ]);
    }

    /* ═══════════════════════════════════
       8. BLOG / ARCHIVE
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_blog', [
        'title'    => esc_html__('Blog', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 50,
    ]);

    $wp_customize->add_setting('rozholy_excerpt_length', [
        'default'           => '25',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_excerpt_length', [
        'label'       => esc_html__('Excerpt Length (words)', 'rozholy'),
        'section'     => 'rozholy_blog',
        'type'        => 'number',
        'input_attrs' => ['min' => 10, 'max' => 100, 'step' => 5],
    ]);

    $toggles = [
        'show_author'     => __('Show Author', 'rozholy'),
        'show_date'       => __('Show Date', 'rozholy'),
        'show_categories' => __('Show Categories', 'rozholy'),
        'show_tags'       => __('Show Tags', 'rozholy'),
        'show_thumb'      => __('Show Featured Image', 'rozholy'),
        'show_comments'   => __('Show Comments', 'rozholy'),
    ];

    foreach ($toggles as $key => $label) {
        $wp_customize->add_setting("rozholy_{$key}", [
            'default'           => 'on',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control("rozholy_{$key}", [
            'label'   => $label,
            'section' => 'rozholy_blog',
            'type'    => 'select',
            'choices' => [
                'on'  => esc_html__('Show', 'rozholy'),
                'off' => esc_html__('Hide', 'rozholy'),
            ],
        ]);
    }

    /* ═══════════════════════════════════
       9. BUTTONS
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_buttons', [
        'title'    => esc_html__('Buttons', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 52,
    ]);

    $wp_customize->add_setting('rozholy_button_radius', [
        'default'           => '9999',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ]);
    $wp_customize->add_control('rozholy_button_radius', [
        'label'       => esc_html__('Button Border Radius (px)', 'rozholy'),
        'section'     => 'rozholy_buttons',
        'type'        => 'number',
        'input_attrs' => ['min' => 0, 'max' => 50, 'step' => 1],
    ]);

    $wp_customize->add_setting('rozholy_button_hover', [
        'default'           => 'brighten',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_button_hover', [
        'label'    => esc_html__('Button Hover Effect', 'rozholy'),
        'section'  => 'rozholy_buttons',
        'type'     => 'select',
        'choices'  => [
            'brighten' => esc_html__('Brighten', 'rozholy'),
            'darken'   => esc_html__('Darken', 'rozholy'),
            'scale'    => esc_html__('Scale', 'rozholy'),
            'none'     => esc_html__('None', 'rozholy'),
        ],
    ]);

    /* ═══════════════════════════════════
       10. USER DASHBOARD
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_dashboard', [
        'title'    => esc_html__('User Dashboard', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 55,
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

    $wp_customize->add_setting('rozholy_avatar_size', [
        'default'           => '80',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_avatar_size', [
        'label'       => esc_html__('Avatar Size (px)', 'rozholy'),
        'section'     => 'rozholy_dashboard',
        'type'        => 'number',
        'input_attrs' => ['min' => 32, 'max' => 200, 'step' => 8],
    ]);

    /* ═══════════════════════════════════
       11. MOTION & EFFECTS
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_motion', [
        'title'       => esc_html__('Motion & Effects', 'rozholy'),
        'panel'       => 'rozholy_theme_options',
        'priority'    => 60,
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
            'full'   => esc_html__('Full', 'rozholy'),
            'subtle' => esc_html__('Subtle', 'rozholy'),
            'off'    => esc_html__('Off', 'rozholy'),
        ],
    ]);

    $wp_customize->add_setting('rozholy_parallax', [
        'default'           => 'on',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_parallax', [
        'label'    => esc_html__('Parallax Effects', 'rozholy'),
        'section'  => 'rozholy_motion',
        'type'     => 'select',
        'choices'  => [
            'on'  => esc_html__('On', 'rozholy'),
            'off' => esc_html__('Off', 'rozholy'),
        ],
    ]);

    /* ═══════════════════════════════════
       12. ADVANCED
    ═══════════════════════════════════ */
    $wp_customize->add_section('rozholy_advanced', [
        'title'    => esc_html__('Advanced', 'rozholy'),
        'panel'    => 'rozholy_theme_options',
        'priority' => 99,
    ]);

    $wp_customize->add_setting('rozholy_custom_css', [
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_custom_css', [
        'label'       => esc_html__('Custom CSS', 'rozholy'),
        'section'     => 'rozholy_advanced',
        'type'        => 'textarea',
        'description' => esc_html__('Add custom CSS rules (without <style> tags)', 'rozholy'),
        'input_attrs' => ['style' => 'font-family:monospace;direction:ltr'],
    ]);

    $wp_customize->add_setting('rozholy_header_scripts', [
        'default'           => '',
        'sanitize_callback' => 'rozholy_sanitize_scripts',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_header_scripts', [
        'label'       => esc_html__('Header Scripts', 'rozholy'),
        'section'     => 'rozholy_advanced',
        'type'        => 'textarea',
        'description' => esc_html__('Add code to <head> (analytics, meta tags)', 'rozholy'),
        'input_attrs' => ['style' => 'font-family:monospace;direction:ltr'],
    ]);

    $wp_customize->add_setting('rozholy_footer_scripts', [
        'default'           => '',
        'sanitize_callback' => 'rozholy_sanitize_scripts',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('rozholy_footer_scripts', [
        'label'       => esc_html__('Footer Scripts', 'rozholy'),
        'section'     => 'rozholy_advanced',
        'type'        => 'textarea',
        'description' => esc_html__('Add code before </body> (chat widgets, pixels)', 'rozholy'),
        'input_attrs' => ['style' => 'font-family:monospace;direction:ltr'],
    ]);
}

/* ── Sanitize scripts (allow basic HTML/script tags for embed codes) ── */
function rozholy_sanitize_scripts($input) {
    return wp_kses($input, [
        'script' => ['src' => [], 'async' => [], 'defer' => [], 'type' => []],
        'meta'   => ['name' => [], 'content' => [], 'property' => [], 'charset' => []],
        'link'   => ['href' => [], 'rel' => [], 'type' => [], 'media' => [], 'crossorigin' => []],
        'noscript' => [],
        'style'  => ['type' => []],
        'iframe' => ['src' => [], 'width' => [], 'height' => [], 'style' => [], 'allow' => [], 'loading' => []],
    ]);
}
