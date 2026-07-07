<?php
/**
 * Template Name: Elementor Canvas
 * Description: Blank page for Elementor — no header or footer.
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	get_header(); ?><main style="padding:40px 20px;text-align:center;"><p><?php esc_html_e( 'لطفاً افزونه المنتور را نصب و فعال کنید.', 'rozholy' ); ?></p></main>
	<?php
	get_footer();
	return;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'elementor-canvas' ); ?>>
<?php wp_body_open(); ?>

<?php
do_action( 'elementor/page_templates/canvas/before_content' );

while ( have_posts() ) {
	the_post();
	the_content();
}

do_action( 'elementor/page_templates/canvas/after_content' );

wp_footer();
?>
</body>
</html>
