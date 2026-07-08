<?php
defined( 'ABSPATH' ) || exit;
$user  = wp_get_current_user();
$phone = get_user_meta( $user->ID, 'rozholy_phone', true ) ?: $user->user_login;
$first_name = $user->first_name ?: $user->display_name;
?>
<div class="dashboard-dashboard">
	<div class="dashboard-content__header">
		<h1 class="dashboard-content__title"><?php printf( esc_html__( 'سلام، %s عزیز 👋', 'rozholy' ), esc_html( $first_name ) ); ?></h1>
		<p class="dashboard-content__greeting"><?php esc_html_e( 'به پنل کاربری خود خوش آمدید.', 'rozholy' ); ?></p>
	</div>

	<div class="dashboard-cards">
		<?php
		$next_booking = rozholy_get_next_booking( $user->ID );
		$order_count  = rozholy_get_order_count( $user->ID );
		$booking_count = rozholy_get_booking_count( $user->ID );
		?>
		<div class="dashboard-stat-card">
			<div class="dsc-icon"><svg viewBox="0 0 24 24" width="28" height="28" fill="#d4a0a0"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg></div>
			<div class="dsc-value"><?php echo esc_html( $booking_count ); ?></div>
			<div class="dsc-label"><?php esc_html_e( 'نوبت‌ها', 'rozholy' ); ?></div>
		</div>
		<div class="dashboard-stat-card">
			<div class="dsc-icon"><svg viewBox="0 0 24 24" width="28" height="28" fill="#b8a0c0"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.17 14.75l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25z"/></svg></div>
			<div class="dsc-value"><?php echo esc_html( $order_count ); ?></div>
			<div class="dsc-label"><?php esc_html_e( 'سفارش‌ها', 'rozholy' ); ?></div>
		</div>
		<div class="dashboard-stat-card">
			<div class="dsc-icon"><svg viewBox="0 0 24 24" width="28" height="28" fill="#c8a87c"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm-4 4H7v2h2v-2zm4 0h-2v2h2v-2zm4-4h-2v2h2v-2z"/></svg></div>
			<div class="dsc-label"><?php esc_html_e( 'نوبت بعدی', 'rozholy' ); ?></div>
			<div class="dsc-sub"><?php echo $next_booking ? esc_html( $next_booking ) : esc_html__( '---', 'rozholy' ); ?></div>
		</div>
	</div>

	<div class="dashboard-quick-actions">
		<a href="<?php echo esc_url( home_url( '/booking/' ) ); ?>" class="dashboard-btn dashboard-btn--primary"><?php esc_html_e( 'رزرو نوبت جدید', 'rozholy' ); ?></a>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="dashboard-btn dashboard-btn--outline"><?php esc_html_e( 'مشاهده فروشگاه', 'rozholy' ); ?></a>
	</div>
</div>

<style>
.dashboard-dashboard .dashboard-content__header { margin-bottom:24px; }
.dashboard-cards { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:16px; margin-bottom:24px; }
.dashboard-stat-card { background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:20px; text-align:center; }
.dsc-icon { margin-bottom:10px; }
.dsc-value { font-size:1.8rem; font-weight:700; color:#1f2937; direction:ltr; unicode-bidi:plaintext; }
.dsc-label { font-size:0.85rem; color:#6b7280; margin-top:4px; }
.dsc-sub { font-size:0.85rem; color:#4b5563; margin-top:4px; font-weight:500; }
.dashboard-quick-actions { display:flex; gap:12px; flex-wrap:wrap; }
</style>
