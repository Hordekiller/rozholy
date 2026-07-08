<footer class="rz-site-footer" id="rz-site-footer">
	<div class="rz-footer-inner">
		<?php $footer_layout = (int) rozholy_get_option( 'footer_layout', 4 );
		if ( is_active_sidebar( 'footer-' . $footer_layout ) ) {
			dynamic_sidebar( 'footer-' . $footer_layout );
		} else {
			$cols = array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 );
			$col_count = $cols[ $footer_layout ] ?? 4;
			echo '<div class="rz-footer-grid rz-footer-grid--' . esc_attr( $col_count ) . '">';
			for ( $i = 1; $i <= $col_count; $i++ ) {
				echo '<div class="rz-footer-col">';
				if ( 1 === $i ) {
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					if ( $custom_logo_id ) {
						echo '<div class="rz-footer-logo">' . wp_get_attachment_image( $custom_logo_id, 'full', false, array( 'class' => 'rz-footer-logo-img', 'loading' => 'lazy' ) ) . '</div>';
					}
					echo '<p class="rz-footer-about">محصولات آرایشی و بهداشتی با بهترین کیفیت. آماده‌ایم تا زیبایی شما را دوچندان کنیم.</p>';
					$socials = array( 'instagram', 'telegram', 'whatsapp', 'youtube' );
					echo '<div class="rz-footer-socials">';
					foreach ( $socials as $s ) {
						$url = rozholy_get_option( 'social_' . $s, '' );
						if ( $url ) {
							$icon = 'instagram' === $s ? 'instagram' : ( 'telegram' === $s ? 'send' : ( 'whatsapp' === $s ? 'phone' : 'youtube' ) );
							echo '<a href="' . esc_url( $url ) . '" class="rz-footer-social-link" target="_blank" rel="noopener" aria-label="' . esc_attr( $s ) . '"><svg viewBox="0 0 24 24" width="20" height="20"><circle cx="12" cy="12" r="10" fill="currentColor"/></svg></a>';
						}
					}
					echo '</div>';
				} elseif ( 2 === $i ) {
					echo '<h4 class="rz-footer-heading">لینک‌های سریع</h4>';
					wp_nav_menu( array( 'theme_location' => 'footer', 'container' => '', 'menu_class' => 'rz-footer-links', 'fallback_cb' => '__return_false', 'depth' => 1 ) );
				} elseif ( 3 === $i ) {
					echo '<h4 class="rz-footer-heading">خدمات ما</h4>';
					echo '<ul class="rz-footer-links"><li>کوتاهی و رنگ مو</li><li>مراقبت از پوست</li><li>ناخن و کاشت</li><li>میکاپ حرفه‌ای</li><li>اسپا و ماساژ</li></ul>';
				} else {
					echo '<h4 class="rz-footer-heading">اطلاعات تماس</h4>';
					echo '<ul class="rz-footer-links"><li>۰۲۱-۱۲۳۴۵۶۷۸</li><li>۰۹۱۲۳۴۵۶۷۸۹</li><li>info@rozholy.ir</li><li>تهران، خیابان ولیعصر</li><li>شنبه - پنجشنبه ۹ صبح تا ۹ شب</li></ul>';
				}
				echo '</div>';
			}
			echo '</div>';
		} ?>
	</div>
	<div class="rz-footer-bottom">
		<p class="rz-footer-copy"><?php echo wp_kses_post( rozholy_get_option( 'footer_text', '© 2026 Rozholy. تمامی حقوق محفوظ است.' ) ); ?></p>
	</div>
</footer>
