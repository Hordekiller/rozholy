<?php get_header(); ?>

<div class="container">
  <div class="content-area">
    <?php if (have_posts()) : ?>
      <div class="blog-grid">
        <?php while (have_posts()) : the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="blog-card-thumb">
                <?php the_post_thumbnail('rozholy-featured', ['class' => 'blog-card-img']); ?>
              </a>
            <?php endif; ?>
            <div class="blog-card-body">
              <div class="blog-card-meta">
                <span class="blog-card-date"><?php echo get_the_date(); ?></span>
                <span class="blog-card-category"><?php the_category('، '); ?></span>
              </div>
              <h3 class="blog-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h3>
              <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn btn-secondary blog-card-link">
                <?php esc_html_e('ادامه مطلب', 'rozholy'); ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
          </article>
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
</div>

<?php get_footer(); ?>
