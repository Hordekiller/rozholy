<?php

class Rozholy_About_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('rozholy_about', esc_html__('Rozholy - درباره ما', 'rozholy'), [
            'description' => esc_html__('نمایش اطلاعات درباره سالن', 'rozholy'),
        ]);
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $title = !empty($instance['title']) ? $instance['title'] : '';
        if ($title) echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        if (!empty($instance['text'])) echo '<p class="about-text">' . wp_kses_post($instance['text']) . '</p>';
        if (!empty($instance['btn_text']) && !empty($instance['btn_url'])) {
            echo '<a href="' . esc_url($instance['btn_url']) . '" class="btn btn-secondary btn-sm">' . esc_html($instance['btn_text']) . '</a>';
        }
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title   = $instance['title'] ?? '';
        $text    = $instance['text'] ?? '';
        $btn_text = $instance['btn_text'] ?? '';
        $btn_url  = $instance['btn_url'] ?? '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('عنوان:', 'rozholy'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php esc_html_e('متن:', 'rozholy'); ?></label>
        <textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea($text); ?></textarea></p>
        <p><label for="<?php echo $this->get_field_id('btn_text'); ?>"><?php esc_html_e('متن دکمه:', 'rozholy'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('btn_text'); ?>" name="<?php echo $this->get_field_name('btn_text'); ?>" type="text" value="<?php echo esc_attr($btn_text); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('btn_url'); ?>"><?php esc_html_e('لینک دکمه:', 'rozholy'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('btn_url'); ?>" name="<?php echo $this->get_field_name('btn_url'); ?>" type="url" value="<?php echo esc_url($btn_url); ?>" /></p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']   = sanitize_text_field($new_instance['title']);
        $instance['text']    = wp_kses_post($new_instance['text']);
        $instance['btn_text'] = sanitize_text_field($new_instance['btn_text']);
        $instance['btn_url']  = esc_url_raw($new_instance['btn_url']);
        return $instance;
    }
}

class Rozholy_Social_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('rozholy_social', esc_html__('Rozholy - شبکه‌های اجتماعی', 'rozholy'), [
            'description' => esc_html__('نمایش آیکون شبکه‌های اجتماعی', 'rozholy'),
        ]);
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $title = !empty($instance['title']) ? $instance['title'] : '';
        if ($title) echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        ?>
        <div class="rozholy-social-widget">
          <?php
          $socials = ['instagram', 'telegram', 'whatsapp', 'youtube', 'linkedin', 'facebook'];
          foreach ($socials as $social) :
              $url = get_theme_mod('rozholy_social_' . $social);
              if ($url) : ?>
                <a href="<?php echo esc_url($url); ?>" class="social-icon social-<?php echo esc_attr($social); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social); ?>">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </a>
              <?php endif;
          endforeach; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = $instance['title'] ?? '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('عنوان:', 'rozholy'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p class="description"><?php esc_html_e('لینک شبکه‌های اجتماعی را در بخش سفارشی‌سازی > شبکه‌های اجتماعی تنظیم کنید.', 'rozholy'); ?></p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = sanitize_text_field($new_instance['title']);
        return $instance;
    }
}

class Rozholy_Contact_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('rozholy_contact', esc_html__('Rozholy - اطلاعات تماس', 'rozholy'), [
            'description' => esc_html__('نمایش اطلاعات تماس سالن', 'rozholy'),
        ]);
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $title = !empty($instance['title']) ? $instance['title'] : '';
        if ($title) echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        ?>
        <ul class="rozholy-contact-widget">
          <?php if ($phone = get_theme_mod('rozholy_contact_phone')) : ?>
            <li>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
            </li>
          <?php endif; ?>
          <?php if ($mobile = get_theme_mod('rozholy_contact_mobile')) : ?>
            <li>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
              <a href="tel:<?php echo esc_attr($mobile); ?>"><?php echo esc_html($mobile); ?></a>
            </li>
          <?php endif; ?>
          <?php if ($email = get_theme_mod('rozholy_contact_email')) : ?>
            <li>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </li>
          <?php endif; ?>
          <?php if ($address = get_theme_mod('rozholy_contact_address')) : ?>
            <li>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <span><?php echo esc_html($address); ?></span>
            </li>
          <?php endif; ?>
          <?php if ($worktime = get_theme_mod('rozholy_contact_worktime')) : ?>
            <li>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span><?php echo esc_html($worktime); ?></span>
            </li>
          <?php endif; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = $instance['title'] ?? '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('عنوان:', 'rozholy'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p class="description"><?php esc_html_e('اطلاعات تماس را در بخش سفارشی‌سازی > اطلاعات تماس تنظیم کنید.', 'rozholy'); ?></p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = sanitize_text_field($new_instance['title']);
        return $instance;
    }
}

add_action('widgets_init', function() {
    register_widget('Rozholy_About_Widget');
    register_widget('Rozholy_Social_Widget');
    register_widget('Rozholy_Contact_Widget');
});
