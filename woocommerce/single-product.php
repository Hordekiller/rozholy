<?php get_header('shop'); ?>

<?php do_action('woocommerce_before_main_content'); ?>

<?php while (have_posts()) : the_post(); ?>
  <?php wc_get_template_part('content', 'single-product'); ?>
<?php endwhile; ?>

<?php do_action('woocommerce_after_main_content'); ?>

<?php get_footer('shop'); ?>
