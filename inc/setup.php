<?php

add_action('after_setup_theme', 'rozholy_setup');
function rozholy_setup() {
    load_theme_textdomain('rozholy', ROZHOLY_DIR . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets',
    ]);

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

    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');

    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    add_theme_support('elementor');

    register_nav_menus([
        'primary'     => esc_html__('منوی اصلی', 'rozholy'),
        'secondary'   => esc_html__('منوی ثانویه', 'rozholy'),
        'mobile'      => esc_html__('منوی موبایل', 'rozholy'),
        'footer'      => esc_html__('منوی فوتر', 'rozholy'),
        'topbar'      => esc_html__('منوی نوار بالا', 'rozholy'),
    ]);

    add_image_size('rozholy-featured', 800, 500, true);
    add_image_size('rozholy-gallery', 600, 600, true);
    add_image_size('rozholy-portfolio', 500, 600, true);
    add_image_size('rozholy-team', 400, 500, true);
    add_image_size('rozholy-testimonial', 100, 100, true);
}

add_action('widgets_init', 'rozholy_widgets_init');
function rozholy_widgets_init() {
    register_sidebar([
        'name'          => esc_html__('سایدبار اصلی', 'rozholy'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('ویجت‌های سایدبار اصلی', 'rozholy'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => esc_html__('فوتر - ستون ۱', 'rozholy'),
        'id'            => 'footer-1',
        'description'   => esc_html__('ستون اول فوتر', 'rozholy'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => esc_html__('فوتر - ستون ۲', 'rozholy'),
        'id'            => 'footer-2',
        'description'   => esc_html__('ستون دوم فوتر', 'rozholy'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => esc_html__('فوتر - ستون ۳', 'rozholy'),
        'id'            => 'footer-3',
        'description'   => esc_html__('ستون سوم فوتر', 'rozholy'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => esc_html__('فوتر - ستون ۴', 'rozholy'),
        'id'            => 'footer-4',
        'description'   => esc_html__('ستون چهارم فوتر - اطلاعات تماس', 'rozholy'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => esc_html__('نوار بالای صفحه', 'rozholy'),
        'id'            => 'topbar',
        'description'   => esc_html__('ویجت‌های نوار بالای هدر', 'rozholy'),
        'before_widget' => '<div id="%1$s" class="topbar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="topbar-widget-title">',
        'after_title'   => '</span>',
    ]);
}

add_filter('body_class', 'rozholy_body_classes');
function rozholy_body_classes($classes) {
    if (is_rtl()) {
        $classes[] = 'rtl';
    }
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }
    if (class_exists('WooCommerce')) {
        $classes[] = 'woocommerce-active';
    }
    return $classes;
}
