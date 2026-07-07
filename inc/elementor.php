<?php

if (!did_action('elementor/loaded')) return;

add_action('elementor/theme/register_locations', 'rozholy_elementor_locations');
function rozholy_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_location('header');
    $elementor_theme_manager->register_location('footer');
    $elementor_theme_manager->register_location('single');
    $elementor_theme_manager->register_location('archive');
}

add_action('elementor/widgets/register', 'rozholy_register_elementor_widgets');
function rozholy_register_elementor_widgets($widgets_manager) {
    $widgets_dir = ROZHOLY_DIR . '/elementor-widgets';

    $widget_files = glob($widgets_dir . '/class-*.php');
    foreach ($widget_files as $file) {
        require_once $file;
        $class_name = 'Rozholy_' . basename($file, '.php');
        $class_name = str_replace('class-', '', $class_name);
        $class_name = implode('_', array_map('ucfirst', explode('-', $class_name)));
        if (class_exists($class_name)) {
            $widgets_manager->register(new $class_name());
        }
    }
}

add_action('elementor/elements/categories_registered', 'rozholy_elementor_categories');
function rozholy_elementor_categories($elements_manager) {
    $elements_manager->add_category('rozholy', [
        'title' => esc_html__('Rozholy', 'rozholy'),
        'icon'  => 'eicon-star',
    ]);
}

add_filter('elementor/editor/localize_settings', 'rozholy_elementor_editor_colors');
function rozholy_elementor_editor_colors($config) {
    $config['schemes']['system_schemes']['rozholy'] = [
        'title' => 'Rozholy',
        'items' => [
            'primary'   => get_theme_mod('rz_primary', '#d4a0a0'),
            'secondary' => get_theme_mod('rz_secondary', '#b8a0c0'),
            'accent'    => get_theme_mod('rz_accent', '#c8a87c'),
            'dark'      => '#2d2d2d',
            'text'      => '#4a4a4a',
            'bg'        => '#faf5f0',
        ],
    ];
    return $config;
}

add_filter('elementor/fonts/additional_fonts', function($fonts) {
    $fonts['Vazirmatn'] = 'system';
    return $fonts;
});

add_filter('elementor/document/config', function($config) {
    $config['settings']['css_print_method'] = 'external';
    return $config;
});
