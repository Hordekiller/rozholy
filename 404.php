<?php get_header(); ?>

<div class="error-404-section">
  <div class="container">
    <div class="error-404-content">
      <div class="error-404-visual">
        <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="100" cy="100" r="90" stroke="var(--rz-primary)" stroke-width="4" stroke-dasharray="8 8" fill="none"/>
          <circle cx="100" cy="100" r="60" stroke="var(--rz-secondary)" stroke-width="2" fill="none"/>
          <text x="100" y="115" text-anchor="middle" font-family="var(--rz-font-display)" font-size="60" font-weight="700" fill="var(--rz-primary)">404</text>
        </svg>
      </div>
      <h1 class="error-404-title"><?php esc_html_e('صفحه‌ای که دنبالش بودید پیدا نشد!', 'rozholy'); ?></h1>
      <p class="error-404-desc"><?php esc_html_e('به نظر می‌رسد صفحه مورد نظر شما وجود ندارد یا حذف شده است. لطفاً از منوی بالا استفاده کنید یا به صفحه اصلی برگردید.', 'rozholy'); ?></p>
      <div class="error-404-actions">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          <?php esc_html_e('برو به صفحه اصلی', 'rozholy'); ?>
        </a>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary">
          <?php esc_html_e('تماس با ما', 'rozholy'); ?>
        </a>
      </div>
      <div class="error-404-search">
        <p><?php esc_html_e('یا جستجو کنید:', 'rozholy'); ?></p>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
          <input type="search" placeholder="<?php esc_attr_e('عبارت مورد نظر را وارد کنید...', 'rozholy'); ?>" name="s" />
          <button type="submit"><?php esc_html_e('جستجو', 'rozholy'); ?></button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
