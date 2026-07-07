<?php
defined('ABSPATH') || exit;

/* ── Get social links from Customizer ── */
function rozholy_get_social_links() {
    $socials = ['instagram', 'telegram', 'whatsapp', 'youtube', 'facebook', 'twitter', 'linkedin', 'pinterest'];
    $links = [];

    foreach ($socials as $key) {
        $url = get_theme_mod("rozholy_social_{$key}", '');
        if (! empty($url)) {
            $links[$key] = $url;
        }
    }

    return $links;
}

/* ── Get header layout class ── */
function rozholy_header_class() {
    $layout = get_theme_mod('rozholy_header_layout', 'default');
    $sticky = get_theme_mod('rozholy_sticky_header', 'on');
    $classes = $layout === 'transparent' ? 'site-header--transparent' : '';
    if ($sticky === 'off') $classes .= ' site-header--no-sticky';
    return trim($classes);
}

/* ── Pagination helper ── */
function rozholy_pagination() {
    the_posts_pagination([
        'mid_size'  => 2,
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
    ]);
}

/* ── Excerpt length from Customizer ── */
add_filter('excerpt_length', 'rozholy_excerpt_length');
function rozholy_excerpt_length($length) {
    return get_theme_mod('rozholy_excerpt_length', 25);
}

/* ── Excerpt more ── */
add_filter('excerpt_more', 'rozholy_excerpt_more');
function rozholy_excerpt_more($more) {
    return '...';
}

/* ── Body classes ── */
add_filter('body_class', 'rozholy_body_classes');
function rozholy_body_classes($classes) {
    if (is_rtl()) $classes[] = 'rtl';

    $motion = get_theme_mod('rozholy_motion_intensity', 'full');
    if ($motion !== 'full') $classes[] = 'motion-' . $motion;

    $parallax = get_theme_mod('rozholy_parallax', 'on');
    if ($parallax === 'off') $classes[] = 'parallax-off';

    $sticky = get_theme_mod('rozholy_sticky_header', 'on');
    if ($sticky === 'off') $classes[] = 'no-sticky-header';

    return $classes;
}

/* ── Custom CSS output ── */
add_action('wp_head', 'rozholy_custom_css', 100);
function rozholy_custom_css() {
    $css = get_theme_mod('rozholy_custom_css', '');
    if (! empty($css)) {
        echo '<style id="rozholy-custom-css">' . wp_strip_all_tags($css) . '</style>' . "\n";
    }
}

/* ── Header scripts output ── */
add_action('wp_head', 'rozholy_header_scripts', 101);
function rozholy_header_scripts() {
    $scripts = get_theme_mod('rozholy_header_scripts', '');
    if (! empty($scripts)) {
        echo $scripts . "\n";
    }
}

/* ── Footer scripts output ── */
add_action('wp_footer', 'rozholy_footer_scripts', 100);
function rozholy_footer_scripts() {
    $scripts = get_theme_mod('rozholy_footer_scripts', '');
    if (! empty($scripts)) {
        echo $scripts . "\n";
    }
}


