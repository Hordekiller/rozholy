<?php

define('ROZHOLY_VERSION', '2.0.0');
define('ROZHOLY_DIR', get_template_directory());
define('ROZHOLY_URI', get_template_directory_uri());

add_action('after_setup_theme', 'rozholy_setup');
function rozholy_setup() {
    load_theme_textdomain('rozholy', ROZHOLY_DIR . '/languages');

    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-line-height');
    add_theme_support('custom-spacing');
    add_theme_support('custom-units');
    add_theme_support('link-color');
    add_theme_support('appearance-tools');

    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor.css');

    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 280,
        'flex-width'  => true,
        'flex-height' => true,
    ]);

    add_theme_support('custom-header', [
        'default-image' => '',
        'width'         => 1920,
        'height'        => 600,
        'flex-height'   => true,
        'header-text'   => false,
    ]);

    add_theme_support('custom-background', [
        'default-color' => 'faf5f0',
    ]);

    register_nav_menus([
        'primary' => esc_html__('منوی اصلی', 'rozholy'),
        'footer'  => esc_html__('منوی فوتر', 'rozholy'),
    ]);
}

add_action('wp_enqueue_scripts', 'rozholy_enqueue_scripts');
function rozholy_enqueue_scripts() {
    wp_enqueue_style('rozholy-style', get_stylesheet_uri(), [], ROZHOLY_VERSION);

    if (is_rtl()) {
        wp_enqueue_style('rozholy-rtl', ROZHOLY_URI . '/assets/css/main-rtl.css', ['rozholy-style'], ROZHOLY_VERSION);
    }

    wp_enqueue_style('rozholy-animations', ROZHOLY_URI . '/assets/css/animations.css', ['rozholy-style'], ROZHOLY_VERSION);
    wp_enqueue_style('rozholy-responsive', ROZHOLY_URI . '/assets/css/responsive.css', ['rozholy-style'], ROZHOLY_VERSION);
}

add_action('enqueue_block_editor_assets', 'rozholy_block_editor_assets');
function rozholy_block_editor_assets() {
    wp_enqueue_style('rozholy-editor-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Dancing+Script:wght@400;500;600;700&display=swap', [], null);
    wp_enqueue_style('rozholy-editor', ROZHOLY_URI . '/assets/css/editor.css', [], ROZHOLY_VERSION);
}

add_filter('body_class', 'rozholy_body_classes');
function rozholy_body_classes($classes) {
    if (is_rtl()) $classes[] = 'rtl';
    if (class_exists('WooCommerce')) $classes[] = 'woocommerce-active';
    return $classes;
}

if (class_exists('WooCommerce')) {
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');

    add_action('wp_enqueue_scripts', 'rozholy_woo_scripts', 20);
    function rozholy_woo_scripts() {
        wp_enqueue_style('rozholy-woocommerce', ROZHOLY_URI . '/assets/css/woocommerce.css', ['rozholy-style'], ROZHOLY_VERSION);
    }

    add_filter('woocommerce_add_to_cart_fragments', 'rozholy_cart_fragment');
    function rozholy_cart_fragment($fragments) {
        ob_start();
        ?><span class="wc-block-mini-cart__badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span><?php
        $fragments['.wc-block-mini-cart__badge'] = ob_get_clean();
        return $fragments;
    }
}
