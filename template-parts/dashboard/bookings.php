<div class="dashboard-card">
	<div class="dashboard-card__header">
		<h3><?php esc_html_e( 'نوبت‌های من', 'rozholy' ); ?></h3>
	</div>
	<div class="dashboard-card__body" id="rz-my-bookings">
		<p class="dashboard-loading"><?php esc_html_e( 'در حال بارگذاری...', 'rozholy' ); ?></p>
	</div>
</div>

<script>
(function() {
	const container = document.getElementById('rz-my-bookings');
	if (!container) return;

	function normalizeDigits(str) {
		return String(str).replace(/[۰-۹]/g, function(d) { return String.fromCharCode(d.charCodeAt(0) - 1728); })
		                  .replace(/[٠-٩]/g, function(d) { return String.fromCharCode(d.charCodeAt(0) - 1584); });
	}

	function toPersianDigits(num) {
		return String(num).replace(/\d/g, function(d) { return '۰۱۲۳۴۵۶۷۸۹'[parseInt(d)]; });
	}

	fetch('/wp-json/rozholy-companion/v1/my-bookings', {
		headers: { 'X-WP-Nonce': '<?php echo esc_js( wp_create_nonce( 'wp_rest' ) ); ?>' }
	})
	.then(function(r) { return r.json(); })
	.then(function(data) {
		if (!data.items || data.items.length === 0) {
			container.innerHTML = '<div class="dashboard-empty-state" style="text-align:center;padding:40px 20px;"><p style="color:#6b7280;"><?php echo esc_js( __( 'هنوز رزروی ثبت نکرده‌اید.', 'rozholy' ) ); ?></p><a href="<?php echo esc_url( home_url( '/booking/' ) ); ?>" class="dashboard-btn dashboard-btn--primary" style="display:inline-block;margin-top:16px;text-decoration:none;"><?php echo esc_js( __( 'رزرو اولین نوبت', 'rozholy' ) ); ?></a></div>';
			return;
		}
		var html = '<div class="rz-bookings-list" style="display:flex;flex-direction:column;gap:12px;">';
		data.items.forEach(function(b) {
			var statusLabel = b.status;
			var statusClass = 'rz-badge--' + b.status;
			switch (b.status) {
				case 'pending': statusLabel = '<?php echo esc_js( __( 'در انتظار تأیید', 'rozholy' ) ); ?>'; break;
				case 'confirmed': statusLabel = '<?php echo esc_js( __( 'تأیید شده', 'rozholy' ) ); ?>'; break;
				case 'completed': statusLabel = '<?php echo esc_js( __( 'انجام شده', 'rozholy' ) ); ?>'; break;
				case 'cancelled': statusLabel = '<?php echo esc_js( __( 'لغو شده', 'rozholy' ) ); ?>'; break;
			}
			var canCancel = (b.status === 'pending' || b.status === 'confirmed');
			var dateStr = b.bookingDate || '---';
			var persianDate = normalizeDigits(dateStr);
			html += '<div class="rz-booking-item" style="display:flex;align-items:center;justify-content:space-between;padding:16px;background:#f9f9f9;border-radius:12px;border:1px solid #eee;flex-wrap:wrap;gap:8px;">';
			html += '<div style="display:flex;flex-direction:column;gap:4px;">';
			html += '<span style="font-weight:600;font-size:14px;">' + (b.service || '---') + '</span>';
			html += '<span style="font-size:12px;color:#888;">' + persianDate + '</span>';
			html += '</div>';
			html += '<div style="display:flex;align-items:center;gap:8px;">';
			html += '<span class="rz-badge ' + statusClass + '" style="display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;';
			if (b.status === 'pending') html += 'background:#fff3cd;color:#856404;';
			else if (b.status === 'confirmed') html += 'background:#d4edda;color:#155724;';
			else if (b.status === 'completed') html += 'background:#cce5ff;color:#004085;';
			else html += 'background:#f8d7da;color:#721c24;';
			html += '">' + statusLabel + '</span>';
			if (canCancel) {
				html += '<button class="rz-cancel-booking-btn" data-id="' + b.id + '" style="padding:6px 14px;border:none;border-radius:20px;background:#fef2f2;color:#dc2626;font-size:12px;font-weight:600;cursor:pointer;"><?php echo esc_js( __( 'لغو', 'rozholy' ) ); ?></button>';
			}
			html += '</div></div>';
		});
		html += '</div>';
		container.innerHTML = html;

		document.querySelectorAll('.rz-cancel-booking-btn').forEach(function(btn) {
			btn.addEventListener('click', function() {
				if (!confirm('<?php echo esc_js( __( 'آیا از لغو این نوبت اطمینان دارید؟', 'rozholy' ) ); ?>')) return;
				var id = this.dataset.id;
				var nonce = '<?php echo esc_js( wp_create_nonce( 'rozholy_cancel_booking' ) ); ?>';
				var parent = this.closest('.rz-booking-item');
				this.disabled = true;
				this.textContent = '...';
				fetch('/wp-json/rozholy-companion/v1/bookings/' + id + '/cancel', {
					method: 'PUT',
					headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': '<?php echo esc_js( wp_create_nonce( 'wp_rest' ) ); ?>' },
					body: JSON.stringify({ _wpnonce: nonce })
				})
				.then(function(r) { return r.json(); })
				.then(function(data) {
					if (data.success) {
						if (parent) {
							parent.querySelector('.rz-badge').textContent = '<?php echo esc_js( __( 'لغو شده', 'rozholy' ) ); ?>';
							parent.querySelector('.rz-badge').style.background = '#f8d7da';
							parent.querySelector('.rz-badge').style.color = '#721c24';
							btn.remove();
						}
					} else {
						alert(data.message || '<?php echo esc_js( __( 'خطا در لغو نوبت.', 'rozholy' ) ); ?>');
						btn.disabled = false;
						btn.textContent = '<?php echo esc_js( __( 'لغو', 'rozholy' ) ); ?>';
					}
				})
				.catch(function() {
					btn.disabled = false;
					btn.textContent = '<?php echo esc_js( __( 'لغو', 'rozholy' ) ); ?>';
					alert('<?php echo esc_js( __( 'خطا در ارتباط با سرور.', 'rozholy' ) ); ?>');
				});
			});
		});
	})
	.catch(function() {
		container.innerHTML = '<div class="dashboard-notice dashboard-notice--error"><?php echo esc_js( __( 'خطا در بارگذاری نوبت‌ها.', 'rozholy' ) ); ?></div>';
	});
})();
</script>
