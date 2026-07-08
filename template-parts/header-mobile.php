<?php
defined( 'ABSPATH' ) || exit;
$logo_id = rozholy_get_option( 'logo' );
?><header id="rz-mobile-header" class="rz-mobile-header rz-mobile-only" role="banner">
	<div class="rz-mh-inner">

		<button class="rz-mh-hamburger" id="rz-mh-hamburger" aria-label="<?php esc_attr_e( 'Menu', 'rozholy' ); ?>" aria-expanded="false" type="button">
			<span class="rz-hamburger-box">
				<span class="rz-hamburger-inner"></span>
			</span>
		</button>

		<div class="rz-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php
				if ( $logo_id ) :
					echo wp_get_attachment_image( $logo_id, 'full', '', array( 'class' => 'rz-logo-img', 'alt' => get_bloginfo( 'name' ) ) );
				else :
					echo '<span class="rz-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
				endif;
				?>
			</a>
		</div>

		<div class="rz-mh-actions">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="rz-mh-cart" aria-label="<?php esc_attr_e( 'Cart', 'rozholy' ); ?>">
				<svg viewBox="0 0 24 24" width="20" height="20"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.17 14.75l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25z" fill="currentColor"/></svg>
				<span class="rz-mh-cart-count"><?php echo WC()->cart ? absint( WC()->cart->get_cart_contents_count() ) : 0; ?></span>
			</a>
			<?php endif; ?>
		</div>

	</div>
</header>

<div class="rz-mh-drawer" id="rz-mh-drawer" aria-hidden="true">
	<div class="rz-mh-drawer-inner">
		<div class="rz-mh-drawer-header">
			<div class="rz-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php
					if ( $logo_id ) :
						echo wp_get_attachment_image( $logo_id, 'full', '', array( 'class' => 'rz-logo-img', 'alt' => get_bloginfo( 'name' ) ) );
					else :
						echo '<span class="rz-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
					endif;
					?>
				</a>
			</div>
			<button class="rz-mh-drawer-close" id="rz-mh-drawer-close" aria-label="<?php esc_attr_e( 'Close menu', 'rozholy' ); ?>" type="button">&times;</button>
		</div>
		<nav class="rz-mh-drawer-nav" role="navigation" aria-label="<?php esc_attr_e( 'Mobile menu', 'rozholy' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'rz-mh-drawer-menu',
						'fallback_cb'    => false,
						'depth'          => 3,
					)
				);
			} else {
				wp_page_menu(
					array(
						'menu_class' => 'rz-mh-drawer-menu',
						'container'  => false,
					)
				);
			}
			?>
		</nav>
		<div class="rz-mh-drawer-footer">
			<?php
			$socials = rozholy_get_social_links();
			foreach ( $socials as $key => $url ) :
				?>
				<a href="<?php echo esc_url( $url ); ?>" class="rz-mh-drawer-social" aria-label="<?php echo esc_attr( $key ); ?>" target="_blank" rel="noopener">
					<svg viewBox="0 0 24 24" width="20" height="20"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><text x="12" y="16" text-anchor="middle" font-size="10" fill="currentColor"><?php echo esc_html( $key[0] ); ?></text></svg>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="rz-mh-overlay" id="rz-mh-overlay"></div>
