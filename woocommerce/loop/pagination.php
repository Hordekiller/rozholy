<?php
global $wp_query;
$total   = isset($total) ? $total : wc_get_loop_prop('total_pages');
$current = isset($current) ? $current : wc_get_loop_prop('current_page');
$base    = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format  = isset($format) ? $format : '';

if ($total <= 1) return;

echo '<nav class="woocommerce-pagination pagination">';
echo paginate_links(apply_filters('woocommerce_pagination_args', [
    'base'      => $base,
    'format'    => $format,
    'add_args'  => false,
    'current'   => max(1, $current),
    'total'     => $total,
    'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>',
    'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>',
    'type'      => 'plain',
    'end_size'  => 3,
    'mid_size'  => 3,
]));
echo '</nav>';
