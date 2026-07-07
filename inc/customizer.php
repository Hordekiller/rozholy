<?php

add_action('customize_register', 'rozholy_customize_register');
function rozholy_customize_register($wp_customize) {
    $wp_customize->add_section('rozholy_colors', [
        'title'    => esc_html__('رنگ‌های قالب Rozholy', 'rozholy'),
        'priority' => 30,
    ]);

    $colors = [
        'rz_primary'   => ['default' => '#d4a0a0', 'label' => __('رنگ اصلی (پرایمری)', 'rozholy')],
        'rz_secondary' => ['default' => '#b8a0c0', 'label' => __('رنگ ثانویه', 'rozholy')],
        'rz_accent'    => ['default' => '#c8a87c', 'label' => __('رنگ تاکیدی', 'rozholy')],
    ];

    foreach ($colors as $key => $opts) {
        $wp_customize->add_setting($key, [
            'default'           => $opts['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $key, [
            'label'    => $opts['label'],
            'section'  => 'rozholy_colors',
        ]));
    }

    $wp_customize->add_section('rozholy_layout', [
        'title'    => esc_html__('تنظیمات چیدمان Rozholy', 'rozholy'),
        'priority' => 35,
    ]);

    $wp_customize->add_setting('rozholy_container_width', [
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('rozholy_container_width', [
        'label'       => esc_html__('عرض کانتینر (پیکسل)', 'rozholy'),
        'section'     => 'rozholy_layout',
        'type'        => 'number',
        'input_attrs' => ['min' => 900, 'max' => 1400, 'step' => 10],
    ]);

    $wp_customize->add_setting('rozholy_header_style', [
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('rozholy_header_style', [
        'label'   => esc_html__('استایل هدر', 'rozholy'),
        'section' => 'rozholy_layout',
        'type'    => 'select',
        'choices' => [
            'default'    => esc_html__('استاندارد', 'rozholy'),
            'transparent' => esc_html__('شفاف', 'rozholy'),
            'sticky'     => esc_html__('چسبنده', 'rozholy'),
        ],
    ]);

    $wp_customize->add_section('rozholy_social', [
        'title'       => esc_html__('شبکه‌های اجتماعی', 'rozholy'),
        'priority'    => 40,
        'description' => esc_html__('لینک شبکه‌های اجتماعی خود را وارد کنید. این لینک‌ها در هدر و فوتر نمایش داده می‌شوند.', 'rozholy'),
    ]);

    $socials = [
        'instagram' => esc_html__('اینستاگرام', 'rozholy'),
        'telegram'  => esc_html__('تلگرام', 'rozholy'),
        'whatsapp'  => esc_html__('واتساپ', 'rozholy'),
        'youtube'   => esc_html__('یوتیوب', 'rozholy'),
        'linkedin'  => esc_html__('لینکدین', 'rozholy'),
        'facebook'  => esc_html__('فیسبوک', 'rozholy'),
    ];

    foreach ($socials as $key => $label) {
        $wp_customize->add_setting('rozholy_social_' . $key, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control('rozholy_social_' . $key, [
            'label'       => $label,
            'section'     => 'rozholy_social',
            'type'        => 'url',
            'placeholder' => 'https://' . $key . '.com/...',
        ]);
    }

    $wp_customize->add_section('rozholy_contact', [
        'title'       => esc_html__('اطلاعات تماس', 'rozholy'),
        'priority'    => 45,
        'description' => esc_html__('اطلاعات تماس کسب‌وکار شما', 'rozholy'),
    ]);

    $contacts = [
        'phone'    => esc_html__('شماره تماس', 'rozholy'),
        'mobile'   => esc_html__('موبایل', 'rozholy'),
        'email'    => esc_html__('ایمیل', 'rozholy'),
        'address'  => esc_html__('آدرس', 'rozholy'),
        'worktime' => esc_html__('ساعت کاری', 'rozholy'),
    ];

    foreach ($contacts as $key => $label) {
        $wp_customize->add_setting('rozholy_contact_' . $key, [
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        ]);

        $wp_customize->add_control('rozholy_contact_' . $key, [
            'label'       => $label,
            'section'     => 'rozholy_contact',
            'type'        => 'text',
        ]);
    }
}

add_action('wp_head', 'rozholy_customizer_css');
function rozholy_customizer_css() {
    $primary   = get_theme_mod('rz_primary', '#d4a0a0');
    $secondary = get_theme_mod('rz_secondary', '#b8a0c0');
    $accent    = get_theme_mod('rz_accent', '#c8a87c');
    $width     = get_theme_mod('rozholy_container_width', '1200');

    echo '<style id="rozholy-customizer-vars">';
    echo ':root {';
    echo '--rz-primary: ' . esc_attr($primary) . ';';
    echo '--rz-primary-dark: ' . esc_attr(rozholy_darken($primary, 15)) . ';';
    echo '--rz-primary-light: ' . esc_attr(rozholy_lighten($primary, 20)) . ';';
    echo '--rz-secondary: ' . esc_attr($secondary) . ';';
    echo '--rz-secondary-dark: ' . esc_attr(rozholy_darken($secondary, 15)) . ';';
    echo '--rz-accent: ' . esc_attr($accent) . ';';
    echo '--rz-accent-light: ' . esc_attr(rozholy_lighten($accent, 20)) . ';';
    echo '--rz-container-width: ' . esc_attr($width) . 'px;';
    echo '}';
    echo '</style>';
}

function rozholy_darken($hex, $percent) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    $r = max(0, hexdec(substr($hex, 0, 2)) - round(hexdec(substr($hex, 0, 2)) * $percent / 100));
    $g = max(0, hexdec(substr($hex, 2, 2)) - round(hexdec(substr($hex, 2, 2)) * $percent / 100));
    $b = max(0, hexdec(substr($hex, 4, 2)) - round(hexdec(substr($hex, 4, 2)) * $percent / 100));
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

function rozholy_lighten($hex, $percent) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    $r = min(255, hexdec(substr($hex, 0, 2)) + round((255 - hexdec(substr($hex, 0, 2))) * $percent / 100));
    $g = min(255, hexdec(substr($hex, 2, 2)) + round((255 - hexdec(substr($hex, 2, 2))) * $percent / 100));
    $b = min(255, hexdec(substr($hex, 4, 2)) + round((255 - hexdec(substr($hex, 4, 2))) * $percent / 100));
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}
