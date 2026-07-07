<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
  <?php if (class_exists('Elementor\Plugin') && Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) : ?>
    <div class="elementor-content-wrapper">
      <?php the_content(); ?>
    </div>
  <?php else : ?>
    <div class="container">
      <div class="content-area content-area--page">
        <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
          <?php if (has_post_thumbnail()) : ?>
            <div class="page-thumbnail">
              <?php the_post_thumbnail('full'); ?>
            </div>
          <?php endif; ?>
          <h1 class="page-title"><?php the_title(); ?></h1>
          <div class="page-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages([
                'before' => '<div class="page-links">' . esc_html__('صفحات:', 'rozholy'),
                'after'  => '</div>',
            ]);
            ?>
          </div>
          <?php if (comments_open() || get_comments_number()) : ?>
            <div class="page-comments">
              <?php comments_template(); ?>
            </div>
          <?php endif; ?>
        </article>
      </div>
    </div>
  <?php endif; ?>
<?php endwhile; ?>

<?php get_footer(); ?>
