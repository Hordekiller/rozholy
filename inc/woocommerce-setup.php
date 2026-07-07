<?php

add_action('after_setup_theme', 'rozholy_woocommerce_setup');
function rozholy_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

add_action('wp_enqueue_scripts', 'rozholy_woocommerce_scripts', 20);
function rozholy_woocommerce_scripts() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('rozholy-woocommerce', ROZHOLY_URI . '/assets/css/woocommerce.css', ['rozholy-main'], ROZHOLY_VERSION);
    }
}

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'rozholy_woocommerce_wrapper_start', 10);
function rozholy_woocommerce_wrapper_start() {
    echo '<div class="container"><div class="woocommerce-content">';
}

add_action('woocommerce_after_main_content', 'rozholy_woocommerce_wrapper_end', 10);
function rozholy_woocommerce_wrapper_end() {
    echo '</div></div>';
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 25);

add_action('woocommerce_before_shop_loop', 'rozholy_shop_header', 15);
function rozholy_shop_header() {
    if (!woocommerce_product_loop()) return;
    ?>
    <div class="shop-header">
      <div class="shop-header-inner">
        <?php woocommerce_result_count(); ?>
        <?php woocommerce_catalog_ordering(); ?>
      </div>
    </div>
    <?php
}

add_filter('loop_shop_per_page', function() { return 12; }, 20);

add_filter('woocommerce_breadcrumb_defaults', function($args) {
    return [
        'delimiter'   => ' <span class="breadcrumb-sep">/</span> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => esc_html__('خانه', 'rozholy'),
    ];
});

add_filter('woocommerce_show_page_title', '__return_false');

add_filter('woocommerce_add_to_cart_fragments', 'rozholy_cart_count_fragment');
function rozholy_cart_count_fragment($fragments) {
    ob_start();
    ?>
    <span class="header-cart-count" id="header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['#header-cart-count'] = ob_get_clean();
    return $fragments;
}

add_filter('woocommerce_output_related_products_args', function($args) {
    $args['posts_per_page'] = 4;
    $args['columns']        = 4;
    return $args;
});

add_filter('woocommerce_cross_sells_total', function() { return 4; });
add_filter('woocommerce_cross_sells_columns', function() { return 4; });

add_action('woocommerce_after_shop_loop_item_title', 'rozholy_short_description', 15);
function rozholy_short_description() {
    global $product;
    $short_desc = $product->get_short_description();
    if ($short_desc) {
        echo '<p class="product-short-desc">' . wp_trim_words($short_desc, 10) . '</p>';
    }
}

add_filter('woocommerce_product_loop_start', 'rozholy_product_loop_start');
function rozholy_product_loop_start($loop_html) {
    return '<ul class="products rozholy-products">';
}

add_filter('woocommerce_pagination_args', function($args) {
    $args['prev_text'] = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>';
    $args['next_text'] = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>';
    return $args;
});

add_action('wp_footer', 'rozholy_woocommerce_quantity_script');
function rozholy_woocommerce_quantity_script() {
    if (!is_product() && !is_cart()) return;
    ?>
    <script>
    (function() {
        document.querySelectorAll('.quantity .plus, .quantity .minus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = this.parentElement.querySelector('input[type="number"]');
                if (!input) return;
                var current = parseInt(input.value) || 1;
                var min = parseInt(input.min) || 1;
                var max = parseInt(input.max) || 9999;
                if (this.classList.contains('plus')) {
                    if (current < max) input.value = current + 1;
                } else {
                    if (current > min) input.value = current - 1;
                }
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
    })();
    </script>
    <?php
}
