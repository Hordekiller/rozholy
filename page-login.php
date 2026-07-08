<?php
defined( 'ABSPATH' ) || exit;

if ( is_user_logged_in() ) {
	wp_safe_redirect( home_url( '/my-account/' ) );
	exit;
}

get_header();
$redirect_to = '';
if ( isset( $_GET['redirect_to'] ) ) {
	$redirect_to = wp_validate_redirect( esc_url_raw( wp_unslash( $_GET['redirect_to'] ) ), home_url( '/my-account/' ) );
}
if ( isset( $_GET['password_changed'] ) ) {
	$notice = esc_html__( 'رمز عبور با موفقیت تغییر یافت. لطفاً دوباره وارد شوید.', 'rozholy' );
}
?>
<div class="rz-login-wrap">
	<div class="rz-login-card">
		<div class="rz-login-header">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rz-login-logo">
				<?php
				$logo_id = rozholy_get_option( 'logo' );
				if ( $logo_id ) {
					echo wp_get_attachment_image( $logo_id, 'full', '', array( 'class' => 'rz-login-logo-img', 'alt' => get_bloginfo( 'name' ) ) );
				} else {
					echo '<span class="rz-login-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
				}
				?>
			</a>
		</div>

		<?php if ( ! empty( $notice ) ) : ?>
		<div class="rz-login-notice rz-login-notice--success"><?php echo esc_html( $notice ); ?></div>
		<?php endif; ?>

		<div class="rz-login-tabs">
			<button class="rz-login-tab is-active" data-tab="otp"><?php esc_html_e( 'ورود با کد یکبارمصرف', 'rozholy' ); ?></button>
			<button class="rz-login-tab" data-tab="password"><?php esc_html_e( 'ورود با رمز عبور', 'rozholy' ); ?></button>
		</div>

		<div class="rz-login-panel is-active" id="rz-login-otp">
			<div class="rz-login-step" id="rz-otp-step-1">
				<p class="rz-login-desc"><?php esc_html_e( 'شماره موبایل خود را وارد کنید. کد تأیید برای شما پیامک می‌شود.', 'rozholy' ); ?></p>
				<div class="rz-login-field">
					<label for="rz-otp-phone"><?php esc_html_e( 'شماره موبایل', 'rozholy' ); ?></label>
					<input type="tel" id="rz-otp-phone" inputmode="numeric" autocomplete="tel" placeholder="۰۹۱۲۱۲۳۴۵۶۷" maxlength="11" class="rz-login-input ltr-input">
				</div>
				<button class="rz-login-btn rz-btn-primary" id="rz-otp-send" disabled><?php esc_html_e( 'ارسال کد تأیید', 'rozholy' ); ?></button>
				<div class="rz-login-error" id="rz-otp-error"></div>
			</div>

			<div class="rz-login-step" id="rz-otp-step-2" style="display:none">
				<p class="rz-login-desc"><?php esc_html_e( 'کد ۵ رقمی ارسال شده را وارد کنید.', 'rozholy' ); ?></p>
				<div class="rz-otp-code-wrap" id="rz-otp-code-wrap">
					<input type="text" inputmode="numeric" maxlength="1" class="rz-otp-input" data-index="0" autocomplete="one-time-code">
					<input type="text" inputmode="numeric" maxlength="1" class="rz-otp-input" data-index="1" autocomplete="off">
					<input type="text" inputmode="numeric" maxlength="1" class="rz-otp-input" data-index="2" autocomplete="off">
					<input type="text" inputmode="numeric" maxlength="1" class="rz-otp-input" data-index="3" autocomplete="off">
					<input type="text" inputmode="numeric" maxlength="1" class="rz-otp-input" data-index="4" autocomplete="off">
				</div>
				<label class="rz-login-remember">
					<input type="checkbox" id="rz-otp-remember" checked>
					<span><?php esc_html_e( 'مرا به خاطر بسپار', 'rozholy' ); ?></span>
				</label>
				<button class="rz-login-btn rz-btn-primary" id="rz-otp-verify" disabled><?php esc_html_e( 'ورود', 'rozholy' ); ?></button>
				<div class="rz-otp-timer" id="rz-otp-timer">
					<span id="rz-otp-countdown"></span>
					<button id="rz-otp-resend" style="display:none" class="rz-login-link-btn"><?php esc_html_e( 'ارسال مجدد کد', 'rozholy' ); ?></button>
				</div>
				<button class="rz-login-link-btn" id="rz-otp-back"><?php esc_html_e( 'تغییر شماره موبایل', 'rozholy' ); ?></button>
				<div class="rz-login-error" id="rz-otp-verify-error"></div>
			</div>
		</div>

		<div class="rz-login-panel" id="rz-login-password" style="display:none">
			<p class="rz-login-desc"><?php esc_html_e( 'با نام کاربری و رمز عبور وارد شوید.', 'rozholy' ); ?></p>
			<form id="rz-login-password-form" method="post">
				<div class="rz-login-field">
					<label for="rz-password-user"><?php esc_html_e( 'نام کاربری یا ایمیل', 'rozholy' ); ?></label>
					<input type="text" id="rz-password-user" name="log" autocomplete="username" class="rz-login-input" required>
				</div>
				<div class="rz-login-field">
					<label for="rz-password-pass"><?php esc_html_e( 'رمز عبور', 'rozholy' ); ?></label>
					<input type="password" id="rz-password-pass" name="pwd" autocomplete="current-password" class="rz-login-input" required>
				</div>
				<label class="rz-login-remember">
					<input type="checkbox" name="rememberme" value="forever" checked>
					<span><?php esc_html_e( 'مرا به خاطر بسپار', 'rozholy' ); ?></span>
				</label>
				<button type="submit" class="rz-login-btn rz-btn-primary"><?php esc_html_e( 'ورود', 'rozholy' ); ?></button>
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ?: home_url( '/my-account/' ) ); ?>">
				<?php wp_nonce_field( 'rozholy_password_login', '_wpnonce' ); ?>
			</form>
			<div class="rz-login-error" id="rz-password-error"></div>
			<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="rz-login-link-btn"><?php esc_html_e( 'رمز عبور را فراموش کرده‌اید؟', 'rozholy' ); ?></a>
		</div>
	</div>
