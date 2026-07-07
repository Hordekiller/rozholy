<?php
defined('ABSPATH') || exit;

$user = wp_get_current_user();
$current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'profile';
$tabs = [
    'profile'  => ['label' => __('پروفایل', 'rozholy'), 'icon' => '👤'],
    'security' => ['label' => __('امنیت', 'rozholy'), 'icon' => '🔒'],
    'activity' => ['label' => __('فعالیت‌ها', 'rozholy'), 'icon' => '📊'],
];
?>

<div class="dashboard-sidebar__inner">
    <div class="dashboard-sidebar__user">
        <?php echo rozholy_get_avatar($user->ID, 64); ?>
        <div class="dashboard-sidebar__user-info">
            <strong><?php echo esc_html($user->display_name); ?></strong>
            <span><?php echo esc_html($user->user_email); ?></span>
        </div>
    </div>

    <nav class="dashboard-sidebar__nav">
        <ul>
            <?php foreach ($tabs as $tab => $data) : ?>
                <li class="<?php echo $tab === $current_tab ? 'active' : ''; ?>">
                    <a href="?tab=<?php echo esc_attr($tab); ?>">
                        <span class="nav-icon"><?php echo esc_html($data['icon']); ?></span>
                        <?php echo esc_html($data['label']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <div class="dashboard-sidebar__footer">
        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="dashboard-logout">
            <?php echo esc_html__('خروج', 'rozholy'); ?>
        </a>
    </div>
</div>
