<?php
defined('ABSPATH') || exit;

$user = wp_get_current_user();
?>

<div class="dashboard-card">
    <div class="dashboard-card__header">
        <h2><?php echo esc_html__('ویرایش پروفایل', 'rozholy'); ?></h2>
    </div>

    <div class="dashboard-card__body">
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data" class="dashboard-form">
            <?php wp_nonce_field('rozholy_update_profile'); ?>
            <input type="hidden" name="action" value="rozholy_update_profile">

            <div class="dashboard-form__avatar">
                <?php echo rozholy_get_avatar($user->ID, 96); ?>
                <label class="dashboard-form__avatar-btn">
                    <span><?php echo esc_html__('تغییر تصویر', 'rozholy'); ?></span>
                    <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp">
                </label>
                <p class="dashboard-form__hint"><?php echo esc_html__('JPEG, PNG, GIF, WebP', 'rozholy'); ?></p>
            </div>

            <div class="dashboard-form__field">
                <label for="display_name"><?php echo esc_html__('نام نمایشی', 'rozholy'); ?></label>
                <input type="text" id="display_name" name="display_name" value="<?php echo esc_attr($user->display_name); ?>" required>
            </div>

            <div class="dashboard-form__field">
                <label for="email"><?php echo esc_html__('ایمیل', 'rozholy'); ?></label>
                <input type="email" id="email" value="<?php echo esc_attr($user->user_email); ?>" disabled>
                <p class="dashboard-form__hint"><?php echo esc_html__('ایمیل قابل تغییر نیست.', 'rozholy'); ?></p>
            </div>

            <div class="dashboard-form__field">
                <label for="description"><?php echo esc_html__('درباره من', 'rozholy'); ?></label>
                <textarea id="description" name="description" rows="4"><?php echo esc_textarea($user->description); ?></textarea>
            </div>

            <div class="dashboard-form__actions">
                <button type="submit" class="dashboard-btn dashboard-btn--primary">
                    <?php echo esc_html__('ذخیره تغییرات', 'rozholy'); ?>
                </button>
            </div>
        </form>
    </div>
</div>
