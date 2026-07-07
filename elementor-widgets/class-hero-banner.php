<?php

class Rozholy_Hero_Banner extends \Elementor\Widget_Base {
    public function get_name() { return 'rozholy_hero_banner'; }
    public function get_title() { return esc_html__('بنر هدر Rozholy', 'rozholy'); }
    public function get_icon() { return 'eicon-banner'; }
    public function get_categories() { return ['rozholy']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('محتوا', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label'       => esc_html__('عنوان', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__('زیبایی تو، هنر ماست', 'rozholy'),
            'label_block' => true,
        ]);

        $this->add_control('subtitle', [
            'label'       => esc_html__('زیرنویس', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => esc_html__('با تیمی حرفه‌ای از بهترین متخصصان زیبایی، تجربه‌ای متفاوت از آرایشگاه و سالن زیبایی را برای شما رقم می‌زنیم.', 'rozholy'),
        ]);

        $this->add_control('primary_btn_text', [
            'label'   => esc_html__('متن دکمه اصلی', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('رزرو وقت', 'rozholy'),
        ]);

        $this->add_control('primary_btn_url', [
            'label' => esc_html__('لینک دکمه اصلی', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::URL,
        ]);

        $this->add_control('secondary_btn_text', [
            'label'   => esc_html__('متن دکمه ثانویه', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('مشاهده خدمات', 'rozholy'),
        ]);

        $this->add_control('secondary_btn_url', [
            'label' => esc_html__('لینک دکمه ثانویه', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::URL,
        ]);

        $this->add_control('background_image', [
            'label' => esc_html__('تصویر پس‌زمینه', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ]);

        $this->add_control('overlay_color', [
            'label' => esc_html__('رنگ رویه', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(30, 30, 42, 0.6)',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('استایل', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'label'    => esc_html__('تایپوگرافی عنوان', 'rozholy'),
            'selector' => '{{WRAPPER}} .rz-hero-title',
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'subtitle_typography',
            'label'    => esc_html__('تایپوگرافی زیرنویس', 'rozholy'),
            'selector' => '{{WRAPPER}} .rz-hero-subtitle',
        ]);

        $this->add_control('title_color', [
            'label' => esc_html__('رنگ عنوان', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .rz-hero-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('subtitle_color', [
            'label' => esc_html__('رنگ زیرنویس', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.9)',
            'selectors' => ['{{WRAPPER}} .rz-hero-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $bg_image = $settings['background_image']['url'] ?? '';
        $overlay  = $settings['overlay_color'] ?? 'rgba(30,30,42,0.6)';
        ?>
        <div class="rz-hero-section" style="<?php echo $bg_image ? 'background-image:url(' . esc_url($bg_image) . ');' : ''; ?>">
          <div class="rz-hero-overlay" style="background:<?php echo esc_attr($overlay); ?>"></div>
          <div class="container rz-hero-content">
            <h1 class="rz-hero-title"><?php echo esc_html($settings['title']); ?></h1>
            <p class="rz-hero-subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
            <div class="rz-hero-buttons">
              <?php if ($settings['primary_btn_text'] && $settings['primary_btn_url']['url']) : ?>
                <a href="<?php echo esc_url($settings['primary_btn_url']['url']); ?>" class="btn btn-primary" <?php echo $settings['primary_btn_url']['is_external'] ? 'target="_blank"' : ''; ?>><?php echo esc_html($settings['primary_btn_text']); ?></a>
              <?php endif; ?>
              <?php if ($settings['secondary_btn_text'] && $settings['secondary_btn_url']['url']) : ?>
                <a href="<?php echo esc_url($settings['secondary_btn_url']['url']); ?>" class="btn btn-outline-light" <?php echo $settings['secondary_btn_url']['is_external'] ? 'target="_blank"' : ''; ?>><?php echo esc_html($settings['secondary_btn_text']); ?></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php
    }
}