</div>

<script>
(function() {
	var redirectTo = <?php echo $redirect_to ? wp_json_encode( $redirect_to ) : '""'; ?>;
	var countdownInterval;
	var countdownSeconds = 120;

	function normalizeDigits(str) {
		return str.replace(/[۰-۹]/g, function(d) { return String.fromCharCode(d.charCodeAt(0) - 1728); })
		          .replace(/[٠-٩]/g, function(d) { return String.fromCharCode(d.charCodeAt(0) - 1584); });
	}

	function showError(el, msg) {
		el.textContent = msg;
		el.style.display = msg ? 'block' : 'none';
	}

	function startCountdown(seconds) {
		countdownSeconds = seconds;
		var timerEl = document.getElementById('rz-otp-countdown');
		var resendEl = document.getElementById('rz-otp-resend');
		resendEl.style.display = 'none';
		if (countdownInterval) clearInterval(countdownInterval);
		countdownInterval = setInterval(function() {
			if (countdownSeconds <= 0) {
				clearInterval(countdownInterval);
				timerEl.textContent = '';
				resendEl.style.display = 'inline';
				return;
			}
			var m = Math.floor(countdownSeconds / 60);
			var s = countdownSeconds % 60;
			var persianDigits = {0:'۰',1:'۱',2:'۲',3:'۳',4:'۴',5:'۵',6:'۶',7:'۷',8:'۸',9:'۹'};
			var mp = String(m).replace(/\d/g, function(d) { return persianDigits[d]; });
			var sp = String(s).padStart(2,'0').replace(/\d/g, function(d) { return persianDigits[d]; });
			timerEl.textContent = '\u0627\u0631\u0633\u0627\u0644 \u0645\u062C\u062F\u062F \u062A\u0627 ' + mp + ':' + sp;
			countdownSeconds--;
		}, 1000);
	}

	function switchTab(tab) {
		document.querySelectorAll('.rz-login-tab').forEach(function(t) { t.classList.remove('is-active'); });
		document.querySelectorAll('.rz-login-panel').forEach(function(p) { p.style.display = 'none'; });
		document.querySelector('.rz-login-tab[data-tab="' + tab + '"]').classList.add('is-active');
		document.getElementById('rz-login-' + tab).style.display = 'block';
		showError(document.getElementById('rz-otp-error'), '');
		showError(document.getElementById('rz-otp-verify-error'), '');
		showError(document.getElementById('rz-password-error'), '');
	}

	document.querySelectorAll('.rz-login-tab').forEach(function(tab) {
		tab.addEventListener('click', function() {
			switchTab(this.dataset.tab);
		});
	});

	var phoneInput = document.getElementById('rz-otp-phone');
	var sendBtn = document.getElementById('rz-otp-send');
	phoneInput.addEventListener('input', function() {
		var val = normalizeDigits(this.value).replace(/\D/g, '');
		this.value = val;
		sendBtn.disabled = val.length !== 11 || !val.startsWith('09');
	});

	sendBtn.addEventListener('click', function() {
		var phone = normalizeDigits(phoneInput.value);
		var nonce = <?php echo wp_json_encode( wp_create_nonce( 'rozholy_otp_request' ) ); ?>;
		var errorEl = document.getElementById('rz-otp-error');
		sendBtn.disabled = true;
		sendBtn.textContent = '...';
		fetch('/wp-json/rozholy-companion/v1/otp/request', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': <?php echo wp_json_encode( wp_create_nonce( 'wp_rest' ) ); ?> },
			body: JSON.stringify({ phone: phone, _wpnonce: nonce })
		})
		.then(function(r) { return r.json(); })
		.then(function(data) {
			sendBtn.textContent = '<?php echo esc_js( __( 'ارسال کد تأیید', 'rozholy' ) ); ?>';
			sendBtn.disabled = false;
			if (data.code && data.data && data.data.status === 400) {
				showError(errorEl, data.message || '<?php echo esc_js( __( 'خطایی رخ داده است.', 'rozholy' ) ); ?>');
				return;
			}
			if (data.message && !data.success) {
				showError(errorEl, data.message);
				return;
			}
			showError(errorEl, '');
			document.getElementById('rz-otp-step-1').style.display = 'none';
			document.getElementById('rz-otp-step-2').style.display = 'block';
			startCountdown(120);
			document.querySelector('.rz-otp-input').focus();
		})
		.catch(function() {
			sendBtn.textContent = '<?php echo esc_js( __( 'ارسال کد تأیید', 'rozholy' ) ); ?>';
			sendBtn.disabled = false;
			showError(errorEl, '<?php echo esc_js( __( 'خطا در ارتباط با سرور.', 'rozholy' ) ); ?>');
		});
	});

	var otpInputs = document.querySelectorAll('.rz-otp-input');
	otpInputs.forEach(function(input, idx) {
		input.addEventListener('input', function() {
			var val = normalizeDigits(this.value).replace(/\D/g, '');
			this.value = val;
			if (val && idx < otpInputs.length - 1) {
				otpInputs[idx + 1].focus();
			}
			var allFilled = true;
			otpInputs.forEach(function(inp) { if (!inp.value) allFilled = false; });
			document.getElementById('rz-otp-verify').disabled = !allFilled;
		});
		input.addEventListener('keydown', function(e) {
			if (e.key === 'Backspace' && !this.value && idx > 0) {
				otpInputs[idx - 1].focus();
			}
		});
		input.addEventListener('paste', function(e) {
			e.preventDefault();
			var paste = (e.clipboardData || window.clipboardData).getData('text');
			var digits = normalizeDigits(paste).replace(/\D/g, '').split('');
			digits.forEach(function(d, i) {
				if (i < otpInputs.length) {
					otpInputs[i].value = d;
				}
			});
			var focusIdx = Math.min(digits.length, otpInputs.length - 1);
			otpInputs[focusIdx].focus();
			var allFilled = true;
			otpInputs.forEach(function(inp) { if (!inp.value) allFilled = false; });
			document.getElementById('rz-otp-verify').disabled = !allFilled;
		});
	});

	document.getElementById('rz-otp-verify').addEventListener('click', function() {
		var phone = normalizeDigits(phoneInput.value);
		var code = '';
		otpInputs.forEach(function(inp) { code += inp.value; });
		var remember = document.getElementById('rz-otp-remember').checked ? 'on' : '';
		var nonce = <?php echo wp_json_encode( wp_create_nonce( 'rozholy_otp_verify' ) ); ?>;
		var errorEl = document.getElementById('rz-otp-verify-error');
		var btn = this;
		btn.disabled = true;
		btn.textContent = '...';
		var body = { phone: phone, code: code, _wpnonce: nonce, remember: remember };
		if (redirectTo) body.redirect_to = redirectTo;
		fetch('/wp-json/rozholy-companion/v1/otp/verify', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': <?php echo wp_json_encode( wp_create_nonce( 'wp_rest' ) ); ?> },
			body: JSON.stringify(body)
		})
		.then(function(r) { return r.json(); })
		.then(function(data) {
			btn.textContent = '<?php echo esc_js( __( 'ورود', 'rozholy' ) ); ?>';
			btn.disabled = false;
			if (data.code && data.data && data.data.status !== 200) {
				showError(errorEl, data.message || '<?php echo esc_js( __( 'خطایی رخ داده است.', 'rozholy' ) ); ?>');
				return;
			}
			if (!data.success) {
				showError(errorEl, data.message || '<?php echo esc_js( __( 'کد وارد شده اشتباه است.', 'rozholy' ) ); ?>');
				otpInputs.forEach(function(inp) { inp.value = ''; });
				otpInputs[0].focus();
				document.getElementById('rz-otp-verify').disabled = true;
				return;
			}
			window.location.href = data.redirect || '<?php echo esc_url( home_url( '/my-account/' ) ); ?>';
		})
		.catch(function() {
			btn.textContent = '<?php echo esc_js( __( 'ورود', 'rozholy' ) ); ?>';
			btn.disabled = false;
			showError(errorEl, '<?php echo esc_js( __( 'خطا در ارتباط با سرور.', 'rozholy' ) ); ?>');
		});
	});

	document.getElementById('rz-otp-resend').addEventListener('click', function() {
		sendBtn.click();
	});

	document.getElementById('rz-otp-back').addEventListener('click', function() {
		document.getElementById('rz-otp-step-2').style.display = 'none';
		document.getElementById('rz-otp-step-1').style.display = 'block';
		if (countdownInterval) clearInterval(countdownInterval);
	});

	document.getElementById('rz-login-password-form').addEventListener('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		var errorEl = document.getElementById('rz-password-error');
		var btn = this.querySelector('button[type="submit"]');
		btn.disabled = true;
		btn.textContent = '...';
		fetch('<?php echo esc_url( home_url( '/wp-login.php' ) ); ?>', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: new URLSearchParams(formData).toString()
		})
		.then(function(r) {
			if (r.url && r.url.indexOf('wp-admin') !== -1) {
				window.location.href = formData.get('redirect_to') || '<?php echo esc_url( home_url( '/my-account/' ) ); ?>';
				return;
			}
			return r.text();
		})
		.then(function(html) {
			btn.textContent = '<?php echo esc_js( __( 'ورود', 'rozholy' ) ); ?>';
			btn.disabled = false;
			if (!html) return;
			showError(errorEl, '<?php echo esc_js( __( 'اطلاعات وارد شده صحیح نیست.', 'rozholy' ) ); ?>');
		})
		.catch(function() {
			btn.textContent = '<?php echo esc_js( __( 'ورود', 'rozholy' ) ); ?>';
			btn.disabled = false;
			showError(errorEl, '<?php echo esc_js( __( 'خطا در ارتباط با سرور.', 'rozholy' ) ); ?>');
		});
	});
})();
</script>

