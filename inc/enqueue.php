<?php
defined('ABSPATH') || exit;

add_action('wp_enqueue_scripts', 'rozholy_enqueue_scripts');
function rozholy_enqueue_scripts() {
    wp_enqueue_style('rozholy-style', get_stylesheet_uri(), [], ROZHOLY_VERSION);

    if (is_rtl()) {
        wp_enqueue_style('rozholy-rtl', ROZHOLY_URI . '/assets/css/main-rtl.css', ['rozholy-style'], ROZHOLY_VERSION);
    }

    wp_enqueue_style('rozholy-animations', ROZHOLY_URI . '/assets/css/animations.css', ['rozholy-style'], ROZHOLY_VERSION);
    wp_enqueue_style('rozholy-responsive', ROZHOLY_URI . '/assets/css/responsive.css', ['rozholy-style'], ROZHOLY_VERSION);
    wp_enqueue_style('rozholy-wow', ROZHOLY_URI . '/assets/css/wow.css', ['rozholy-style'], ROZHOLY_VERSION);

    wp_enqueue_script('rozholy-navigation', ROZHOLY_URI . '/assets/js/navigation.js', [], ROZHOLY_VERSION, array('strategy' => 'defer'));

    if (! is_page_template('page-dashboard.php') && ! is_customize_preview()) {
        wp_enqueue_script('rozholy-wow', ROZHOLY_URI . '/assets/js/wow.js', [], ROZHOLY_VERSION, array('strategy' => 'defer'));
    }

    if (is_page_template('page-dashboard.php')) {
        wp_enqueue_style('rozholy-dashboard', ROZHOLY_URI . '/assets/css/dashboard.css', ['rozholy-style'], ROZHOLY_VERSION);
        wp_enqueue_script('rozholy-dashboard', ROZHOLY_URI . '/assets/js/dashboard.js', [], ROZHOLY_VERSION, true);

        wp_localize_script('rozholy-dashboard', 'rozholyDashboard', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('rozholy_dashboard_nonce'),
        ]);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('enqueue_block_editor_assets', 'rozholy_block_editor_assets');
function rozholy_block_editor_assets() {
    wp_enqueue_style('rozholy-editor-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Dancing+Script:wght@400;500;600;700&display=swap', [], null);
    wp_enqueue_style('rozholy-editor', ROZHOLY_URI . '/assets/css/editor.css', [], ROZHOLY_VERSION);
}

add_action('customize_preview_init', 'rozholy_customizer_preview');
function rozholy_customizer_preview() {
    wp_enqueue_script('rozholy-customizer', ROZHOLY_URI . '/assets/js/customizer.js', ['jquery', 'customize-preview'], ROZHOLY_VERSION, true);
}
