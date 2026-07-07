<?php
defined('ABSPATH') || exit;

/* ── Get social links from Customizer ── */
function rozholy_get_social_links() {
    $socials = ['instagram', 'telegram', 'whatsapp', 'youtube'];
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
    return $layout === 'transparent' ? 'site-header--transparent' : '';
}

/* ── Pagination helper ── */
function rozholy_pagination() {
    the_posts_pagination([
        'mid_size'  => 2,
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
    ]);
}

/* ── Excerpt length ── */
add_filter('excerpt_length', 'rozholy_excerpt_length');
function rozholy_excerpt_length($length) {
    return 25;
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
    if ($motion !== 'full') {
        $classes[] = 'motion-' . $motion;
    }

    return $classes;
}
