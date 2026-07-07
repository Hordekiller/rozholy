<?php
/**
 * Template Name: Elementor Full Width
 * Description: Full-width page with theme header/footer, optimized for Elementor.
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	get_header(); ?><main style="padding:40px 20px;text-align:center;"><p><?php esc_html_e( 'لطفاً افزونه المنتور را نصب و فعال کنید.', 'rozholy' ); ?></p></main>
	<?php
	get_footer();
	return;
}

get_header();
?>

<main class="rozholy-elementor-main">
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
</main>

<?php
get_footer();
