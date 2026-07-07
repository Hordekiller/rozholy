<?php
defined( 'ABSPATH' ) || exit;

$enabled = rozholy_get_option( 'mobile_bottom_nav', 'on' );
if ( 'off' === $enabled ) {
	return;
}

$items = apply_filters(
	'rozholy_bottom_nav_items',
	array(
		'home'     => array(
			'label'  => __( 'Home', 'rozholy' ),
			'url'    => home_url( '/' ),
			'icon'   => '<svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>',
			'active' => is_front_page(),
		),
		'services' => array(
			'label'  => __( 'Services', 'rozholy' ),
			'url'    => home_url( '/services' ),
			'icon'   => '<svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
			'active' => is_page( 'services' ),
		),
		'booking'  => array(
			'label'  => __( 'Book', 'rozholy' ),
			'url'    => home_url( '/booking' ),
			'icon'   => '<svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>',
			'fab'    => true,
			'active' => is_page( 'booking' ),
		),
		'shop'     => array(
			'label'  => __( 'Shop', 'rozholy' ),
			'url'    => class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ),
			'icon'   => '<svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.17 14.75l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25z"/></svg>',
			'badge'  => true,
			'active' => class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product() ),
		),
		'account'  => array(
			'label'  => __( 'Account', 'rozholy' ),
			'url'    => is_user_logged_in() ? home_url( '/dashboard' ) : wp_login_url(),
			'icon'   => '<svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>',
			'active' => is_user_logged_in() && is_page( 'dashboard' ),
		),
	)
);
?>
<nav class="rz-bottom-nav" data-hide-on-scroll="<?php echo esc_attr( rozholy_get_option( 'bottom_nav_hide_scroll', 'on' ) ); ?>" role="navigation" aria-label="<?php esc_attr_e( 'Mobile bottom navigation', 'rozholy' ); ?>">
	<div class="rz-bottom-nav-inner">
	<?php foreach ( $items as $key => $item ) : ?>
		<?php if ( ! empty( $item['fab'] ) ) : ?>
		<div class="rz-nav-fab-item" style="flex-shrink:0;display:flex;align-items:center;justify-content:center;width:56px;height:56px;position:relative;top:-16px;">
			<a href="<?php echo esc_url( $item['url'] ); ?>" class="rz-nav-fab rz-nav-fab-pulse" aria-label="<?php echo esc_attr( $item['label'] ); ?>">
			<?php echo $item['icon']; ?>
			</a>
		</div>
		<?php else : ?>
		<a href="<?php echo esc_url( $item['url'] ); ?>" class="rz-nav-item<?php echo ! empty( $item['active'] ) ? ' is-active' : ''; ?>">
			<span class="rz-nav-indicator"></span>
			<span class="rz-nav-icon"><?php echo $item['icon']; ?>
			<?php if ( ! empty( $item['badge'] ) && class_exists( 'WooCommerce' ) && WC()->cart ) : ?>
				<span class="rz-nav-cart-badge" style="display:<?php echo WC()->cart->get_cart_contents_count() > 0 ? 'flex' : 'none'; ?>"><?php echo absint( WC()->cart->get_cart_contents_count() ); ?></span>
			<?php endif; ?>
			</span>
			<span class="rz-nav-label"><?php echo esc_html( $item['label'] ); ?></span>
		</a>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
</nav>
<?php
add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'has-bottom-nav';
		return $classes;
	}
);