<style>
.rz-login-wrap { display:flex; justify-content:center; align-items:center; min-height:80vh; padding:40px 20px; background:var(--rz-base-bg,#faf5f0); }
.rz-login-card { background:#fff; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.08); width:100%; max-width:420px; padding:40px 32px; }
.rz-login-header { text-align:center; margin-bottom:28px; }
.rz-login-logo-img { max-width:120px; height:auto; }
.rz-login-logo-text { font-size:1.4rem; font-weight:700; color:var(--rz-dark-color,#2d2d2d); }
.rz-login-tabs { display:flex; gap:0; margin-bottom:24px; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; }
.rz-login-tab { flex:1; padding:12px; border:none; background:#fff; font-size:0.85rem; font-weight:500; color:#6b7280; cursor:pointer; transition:all 0.2s; }
.rz-login-tab:not(:last-child) { border-left:1px solid #e5e7eb; }
.rz-login-tab.is-active { background:var(--rz-primary-color,#d4a0a0); color:#fff; font-weight:600; }
.rz-login-desc { font-size:0.9rem; color:#6b7280; margin:0 0 20px; line-height:1.6; text-align:center; }
.rz-login-field { margin-bottom:16px; }
.rz-login-field label { display:block; font-size:0.85rem; font-weight:500; color:#374151; margin-bottom:6px; }
.rz-login-input { width:100%; padding:12px 14px; border:1px solid #d1d5db; border-radius:10px; font-size:0.95rem; color:#1f2937; background:#fff; transition:border-color 0.2s; box-sizing:border-box; }
.rz-login-input:focus { outline:none; border-color:var(--rz-primary-color,#d4a0a0); box-shadow:0 0 0 3px rgba(212,160,160,0.15); }
.ltr-input { direction:ltr; text-align:right; unicode-bidi:plaintext; }
.rz-login-btn { width:100%; padding:12px; border:none; border-radius:999px; font-size:0.95rem; font-weight:600; cursor:pointer; transition:all 0.2s; margin-top:8px; }
.rz-btn-primary { background:var(--rz-primary-color,#d4a0a0); color:#fff; }
.rz-btn-primary:hover:not(:disabled) { background:var(--rz-primary-dark,#c08080); }
.rz-btn-primary:disabled { opacity:0.5; cursor:default; }
.rz-login-remember { display:flex; align-items:center; gap:8px; margin:16px 0; font-size:0.85rem; color:#4b5563; cursor:pointer; }
.rz-login-remember input { width:18px; height:18px; accent-color:var(--rz-primary-color,#d4a0a0); }
.rz-login-error { display:none; margin-top:12px; padding:10px 14px; border-radius:10px; background:#fef2f2; color:#991b1b; font-size:0.85rem; text-align:center; }
.rz-login-notice { padding:10px 14px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; text-align:center; }
.rz-login-notice--success { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
.rz-otp-code-wrap { display:flex; gap:10px; justify-content:center; direction:ltr; margin:24px 0; }
.rz-otp-input { width:52px; height:56px; text-align:center; font-size:1.5rem; font-weight:700; border:2px solid #d1d5db; border-radius:12px; outline:none; transition:border-color 0.2s; color:#1f2937; }
.rz-otp-input:focus { border-color:var(--rz-primary-color,#d4a0a0); box-shadow:0 0 0 3px rgba(212,160,160,0.15); }
.rz-otp-timer { text-align:center; margin-top:16px; font-size:0.85rem; color:#6b7280; min-height:24px; }
.rz-login-link-btn { display:inline-block; background:none; border:none; color:var(--rz-primary-color,#d4a0a0); font-size:0.85rem; cursor:pointer; text-decoration:underline; margin-top:12px; padding:0; }
.rz-login-link-btn:hover { color:var(--rz-primary-dark,#c08080); }
</style>

<?php get_footer(); ?>
