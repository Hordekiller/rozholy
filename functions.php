<?php

define('ROZHOLY_VERSION', '1.0.0');
define('ROZHOLY_DIR', get_template_directory());
define('ROZHOLY_URI', get_template_directory_uri());

require ROZHOLY_DIR . '/inc/setup.php';
require ROZHOLY_DIR . '/inc/enqueue.php';
require ROZHOLY_DIR . '/inc/customizer.php';
require ROZHOLY_DIR . '/inc/widgets.php';
require ROZHOLY_DIR . '/inc/elementor.php';

if (class_exists('WooCommerce')) {
    require ROZHOLY_DIR . '/inc/woocommerce-setup.php';
}

require ROZHOLY_DIR . '/rozholy-ajax-handler.php';
