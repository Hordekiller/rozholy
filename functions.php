<?php
defined('ABSPATH') || exit;

define('ROZHOLY_VERSION', '2.0.0');
define('ROZHOLY_DIR', get_template_directory());
define('ROZHOLY_URI', get_template_directory_uri());

$rozholy_includes = [
    'inc/setup.php',
    'inc/enqueue.php',
    'inc/customizer.php',
    'inc/template-functions.php',
    'inc/security.php',
    'inc/woocommerce.php',
    'inc/dashboard.php',
];

foreach ($rozholy_includes as $file) {
    $path = ROZHOLY_DIR . '/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}
