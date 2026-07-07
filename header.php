<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if (function_exists('wp_body_open')) {
    wp_body_open();
}
?>

<div id="page" class="site">

<div id="topbar" class="topbar">
  <div class="container">
    <div class="topbar-inner">
      <div class="topbar-info">
        <?php if ($phone = get_theme_mod('rozholy_contact_phone')) : ?>
          <span class="topbar-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <?php echo esc_html($phone); ?>
          </span>
        <?php endif; ?>
        <?php if ($worktime = get_theme_mod('rozholy_contact_worktime')) : ?>
          <span class="topbar-item topbar-worktime">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <?php echo esc_html($worktime); ?>
          </span>
        <?php endif; ?>
      </div>
      <div class="topbar-social">
        <?php
        $socials = ['instagram', 'telegram', 'whatsapp', 'youtube', 'linkedin', 'facebook'];
        foreach ($socials as $social) :
          $url = get_theme_mod('rozholy_social_' . $social);
          if ($url) : ?>
            <a href="<?php echo esc_url($url); ?>" class="social-icon social-<?php echo esc_attr($social); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social); ?>">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            </a>
          <?php endif;
        endforeach; ?>
      </div>
    </div>
  </div>
</div>

<header id="masthead" class="site-header">
  <div class="container">
    <div class="header-inner">
      <div class="site-branding">
        <?php if (has_custom_logo()) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-title">
            <span class="site-title-text"><?php bloginfo('name'); ?></span>
          </a>
          <?php if ($description = get_bloginfo('description', 'display')) : ?>
            <p class="site-description"><?php echo esc_html($description); ?></p>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('منوی اصلی', 'rozholy'); ?>">
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
          <span class="menu-toggle-icon">
            <span></span><span></span><span></span>
          </span>
          <span class="screen-reader-text"><?php esc_html_e('منو', 'rozholy'); ?></span>
        </button>
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'menu_class'     => 'primary-menu',
            'container'      => false,
            'fallback_cb'    => false,
            'depth'          => 3,
        ]);
        ?>
      </nav>

      <div class="header-actions">
        <?php if (class_exists('WooCommerce')) : ?>
          <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="header-cart" aria-label="<?php esc_attr_e('سبد خرید', 'rozholy'); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span class="header-cart-count" id="header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
          </a>
        <?php endif; ?>
        <button class="header-search-toggle" aria-label="<?php esc_attr_e('جستجو', 'rozholy'); ?>">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
      </div>
    </div>
  </div>

  <div class="header-search-form">
    <div class="container">
      <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" class="search-field" placeholder="<?php esc_attr_e('جستجو کنید...', 'rozholy'); ?>" value="<?php echo get_search_query(); ?>" name="s" autofocus />
        <button type="submit" class="search-submit">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
        <button type="button" class="search-close" aria-label="<?php esc_attr_e('بستن', 'rozholy'); ?>">&times;</button>
      </form>
    </div>
  </div>
</header>

<main id="primary" class="site-main">
