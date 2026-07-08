<?php
defined( 'ABSPATH' ) || exit;
?><header id="rz-masthead" class="rz-site-header rz-desktop-only" role="banner">
	<div class="rz-header-main">
		<div class="rz-header-inner">

			<div class="rz-header-left">
				<div class="rz-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php
						$logo_id = rozholy_get_option( 'logo' );
						if ( $logo_id ) :
							echo wp_get_attachment_image( $logo_id, 'full', '', array( 'class' => 'rz-logo-img', 'alt' => get_bloginfo( 'name' ) ) );
						else :
							echo '<span class="rz-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
						endif;
						?>
					</a>
				</div>
			</div>

			<nav class="rz-desktop-nav" id="rz-desktop-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'rozholy' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'rz-primary-menu',
							'fallback_cb'    => false,
							'depth'          => 3,
						)
					);
				} else {
					wp_page_menu(
						array(
							'menu_class' => 'rz-primary-menu',
							'container'  => false,
						)
					);
				}
				?>
			</nav>

			<div class="rz-header-actions">
				<button class="rz-search-toggle" id="rz-search-toggle" aria-label="<?php esc_attr_e( 'Search', 'rozholy' ); ?>" type="button">
					<svg viewBox="0 0 24 24" width="22" height="22"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" fill="currentColor"/></svg>
				</button>

				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="rz-cart-link" aria-label="<?php esc_attr_e( 'Cart', 'rozholy' ); ?>">
					<svg viewBox="0 0 24 24" width="22" height="22"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.17 14.75l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25z" fill="currentColor"/></svg>
					<span class="rz-cart-count" id="rz-cart-count"><?php echo WC()->cart ? absint( WC()->cart->get_cart_contents_count() ) : 0; ?></span>
				</a>
				<?php endif; ?>

			<div class="rz-account-wrap">
				<a href="<?php echo esc_url( is_user_logged_in() ? home_url( '/my-account' ) : home_url( '/login/' ) ); ?>" class="rz-account-link" aria-label="<?php esc_attr_e( 'My Account', 'rozholy' ); ?>">
					<svg viewBox="0 0 24 24" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/></svg>
				</a>
				<?php if ( is_user_logged_in() ) : ?>
				<div class="rz-account-dropdown">
					<div class="rz-account-dropdown-header">
						<?php
						$cu = wp_get_current_user();
						$avatar_id = get_user_meta( $cu->ID, 'rozholy_avatar_id', true );
						if ( $avatar_id ) {
							echo wp_get_attachment_image( $avatar_id, array( 40, 40 ), '', array( 'class' => 'rz-dropdown-avatar' ) );
						} else {
							echo '<div class="rz-dropdown-avatar-initials">' . esc_html( mb_substr( $cu->display_name, 0, 2 ) ) . '</div>';
						}
						?>
						<div class="rz-dropdown-user-info">
							<strong><?php echo esc_html( $cu->first_name ? $cu->first_name . ' ' . $cu->last_name : $cu->display_name ); ?></strong>
							<small><?php echo esc_html( get_user_meta( $cu->ID, 'rozholy_phone', true ) ?: $cu->user_login ); ?></small>
						</div>
					</div>
					<a href="<?php echo esc_url( home_url( '/my-account/' ) ); ?>" class="rz-dropdown-item"><?php esc_html_e( 'پیشخوان', 'rozholy' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/my-account/?tab=bookings' ) ); ?>" class="rz-dropdown-item"><?php esc_html_e( 'نوبت‌های من', 'rozholy' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/my-account/?tab=orders' ) ); ?>" class="rz-dropdown-item"><?php esc_html_e( 'سفارش‌ها', 'rozholy' ); ?></a>
					<div class="rz-dropdown-divider"></div>
					<a href="<?php echo esc_url( home_url( '/my-account/?tab=profile' ) ); ?>" class="rz-dropdown-item"><?php esc_html_e( 'اطلاعات حساب', 'rozholy' ); ?></a>
					<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="rz-dropdown-item rz-dropdown-item--danger"><?php esc_html_e( 'خروج', 'rozholy' ); ?></a>
				</div>
				<?php endif; ?>
			</div>

				<?php
				$phone = rozholy_get_option( 'contact_phone' );
				if ( $phone && 'on' === rozholy_get_option( 'header_cta', 'on' ) ) :
				?>
				<a href="<?php echo esc_url( home_url( '/booking' ) ); ?>" class="rz-header-cta"><?php esc_html_e( 'Book Now', 'rozholy' ); ?></a>
				<?php endif; ?>
			</div>

		</div>
	</div>
</header>
