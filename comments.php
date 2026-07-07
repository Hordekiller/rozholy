<?php
if (post_password_required()) return;
?>

<div id="comments" class="comments-area">
  <?php if (have_comments()) : ?>
    <h3 class="comments-title">
      <?php
      $comment_count = get_comments_number();
      printf(
        esc_html(_n('%d دیدگاه', '%d دیدگاه', $comment_count, 'rozholy')),
        number_format_i18n($comment_count)
      );
      ?>
    </h3>

    <ol class="comment-list">
      <?php
      wp_list_comments([
          'style'       => 'ol',
          'short_ping'  => true,
          'avatar_size' => 60,
          'callback'    => 'rozholy_comment_callback',
      ]);
      ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav class="comment-navigation">
        <div class="nav-previous"><?php previous_comments_link(esc_html__('دیدگاه‌های قدیمی‌تر', 'rozholy')); ?></div>
        <div class="nav-next"><?php next_comments_link(esc_html__('دیدگاه‌های جدیدتر', 'rozholy')); ?></div>
      </nav>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="no-comments"><?php esc_html_e('دیدگاه‌ها بسته شده‌اند.', 'rozholy'); ?></p>
  <?php endif; ?>

  <?php
  comment_form([
      'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
      'title_reply_after'  => '</h3>',
      'class_submit'       => 'btn btn-primary submit',
      'label_submit'       => esc_html__('ارسال دیدگاه', 'rozholy'),
      'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . esc_html__('دیدگاه', 'rozholy') . '</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
      'fields'             => [
          'author' => '<p class="comment-form-author"><label for="author">' . esc_html__('نام', 'rozholy') . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" required /></p>',
          'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__('ایمیل', 'rozholy') . ' <span class="required">*</span></label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" required /></p>',
          'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__('وبسایت', 'rozholy') . '</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" /></p>',
      ],
  ]);
  ?>
</div>

<?php
function rozholy_comment_callback($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
?>
  <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
    <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
      <div class="comment-author vcard">
        <?php if ($args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
        <cite class="fn"><?php comment_author_link(); ?></cite>
      </div>
      <div class="comment-meta">
        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
          <time datetime="<?php comment_time('c'); ?>">
            <?php printf(esc_html__('%s در %s', 'rozholy'), get_comment_date(), get_comment_time()); ?>
          </time>
        </a>
        <?php edit_comment_link(esc_html__('ویرایش', 'rozholy'), '<span class="edit-link">', '</span>'); ?>
      </div>
      <?php if ('0' === $comment->comment_approved) : ?>
        <p class="comment-awaiting-moderation"><?php esc_html_e('دیدگاه شما در انتظار تایید است.', 'rozholy'); ?></p>
      <?php endif; ?>
      <div class="comment-text"><?php comment_text(); ?></div>
      <div class="reply">
        <?php
        comment_reply_link(array_merge($args, [
            'add_below' => 'div-comment',
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'reply_text' => esc_html__('پاسخ', 'rozholy'),
        ]));
        ?>
      </div>
    </div>
<?php
}
