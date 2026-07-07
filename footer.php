</main>

<footer id="colophon" class="site-footer">
  <div class="footer-wave">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
    </svg>
  </div>

  <div class="footer-main">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col footer-brand">
          <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
          <?php else : ?>
            <h3 class="footer-site-title"><?php bloginfo('name'); ?></h3>
          <?php endif; ?>
          <p class="footer-description">
            <?php echo esc_html(get_theme_mod('rozholy_contact_address', get_bloginfo('description'))); ?>
          </p>
          <div class="footer-social">
            <?php
            $socials = ['instagram', 'telegram', 'whatsapp', 'youtube', 'linkedin', 'facebook'];
            foreach ($socials as $social) :
                $url = get_theme_mod('rozholy_social_' . $social);
                if ($url) : ?>
                  <a href="<?php echo esc_url($url); ?>" class="social-icon social-<?php echo esc_attr($social); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                  </a>
                <?php endif;
            endforeach; ?>
          </div>
        </div>
        <?php for ($i = 1; $i <= 3; $i++) : ?>
          <div class="footer-col">
            <?php if (is_active_sidebar('footer-' . $i)) : ?>
              <?php dynamic_sidebar('footer-' . $i); ?>
            <?php else : ?>
              <h4 class="footer-widget-title"><?php
                $titles = [
                  1 => esc_html__('لینک‌های سریع', 'rozholy'),
                  2 => esc_html__('خدمات ما', 'rozholy'),
                  3 => esc_html__('ساعات کاری', 'rozholy'),
                ];
                echo esc_html($titles[$i]);
              ?></h4>
              <?php if ($i === 1) : ?>
                <ul class="footer-links">
                  <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی', 'rozholy'); ?></a></li>
                  <li><a href="<?php echo esc_url(home_url('/services')); ?>"><?php esc_html_e('خدمات', 'rozholy'); ?></a></li>
                  <li><a href="<?php echo esc_url(home_url('/gallery')); ?>"><?php esc_html_e('گالری', 'rozholy'); ?></a></li>
                  <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('وبلاگ', 'rozholy'); ?></a></li>
                  <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('تماس با ما', 'rozholy'); ?></a></li>
                </ul>
              <?php elseif ($i === 2) : ?>
                <ul class="footer-links">
                  <li><a href="#"><?php esc_html_e('کوتاهی و رنگ مو', 'rozholy'); ?></a></li>
                  <li><a href="#"><?php esc_html_e('مراقبت از پوست', 'rozholy'); ?></a></li>
                  <li><a href="#"><?php esc_html_e('ناخن و کاشت', 'rozholy'); ?></a></li>
                  <li><a href="#"><?php esc_html_e('میکاپ حرفه‌ای', 'rozholy'); ?></a></li>
                  <li><a href="#"><?php esc_html_e('اسپا و ماساژ', 'rozholy'); ?></a></li>
                </ul>
              <?php else : ?>
                <ul class="footer-contact-list">
                  <?php if ($worktime = get_theme_mod('rozholy_contact_worktime')) : ?>
                    <li>
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                      <span><?php echo esc_html($worktime); ?></span>
                    </li>
                  <?php endif; ?>
                  <?php if ($phone = get_theme_mod('rozholy_contact_phone')) : ?>
                    <li>
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                      <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
                    </li>
                  <?php endif; ?>
                  <?php if ($email = get_theme_mod('rozholy_contact_email')) : ?>
                    <li>
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                      <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    </li>
                  <?php endif; ?>
                  <?php if ($address = get_theme_mod('rozholy_contact_address')) : ?>
                    <li>
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                      <span><?php echo esc_html($address); ?></span>
                    </li>
                  <?php endif; ?>
                </ul>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <div class="footer-bottom-inner">
        <p class="copyright">
          <?php
          printf(
            esc_html__('© %s %s - تمامی حقوق محفوظ است.', 'rozholy'),
            date('Y'),
            get_bloginfo('name')
          );
          ?>
        </p>
        <p class="footer-credit">
          <?php esc_html_e('طراحی شده با ❤ توسط ThemeFire', 'rozholy'); ?>
        </p>
      </div>
    </div>
  </div>
</footer>

<?php if (get_theme_mod('rozholy_contact_mobile')) : ?>
  <div class="sticky-cta">
    <a href="tel:<?php echo esc_attr(get_theme_mod('rozholy_contact_mobile')); ?>" class="sticky-cta-btn">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      <?php esc_html_e('تماس سریع', 'rozholy'); ?>
    </a>
  </div>
<?php endif; ?>

</div>

<?php wp_footer(); ?>
</body>
</html>
