<?php
defined('ABSPATH') || exit;

$user = wp_get_current_user();
$recent_comments = get_comments([
    'user_id' => $user->ID,
    'number'  => 5,
    'status'  => 'approve',
]);
$recent_posts = get_posts([
    'author'      => $user->ID,
    'numberposts' => 5,
    'post_status' => 'publish',
]);
?>

<div class="dashboard-tabs">
    <div class="dashboard-tabs__nav">
        <button class="dashboard-tabs__btn active" data-tab="comments">
            <?php echo esc_html__('نظرات', 'rozholy'); ?>
        </button>
        <button class="dashboard-tabs__btn" data-tab="posts">
            <?php echo esc_html__('مطالب', 'rozholy'); ?>
        </button>
    </div>

    <div class="dashboard-tabs__content">
        <div class="dashboard-tabs__panel active" id="tab-comments">
            <?php if (empty($recent_comments)) : ?>
                <?php rozholy_empty_state('comments'); ?>
            <?php else : ?>
                <?php foreach ($recent_comments as $comment) : ?>
                    <div class="dashboard-card activity-item">
                        <div class="activity-item__header">
                            <span class="activity-item__type"><?php echo esc_html__('نظر', 'rozholy'); ?></span>
                            <span class="activity-item__date"><?php echo esc_html(get_comment_date('', $comment)); ?></span>
                        </div>
                        <p class="activity-item__excerpt"><?php echo esc_html(wp_trim_words($comment->comment_content, 20)); ?></p>
                        <a href="<?php echo esc_url(get_comment_link($comment)); ?>" class="activity-item__link">
                            <?php echo esc_html__('مشاهده', 'rozholy'); ?>
                        </a>
                    </div>
                <?php endforeach; ?>
                <button class="dashboard-btn dashboard-btn--outline dashboard-load-more" data-type="comments" data-page="1">
                    <?php echo esc_html__('بیشتر', 'rozholy'); ?>
                </button>
            <?php endif; ?>
        </div>

        <div class="dashboard-tabs__panel" id="tab-posts">
            <?php if (empty($recent_posts)) : ?>
                <?php rozholy_empty_state('posts'); ?>
            <?php else : ?>
                <?php foreach ($recent_posts as $post) : setup_postdata($post); ?>
                    <div class="dashboard-card activity-item">
                        <div class="activity-item__header">
                            <span class="activity-item__type"><?php echo esc_html__('مطلب', 'rozholy'); ?></span>
                            <span class="activity-item__date"><?php echo esc_html(get_the_date('', $post)); ?></span>
                        </div>
                        <h4 class="activity-item__title"><?php echo esc_html(get_the_title($post)); ?></h4>
                        <a href="<?php echo esc_url(get_permalink($post)); ?>" class="activity-item__link">
                            <?php echo esc_html__('مشاهده', 'rozholy'); ?>
                        </a>
                    </div>
                <?php endforeach; wp_reset_postdata(); ?>
                <button class="dashboard-btn dashboard-btn--outline dashboard-load-more" data-type="posts" data-page="1">
                    <?php echo esc_html__('بیشتر', 'rozholy'); ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
