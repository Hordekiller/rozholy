<?php get_header(); ?>

<div class="page-hero page-hero--search">
  <div class="container">
    <h1 class="page-hero-title">
      <?php
      printf(
        esc_html__('نتیجه جستجو برای: %s', 'rozholy'),
        '<span class="search-query">' . get_search_query() . '</span>'
      );
      ?>
    </h1>
    <?php
    global $wp_query;
    if ($wp_query->found_posts) :
    ?>
      <p class="page-hero-desc">
        <?php printf(esc_html__('%d نتیجه یافت شد', 'rozholy'), $wp_query->found_posts); ?>
      </p>
    <?php endif; ?>
  </div>
</div>

<div class="container">
  <div class="content-layout">
    <div class="content-area">
      <?php if (have_posts()) : ?>
        <div class="blog-grid">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/content', get_post_format()); ?>
          <?php endwhile; ?>
        </div>
        <div class="pagination">
          <?php the_posts_pagination([
              'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>',
              'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>',
          ]); ?>
        </div>
      <?php else : ?>
        <div class="search-no-results">
          <div class="error-404-visual" style="margin-bottom: 20px;">
            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="var(--rz-text-light)" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </div>
          <h3><?php esc_html_e('نتیجه‌ای یافت نشد', 'rozholy'); ?></h3>
          <p><?php esc_html_e('متأسفیم! هیچ مطلبی با عبارت جستجوی شما یافت نشد. لطفاً با کلمات دیگر جستجو کنید.', 'rozholy'); ?></p>
          <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" placeholder="<?php esc_attr_e('جستجو کنید...', 'rozholy'); ?>" name="s" />
            <button type="submit"><?php esc_html_e('جستجو', 'rozholy'); ?></button>
          </form>
        </div>
      <?php endif; ?>
    </div>
    <?php if (is_active_sidebar('sidebar-1')) : ?>
      <aside class="sidebar">
        <?php dynamic_sidebar('sidebar-1'); ?>
      </aside>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
