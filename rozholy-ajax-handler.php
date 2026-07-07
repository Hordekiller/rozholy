<?php

add_action('wp_ajax_rozholy_submit_booking', 'rozholy_handle_booking_submission');
add_action('wp_ajax_nopriv_rozholy_submit_booking', 'rozholy_handle_booking_submission');

function rozholy_handle_booking_submission() {
    if (!wp_verify_nonce($_POST['rozholy_booking_nonce'] ?? '', 'rozholy_booking_nonce')) {
        wp_send_json_error(['message' => esc_html__('خطای امنیتی. لطفاً دوباره تلاش کنید.', 'rozholy')]);
    }

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $date    = sanitize_text_field($_POST['date'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($phone)) {
        wp_send_json_error(['message' => esc_html__('لطفاً نام و شماره تماس را وارد کنید.', 'rozholy')]);
    }

    $admin_email = get_option('admin_email');
    $subject = sprintf(esc_html__('رزرو جدید از %s', 'rozholy'), $name);
    $body = sprintf(
        "نام: %s\nشماره تماس: %s\nخدمت: %s\nتاریخ: %s\nتوضیحات: %s",
        $name, $phone, $service, $date, $message
    );
    $headers = ['Content-Type: text/plain; charset=UTF-8'];

    wp_mail($admin_email, $subject, $body, $headers);

    $post_data = [
        'post_title'   => sprintf(esc_html__('رزرو - %s - %s', 'rozholy'), $name, $phone),
        'post_type'    => 'rozholy_booking',
        'post_status'  => 'publish',
        'meta_input'   => [
            '_booking_name'    => $name,
            '_booking_phone'   => $phone,
            '_booking_service' => $service,
            '_booking_date'    => $date,
            '_booking_message' => $message,
        ],
    ];

    wp_insert_post($post_data);

    wp_send_json_success(['message' => esc_html__('درخواست شما با موفقیت ثبت شد.', 'rozholy')]);
}

add_action('init', 'rozholy_register_booking_post_type');
function rozholy_register_booking_post_type() {
    register_post_type('rozholy_booking', [
        'labels'      => [
            'name'          => esc_html__('رزروها', 'rozholy'),
            'singular_name' => esc_html__('رزرو', 'rozholy'),
            'menu_name'     => esc_html__('رزروهای Rozholy', 'rozholy'),
        ],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-calendar-alt',
        'supports'    => ['title'],
        'capabilities' => [
            'edit_post'          => 'manage_options',
            'read_post'          => 'manage_options',
            'delete_post'        => 'manage_options',
            'edit_posts'         => 'manage_options',
            'edit_others_posts'  => 'manage_options',
            'publish_posts'      => 'manage_options',
            'read_private_posts' => 'manage_options',
        ],
        'show_in_menu' => true,
    ]);
}

add_filter('manage_rozholy_booking_posts_columns', 'rozholy_booking_columns');
function rozholy_booking_columns($columns) {
    $columns = [
        'cb'       => '<input type="checkbox" />',
        'title'    => esc_html__('نام', 'rozholy'),
        'phone'    => esc_html__('شماره تماس', 'rozholy'),
        'service'  => esc_html__('خدمت', 'rozholy'),
        'date'     => esc_html__('تاریخ', 'rozholy'),
        'date_created' => esc_html__('تاریخ ثبت', 'rozholy'),
    ];
    return $columns;
}

add_action('manage_rozholy_booking_posts_custom_column', 'rozholy_booking_column_data', 10, 2);
function rozholy_booking_column_data($column, $post_id) {
    switch ($column) {
        case 'phone':
            echo esc_html(get_post_meta($post_id, '_booking_phone', true));
            break;
        case 'service':
            echo esc_html(get_post_meta($post_id, '_booking_service', true));
            break;
        case 'date':
            echo esc_html(get_post_meta($post_id, '_booking_date', true));
            break;
        case 'date_created':
            echo esc_html(get_the_date('j F Y H:i', $post_id));
            break;
    }
}
