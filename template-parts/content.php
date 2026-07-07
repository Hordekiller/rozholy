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
