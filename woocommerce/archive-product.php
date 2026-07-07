<?php get_header('shop'); ?>

<div class="woocommerce-page-header">
  <div class="container">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
      <h1 class="woocommerce-page-title"><?php woocommerce_page_title(); ?></h1>
    <?php endif; ?>
    <?php do_action('woocommerce_archive_description'); ?>
  </div>
</div>

<?php do_action('woocommerce_before_main_content'); ?>

<?php if (woocommerce_product_loop()) : ?>
  <?php do_action('woocommerce_before_shop_loop'); ?>
  <?php woocommerce_product_loop_start(); ?>
    <?php if (wc_get_loop_prop('total')) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <?php do_action('woocommerce_shop_loop'); ?>
        <?php wc_get_template_part('content', 'product'); ?>
      <?php endwhile; ?>
    <?php endif; ?>
  <?php woocommerce_product_loop_end(); ?>
  <?php do_action('woocommerce_after_shop_loop'); ?>
<?php else : ?>
  <?php do_action('woocommerce_no_products_found'); ?>
<?php endif; ?>

<?php do_action('woocommerce_after_main_content'); ?>

<?php get_footer('shop'); ?>
