<?php
defined( 'ABSPATH' ) || exit;

define( 'ROZHOLY_VERSION', '2.0.0' );
define( 'ROZHOLY_DIR', get_template_directory() );
define( 'ROZHOLY_URI', get_template_directory_uri() );

$rozholy_includes = array(
	'inc/requirements.php',
	'inc/setup.php',
	'inc/enqueue.php',
	'inc/customizer.php',
	'inc/panel/class-theme-panel.php',
	'inc/template-functions.php',
	'inc/security.php',
	'inc/woocommerce.php',
	'inc/dashboard.php',
	'inc/elementor.php',
	'inc/schema.php',
	'inc/optimization.php',
	'inc/seo.php',
);

foreach ( $rozholy_includes as $file ) {
	$path = ROZHOLY_DIR . '/' . $file;
	if ( file_exists( $path ) ) {
		require_once $path;
	}
}
