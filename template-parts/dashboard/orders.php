<div class="dashboard-card">
	<div class="dashboard-card__header">
		<h3><?php esc_html_e( 'سفارش‌های من', 'rozholy' ); ?></h3>
	</div>
	<div class="dashboard-card__body">
		<?php
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<p>' . esc_html__( 'فروشگاه در دسترس نیست.', 'rozholy' ) . '</p>';
		} else {
			$customer_orders = wc_get_orders( array(
				'customer' => get_current_user_id(),
				'limit'    => 20,
				'orderby'  => 'date',
				'order'    => 'DESC',
			) );

			if ( empty( $customer_orders ) ) {
				rozholy_empty_state( 'orders' );
			} else {
				echo '<div class="rz-orders-list">';
				foreach ( $customer_orders as $order ) {
					$order_id = $order->get_id();
					$status   = wc_get_order_status_name( $order->get_status() );
					$total    = $order->get_total();
					$date     = $order->get_date_created();
					$items    = $order->get_item_count();
					?>
					<div class="rz-order-item">
						<div class="rz-order-item__info">
							<span class="rz-order-item__id">#<?php echo esc_html( $order_id ); ?></span>
							<span class="rz-order-item__date"><?php echo esc_html( $date ? $date->date_i18n( 'Y/m/d' ) : '---' ); ?></span>
							<span class="rz-order-item__count"><?php echo esc_html( sprintf( _n( '%d آیتم', '%d آیتم', $items, 'rozholy' ), $items ) ); ?></span>
						</div>
						<div class="rz-order-item__actions">
							<span class="rz-order-status"><?php echo esc_html( $status ); ?></span>
							<span class="rz-order-total"><?php echo wp_kses_post( wc_price( $total ) ); ?></span>
							<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="dashboard-btn dashboard-btn--outline" style="padding:4px 14px;font-size:0.8rem;"><?php esc_html_e( 'مشاهده', 'rozholy' ); ?></a>
						</div>
					</div>
					<?php
				}
				echo '</div>';
			}
		}
		?>
	</div>
</div>

<style>
.rz-orders-list { display:flex; flex-direction:column; gap:10px; }
.rz-order-item { display:flex; justify-content:space-between; align-items:center; padding:14px 16px; background:#f9fafb; border-radius:10px; border:1px solid #e5e7eb; flex-wrap:wrap; gap:8px; }
.rz-order-item__info { display:flex; flex-direction:column; gap:3px; }
.rz-order-item__id { font-weight:600; font-size:0.9rem; color:#1f2937; direction:ltr; unicode-bidi:plaintext; }
.rz-order-item__date { font-size:0.8rem; color:#9ca3af; }
.rz-order-item__count { font-size:0.8rem; color:#6b7280; }
.rz-order-item__actions { display:flex; align-items:center; gap:12px; }
.rz-order-status { font-size:0.8rem; padding:3px 10px; border-radius:999px; background:#f3f4f6; color:#374151; }
.rz-order-total { font-weight:600; font-size:0.9rem; color:#1f2937; direction:ltr; unicode-bidi:plaintext; }
</style>
