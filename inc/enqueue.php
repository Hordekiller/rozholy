<?php

add_action('wp_enqueue_scripts', 'rozholy_enqueue_scripts');
function rozholy_enqueue_scripts() {
    $rtl_suffix = is_rtl() ? '-rtl' : '';

    wp_enqueue_style('rozholy-google-fonts', rozholy_fonts_url(), [], null);
    wp_enqueue_style('rozholy-main', ROZHOLY_URI . '/assets/css/main.css' . $rtl_suffix . '.css', [], ROZHOLY_VERSION);
    wp_enqueue_style('rozholy-animations', ROZHOLY_URI . '/assets/css/animations.css', [], ROZHOLY_VERSION);
    wp_enqueue_style('rozholy-responsive', ROZHOLY_URI . '/assets/css/responsive.css', ['rozholy-main'], ROZHOLY_VERSION);
    wp_enqueue_style('rozholy-style', get_stylesheet_uri(), ['rozholy-main'], ROZHOLY_VERSION);

    if (class_exists('WooCommerce')) {
        wp_enqueue_style('rozholy-woocommerce', ROZHOLY_URI . '/assets/css/woocommerce.css', ['rozholy-main', 'woocommerce-general'], ROZHOLY_VERSION);
    }

    wp_enqueue_script('rozholy-navigation', ROZHOLY_URI . '/assets/js/navigation.js', [], ROZHOLY_VERSION, ['in_footer' => true, 'strategy' => 'defer']);
    wp_enqueue_script('rozholy-main', ROZHOLY_URI . '/assets/js/main.js', ['rozholy-navigation'], ROZHOLY_VERSION, ['in_footer' => true, 'strategy' => 'defer']);

    if (class_exists('WooCommerce')) {
        wp_enqueue_script('rozholy-woocommerce', ROZHOLY_URI . '/assets/js/woo-custom.js', ['jquery', 'wc-add-to-cart'], ROZHOLY_VERSION, ['in_footer' => true, 'strategy' => 'defer']);

        wp_localize_script('rozholy-woocommerce', 'rozholyWoo', [
            'ajaxUrl'  => WC()->ajax_url(),
            'nonce'    => wp_create_nonce('rozholy-woo-nonce'),
            'cartUrl'  => wc_get_cart_url(),
            'i18n'     => [
                'added'   => esc_html__('به سبد خرید اضافه شد!', 'rozholy'),
                'viewCart' => esc_html__('مشاهده سبد خرید', 'rozholy'),
            ],
        ]);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

function rozholy_fonts_url() {
    $fonts = [];
    $subsets = 'arabic,latin,latin-ext';

    if ('off' !== _x('on', 'Playfair Display font: on or off', 'rozholy')) {
        $fonts[] = 'Playfair Display:400,500,600,700,800,italic';
    }
    if ('off' !== _x('on', 'Dancing Script font: on or off', 'rozholy')) {
        $fonts[] = 'Dancing Script:400,500,600,700';
    }

    if (empty($fonts)) {
        return '';
    }

    $query_args = [
        'family'  => implode('&family=', $fonts),
        'display' => 'swap',
        'subset'  => $subsets,
    ];

    return add_query_arg($query_args, 'https://fonts.googleapis.com/css2');
}

add_action('enqueue_block_editor_assets', 'rozholy_editor_styles');
function rozholy_editor_styles() {
    wp_enqueue_style('rozholy-editor-fonts', rozholy_fonts_url(), [], null);
    wp_enqueue_style('rozholy-editor-style', ROZHOLY_URI . '/assets/css/editor.css', [], ROZHOLY_VERSION);
}
