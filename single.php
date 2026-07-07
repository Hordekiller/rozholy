<?php get_header(); ?>

<div class="container">
  <div class="content-area content-area--single">
    <?php while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>
        <?php if (has_post_thumbnail()) : ?>
          <div class="single-thumbnail">
            <?php the_post_thumbnail('full'); ?>
            <div class="single-thumbnail-overlay">
              <h1 class="single-title"><?php the_title(); ?></h1>
              <div class="single-meta">
                <span class="single-meta-item single-date">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                  <?php echo get_the_date('j F Y'); ?>
                </span>
                <span class="single-meta-item single-author">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  <?php the_author(); ?>
                </span>
                <span class="single-meta-item single-cats">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                  <?php the_category('، '); ?>
                </span>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="single-content">
          <?php the_content(); ?>
        </div>

        <?php
        wp_link_pages([
            'before' => '<div class="page-links">' . esc_html__('صفحات:', 'rozholy'),
            'after'  => '</div>',
        ]);
        ?>

        <div class="single-footer-meta">
          <div class="single-tags">
            <?php if (has_tag()) : ?>
              <span class="tags-label"><?php esc_html_e('برچسب‌ها:', 'rozholy'); ?></span>
              <?php the_tags('', ' ', ''); ?>
            <?php endif; ?>
          </div>
          <div class="single-share">
            <span class="share-label"><?php esc_html_e('اشتراک‌گذاری:', 'rozholy'); ?></span>
            <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="share-btn share-telegram" aria-label="Telegram">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
            </a>
            <a href="https://wa.me/?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="share-btn share-whatsapp" aria-label="WhatsApp">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
          </div>
        </div>

        <nav class="single-post-nav">
          <div class="post-nav-item post-nav-prev">
            <?php previous_post_link('%link', '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg> %title'); ?>
          </div>
          <div class="post-nav-item post-nav-next">
            <?php next_post_link('%link', '%title <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>'); ?>
          </div>
        </nav>

        <?php if (comments_open() || get_comments_number()) : ?>
          <div class="single-comments">
            <?php comments_template(); ?>
          </div>
        <?php endif; ?>
      </article>
    <?php endwhile; ?>
  </div>
</div>

<?php get_footer(); ?>
