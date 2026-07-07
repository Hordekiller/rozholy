<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/* ── Wrapper ── */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'rozholy_wc_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'rozholy_wc_wrapper_end', 10 );

function rozholy_wc_wrapper_start() {
	echo '<main class="wc-main"><div class="wc-container">';
}

function rozholy_wc_wrapper_end() {
	echo '</div></main>';
}

/* ── Mini-cart fragment ── */
add_filter( 'woocommerce_add_to_cart_fragments', 'rozholy_cart_fragment' );
function rozholy_cart_fragment( $fragments ) {
	ob_start();
	?><span class="wc-block-mini-cart__badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	<?php
	$fragments['.wc-block-mini-cart__badge'] = ob_get_clean();
	return $fragments;
}

/* ── Products per page ── */
add_filter( 'loop_shop_per_page', 'rozholy_products_per_page', 20 );
function rozholy_products_per_page() {
	return 12;
}

/* ── Columns ── */
add_filter( 'loop_shop_columns', 'rozholy_shop_columns' );
function rozholy_shop_columns() {
	return 3;
}

/* ── Body class ── */
add_filter( 'body_class', 'rozholy_woo_body_class' );
function rozholy_woo_body_class( $classes ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'woocommerce-active';
	}
	return $classes;
}
