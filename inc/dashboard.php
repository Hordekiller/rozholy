<?php
defined('ABSPATH') || exit;

/* ── Redirect subscribers from wp-admin ── */
add_action('admin_init', 'rozholy_redirect_subscribers');
function rozholy_redirect_subscribers() {
    if (defined('DOING_AJAX') && DOING_AJAX) return;

    if (! current_user_can('edit_posts') && ! current_user_can('manage_options')) {
        $dashboard_page = get_theme_mod('rozholy_dashboard_page', 0);
        $redirect = $dashboard_page ? get_permalink($dashboard_page) : home_url();
        wp_safe_redirect($redirect);
        exit;
    }
}

/* ── Hide admin bar for subscribers ── */
add_filter('show_admin_bar', 'rozholy_show_admin_bar');
function rozholy_show_admin_bar($show) {
    if (current_user_can('subscriber')) return false;
    return $show;
}

/* ── Profile update handler ── */
add_action('admin_post_rozholy_update_profile', 'rozholy_handle_update_profile');
function rozholy_handle_update_profile() {
    if (! is_user_logged_in()) {
        wp_safe_redirect(wp_login_url());
        exit;
    }

    if (! isset($_POST['_wpnonce']) || ! wp_verify_nonce($_POST['_wpnonce'], 'rozholy_update_profile')) {
        wp_die(esc_html__('Invalid request.', 'rozholy'));
    }

    $user_id = get_current_user_id();
    $display_name = isset($_POST['display_name']) ? sanitize_text_field($_POST['display_name']) : '';
    $bio = isset($_POST['description']) ? sanitize_textarea_field($_POST['description']) : '';

    wp_update_user([
        'ID'           => $user_id,
        'display_name' => $display_name,
        'description'  => $bio,
    ]);

    /* ── Avatar upload ── */
    if (isset($_FILES['avatar']) && ! empty($_FILES['avatar']['name'])) {
        $file = $_FILES['avatar'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (! in_array($file['type'], $allowed_types, true)) {
            wp_die(esc_html__('Invalid file type. Please upload JPEG, PNG, GIF, or WebP.', 'rozholy'));
        }

        if (! current_user_can('upload_files')) {
            wp_die(esc_html__('You do not have permission to upload files.', 'rozholy'));
        }

        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attach_id = media_handle_upload('avatar', 0);
        if (is_wp_error($attach_id)) {
            wp_die(esc_html__('Avatar upload failed.', 'rozholy'));
        }

        update_user_meta($user_id, 'rozholy_avatar_id', $attach_id);
    }

    $redirect = add_query_arg('tab', 'profile', wp_get_referer());
    wp_safe_redirect(add_query_arg('updated', '1', $redirect));
    exit;
}

/* ── Password change handler ── */
add_action('admin_post_rozholy_change_password', 'rozholy_handle_change_password');
function rozholy_handle_change_password() {
    if (! is_user_logged_in()) {
        wp_safe_redirect(wp_login_url());
        exit;
    }

    if (! isset($_POST['_wpnonce']) || ! wp_verify_nonce($_POST['_wpnonce'], 'rozholy_change_password')) {
        wp_die(esc_html__('Invalid request.', 'rozholy'));
    }

    $user = wp_get_current_user();
    $current_pass = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_pass = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_pass = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if (! wp_check_password($current_pass, $user->user_pass, $user->ID)) {
        $redirect = add_query_arg('tab', 'security', wp_get_referer());
        wp_safe_redirect(add_query_arg('error', 'wrong_password', $redirect));
        exit;
    }

    if ($new_pass !== $confirm_pass || empty($new_pass)) {
        $redirect = add_query_arg('tab', 'security', wp_get_referer());
        wp_safe_redirect(add_query_arg('error', 'password_mismatch', $redirect));
        exit;
    }

    wp_set_password($new_pass, $user->ID);
    wp_logout();

    $login_url = wp_login_url(get_permalink(get_theme_mod('rozholy_dashboard_page', 0)));
    wp_safe_redirect(add_query_arg('password_changed', '1', $login_url));
    exit;
}

/* ── AJAX: activity load more ── */
add_action('wp_ajax_rozholy_load_activity', 'rozholy_ajax_load_activity');
function rozholy_ajax_load_activity() {
    check_ajax_referer('rozholy_dashboard_nonce', 'nonce');

    $user_id = get_current_user_id();
    if (! $user_id) {
        wp_send_json_error(['message' => 'Not logged in.']);
    }

    $type = isset($_POST['type']) ? sanitize_key($_POST['type']) : 'comments';
    $page = isset($_POST['page']) ? absint($_POST['page']) : 1;

    if ($type === 'comments') {
        $comments = get_comments([
            'user_id' => $user_id,
            'number'  => 10,
            'paged'   => $page,
            'status'  => 'approve',
        ]);

        ob_start();
        if (empty($comments)) {
            rozholy_empty_state('comments');
        } else {
            foreach ($comments as $comment) {
                echo '<div class="dashboard-card activity-item">';
                echo '<div class="activity-item__header">';
                echo '<span class="activity-item__type">' . esc_html__('نظر', 'rozholy') . '</span>';
                echo '<span class="activity-item__date">' . esc_html(get_comment_date('', $comment)) . '</span>';
                echo '</div>';
                echo '<p class="activity-item__excerpt">' . esc_html(wp_trim_words($comment->comment_content, 20)) . '</p>';
                echo '<a href="' . esc_url(get_comment_link($comment)) . '" class="activity-item__link">' . esc_html__('مشاهده', 'rozholy') . '</a>';
                echo '</div>';
            }
        }
        $html = ob_get_clean();
        wp_send_json_success(['html' => $html, 'page' => $page]);
    }

    if ($type === 'posts') {
        $posts = get_posts([
            'author'    => $user_id,
            'numberposts' => 10,
            'offset'    => ($page - 1) * 10,
            'post_status' => 'publish',
        ]);

        ob_start();
        if (empty($posts)) {
            rozholy_empty_state('posts');
        } else {
            foreach ($posts as $post) {
                setup_postdata($post);
                echo '<div class="dashboard-card activity-item">';
                echo '<div class="activity-item__header">';
                echo '<span class="activity-item__type">' . esc_html__('مطلب', 'rozholy') . '</span>';
                echo '<span class="activity-item__date">' . esc_html(get_the_date('', $post)) . '</span>';
                echo '</div>';
                echo '<h4 class="activity-item__title">' . esc_html(get_the_title($post)) . '</h4>';
                echo '<a href="' . esc_url(get_permalink($post)) . '" class="activity-item__link">' . esc_html__('مشاهده', 'rozholy') . '</a>';
                echo '</div>';
            }
        }
        $html = ob_get_clean();
        wp_send_json_success(['html' => $html, 'page' => $page]);
    }

    wp_send_json_error(['message' => 'Invalid type.']);
}

/* ── Get user avatar ── */
function rozholy_get_avatar($user_id, $size = 80) {
    $avatar_id = get_user_meta($user_id, 'rozholy_avatar_id', true);
    if ($avatar_id) {
        $src = wp_get_attachment_image_url($avatar_id, [$size, $size]);
        if ($src) {
            return '<img src="' . esc_url($src) . '" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" alt="' . esc_attr__('Avatar', 'rozholy') . '" class="dashboard-avatar" loading="lazy">';
        }
    }
    return get_avatar($user_id, $size, '', '', ['class' => 'dashboard-avatar']);
}

/* ── Empty state renderer ── */
function rozholy_empty_state($context) {
    $icons = [
        'orders'   => '🛒',
        'comments' => '💬',
        'posts'    => '📝',
        'activity' => '📭',
    ];
    $icon = isset($icons[$context]) ? $icons[$context] : '📭';

    $messages = [
        'orders'   => __('هنوز سفارشی ثبت نکرده‌اید.', 'rozholy'),
        'comments' => __('هنوز نظری ثبت نکرده‌اید.', 'rozholy'),
        'posts'    => __('هنوز مطلبی ننوشته‌اید.', 'rozholy'),
        'activity' => __('هنوز فعالیتی ندارید.', 'rozholy'),
    ];
    $message = isset($messages[$context]) ? $messages[$context] : __('موردی یافت نشد.', 'rozholy');
    ?>
    <div class="dashboard-empty-state">
        <span class="dashboard-empty-state__icon"><?php echo esc_html($icon); ?></span>
        <p class="dashboard-empty-state__text"><?php echo esc_html($message); ?></p>
    </div>
    <?php
}
