<?php get_header(); ?>

<div class="page-hero page-hero--archive">
  <div class="container">
    <h1 class="page-hero-title">
      <?php
      if (is_category()) {
        single_cat_title();
      } elseif (is_tag()) {
        printf(esc_html__('برچسب: %s', 'rozholy'), single_tag_title('', false));
      } elseif (is_author()) {
        printf(esc_html__('نویسنده: %s', 'rozholy'), get_the_author());
      } elseif (is_day()) {
        printf(esc_html__('آرشیو روزانه: %s', 'rozholy'), get_the_date('j F Y'));
      } elseif (is_month()) {
        printf(esc_html__('آرشیو ماهانه: %s', 'rozholy'), get_the_date('F Y'));
      } elseif (is_year()) {
        printf(esc_html__('آرشیو سالانه: %s', 'rozholy'), get_the_date('Y'));
      } else {
        esc_html_e('آرشیو', 'rozholy');
      }
      ?>
    </h1>
    <?php
    if (is_category() || is_tag()) {
        the_archive_description('<div class="page-hero-desc">', '</div>');
    }
    ?>
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
          <?php
          the_posts_pagination([
              'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>',
              'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>',
              'mid_size'  => 2,
          ]);
          ?>
        </div>
      <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
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
