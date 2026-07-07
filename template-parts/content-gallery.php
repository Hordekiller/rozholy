<article id="post-<?php the_ID(); ?>" <?php post_class('blog-card blog-card--gallery'); ?>>
  <div class="blog-card-thumb blog-card-thumb--gallery">
    <?php
    $gallery = get_post_gallery(get_the_ID(), false);
    if ($gallery && isset($gallery['src'])) :
      $first_img = $gallery['src'][0];
    ?>
      <img src="<?php echo esc_url($first_img); ?>" class="blog-card-img" alt="<?php the_title_attribute(); ?>" />
    <?php elseif (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('rozholy-featured', ['class' => 'blog-card-img']); ?>
    <?php endif; ?>
    <span class="gallery-badge">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    </span>
  </div>
  <div class="blog-card-body">
    <div class="blog-card-meta">
      <span class="blog-card-date"><?php echo get_the_date(); ?></span>
    </div>
    <h3 class="blog-card-title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
  </div>
</article>
