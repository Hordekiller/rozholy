<?php

class Rozholy_Booking_Form extends \Elementor\Widget_Base {
    public function get_name() { return 'rozholy_booking_form'; }
    public function get_title() { return esc_html__('فرم رزرو Rozholy', 'rozholy'); }
    public function get_icon() { return 'eicon-form-horizontal'; }
    public function get_categories() { return ['rozholy']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('تنظیمات فرم', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('form_title', [
            'label'   => esc_html__('عنوان فرم', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('رزرو نوبت آنلاین', 'rozholy'),
        ]);

        $this->add_control('form_desc', [
            'label'   => esc_html__('توضیحات فرم', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('برای رزرو وقت، اطلاعات خود را وارد کنید. همکاران ما در اسرع وقت با شما تماس خواهند گرفت.', 'rozholy'),
        ]);

        $this->add_control('services_list', [
            'label'       => esc_html__('لیست خدمات (هر خط یک خدمت)', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => "کوتاهی مو\nرنگ مو\nکاشت ناخن\nمیکاپ\nاسپا و ماساژ\nپاکسازی پوست",
            'description' => esc_html__('هر خط به عنوان یک گزینه در منوی کشویی خدمات نمایش داده می‌شود.', 'rozholy'),
        ]);

        $this->add_control('submit_text', [
            'label'   => esc_html__('متن دکمه ارسال', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('ثبت درخواست', 'rozholy'),
        ]);

        $this->add_control('success_message', [
            'label'   => esc_html__('پیام موفقیت', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('درخواست شما با موفقیت ثبت شد. به زودی با شما تماس خواهیم گرفت.', 'rozholy'),
        ]);

        $this->add_control('admin_email', [
            'label'       => esc_html__('ایمیل دریافت نوتیفیکیشن', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => get_option('admin_email'),
            'description' => esc_html__('اعلان رزرو به این ایمیل ارسال می‌شود.', 'rozholy'),
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $services = explode("\n", str_replace("\r", "", $settings['services_list']));
        $nonce = wp_create_nonce('rozholy_booking_nonce');
        ?>
        <div class="rz-booking-section">
          <div class="rz-booking-form-wrapper">
            <h3 class="rz-booking-title"><?php echo esc_html($settings['form_title']); ?></h3>
            <p class="rz-booking-desc"><?php echo esc_html($settings['form_desc']); ?></p>
            <form class="rz-booking-form" method="post" action="">
              <input type="hidden" name="rozholy_booking_action" value="submit" />
              <input type="hidden" name="rozholy_booking_nonce" value="<?php echo esc_attr($nonce); ?>" />

              <div class="rz-booking-row">
                <div class="rz-booking-field">
                  <label for="rz-booking-name"><?php esc_html_e('نام و نام خانوادگی', 'rozholy'); ?> <span class="required">*</span></label>
                  <input type="text" id="rz-booking-name" name="name" required placeholder="<?php esc_attr_e('نام خود را وارد کنید', 'rozholy'); ?>" />
                </div>
                <div class="rz-booking-field">
                  <label for="rz-booking-phone"><?php esc_html_e('شماره تماس', 'rozholy'); ?> <span class="required">*</span></label>
                  <input type="tel" id="rz-booking-phone" name="phone" required placeholder="<?php esc_attr_e('۰۹۱۲۳۴۵۶۷۸۹', 'rozholy'); ?>" />
                </div>
              </div>

              <div class="rz-booking-row">
                <div class="rz-booking-field">
                  <label for="rz-booking-service"><?php esc_html_e('نوع خدمت', 'rozholy'); ?> <span class="required">*</span></label>
                  <select id="rz-booking-service" name="service" required>
                    <option value=""><?php esc_html_e('انتخاب کنید...', 'rozholy'); ?></option>
                    <?php foreach ($services as $service) : if (empty(trim($service))) continue; ?>
                      <option value="<?php echo esc_attr(trim($service)); ?>"><?php echo esc_html(trim($service)); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="rz-booking-field">
                  <label for="rz-booking-date"><?php esc_html_e('تاریخ مورد نظر', 'rozholy'); ?></label>
                  <input type="date" id="rz-booking-date" name="date" />
                </div>
              </div>

              <div class="rz-booking-field rz-booking-field--full">
                <label for="rz-booking-message"><?php esc_html_e('توضیحات اضافی', 'rozholy'); ?></label>
                <textarea id="rz-booking-message" name="message" rows="3" placeholder="<?php esc_attr_e('توضیحات خود را وارد کنید...', 'rozholy'); ?>"></textarea>
              </div>

              <div class="rz-booking-submit">
                <button type="submit" class="btn btn-primary btn-lg"><?php echo esc_html($settings['submit_text']); ?></button>
              </div>
            </form>
            <div class="rz-booking-success" style="display:none;">
              <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--rz-primary)" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              <p><?php echo esc_html($settings['success_message']); ?></p>
            </div>
          </div>
        </div>
        <?php
    }
}
