<?php
defined('ABSPATH') || exit;

if (! defined('ELEMENTOR_VERSION')) return;

/* ── Theme support ── */
add_action('after_setup_theme', 'rozholy_elementor_support');
function rozholy_elementor_support() {
    add_theme_support('elementor');

    if (defined('ELEMENTOR_PRO_VERSION')) {
        add_theme_support('elementor-pro');
    }
}

/* ── Register Elementor locations (Pro) ── */
add_action('elementor/theme/register_locations', 'rozholy_register_elementor_locations');
function rozholy_register_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_all_core_location();
}

/* ── Content wrapper ── */
add_action('elementor/page_templates/canvas/before_content', 'rozholy_elementor_canvas_before');
add_action('elementor/page_templates/canvas/after_content', 'rozholy_elementor_canvas_after');

function rozholy_elementor_canvas_before() {
    echo '<div class="rozholy-elementor-canvas">';
}

function rozholy_elementor_canvas_after() {
    echo '</div>';
}

/* ── Register Elementor category ── */
add_action('elementor/elements/categories_registered', 'rozholy_elementor_category');
function rozholy_elementor_category($elements_manager) {
    $elements_manager->add_category('rozholy', [
        'title' => esc_html__('Rozholy', 'rozholy'),
        'icon'  => 'eicon-gallery-grid',
    ]);
}

/* ── Register custom widgets ── */
add_action('elementor/widgets/register', 'rozholy_register_elementor_widgets');
function rozholy_register_elementor_widgets($widgets_manager) {
    $widgets_dir = ROZHOLY_DIR . '/elementor-widgets';

    $widgets = [
        'class-hero-banner.php'     => 'Rozholy_Hero_Banner',
        'class-service-grid.php'    => 'Rozholy_Service_Grid',
        'class-testimonials.php'    => 'Rozholy_Testimonials',
        'class-gallery.php'         => 'Rozholy_Gallery',
        'class-booking-form.php'    => 'Rozholy_Booking_Form',
    ];

    foreach ($widgets as $file => $class) {
        $path = $widgets_dir . '/' . $file;
        if (file_exists($path)) {
            require_once $path;
            if (class_exists($class)) {
                $widgets_manager->register(new $class());
            }
        }
    }
}

/* ── Elementor body class ── */
add_filter('body_class', 'rozholy_elementor_body_class');
function rozholy_elementor_body_class($classes) {
    if (rozholy_is_elementor()) {
        $classes[] = 'rozholy-elementor';
    }
    return $classes;
}

function rozholy_is_elementor() {
    if (! defined('ELEMENTOR_VERSION')) return false;

    if (class_exists('\Elementor\Plugin')) {
        $document = \Elementor\Plugin::$instance->documents->get(get_the_ID());
        if ($document && $document->is_built_with_elementor()) {
            return true;
        }
    }

    return false;
}

/* ── Enqueue Elementor styles ── */
add_action('elementor/editor/before_enqueue_scripts', 'rozholy_elementor_editor_styles');
function rozholy_elementor_editor_styles() {
    wp_enqueue_style('rozholy-editor-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Dancing+Script:wght@400;500;600;700&display=swap', [], null);
}

/* ── Disable default FSE styles when Elementor is active on the page ── */
add_action('wp', 'rozholy_elementor_disable_fse');
function rozholy_elementor_disable_fse() {
    if (rozholy_is_elementor()) {
        remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    }
}

/* ── Elementor theme builder fallback: use FSE parts ── */
add_action('elementor/theme/after_do_header', 'rozholy_elementor_after_header');
function rozholy_elementor_after_header() {
    echo '<main class="rozholy-elementor-content">';
}

add_action('elementor/theme/before_do_footer', 'rozholy_elementor_before_footer');
function rozholy_elementor_before_footer() {
    echo '</main>';
}
