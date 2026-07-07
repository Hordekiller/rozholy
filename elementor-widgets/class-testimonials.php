<?php

class Rozholy_Testimonials extends \Elementor\Widget_Base {
    public function get_name() { return 'rozholy_testimonials'; }
    public function get_title() { return esc_html__('نظرات مشتریان Rozholy', 'rozholy'); }
    public function get_icon() { return 'eicon-testimonial'; }
    public function get_categories() { return ['rozholy']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('نظرات', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('name', [
            'label'   => esc_html__('نام', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('مریم احمدی', 'rozholy'),
        ]);
        $repeater->add_control('role', [
            'label'   => esc_html__('نقش/مشتری', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('مشتری ثابت', 'rozholy'),
        ]);
        $repeater->add_control('avatar', [
            'label' => esc_html__('تصویر', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ]);
        $repeater->add_control('content', [
            'label'   => esc_html__('متن نظر', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('عالی‌ترین تجربه زیبایی که تا حالا داشتم. تیم حرفه‌ای و فضای فوق‌العاده دلنشین.', 'rozholy'),
        ]);
        $repeater->add_control('rating', [
            'label'   => esc_html__('امتیاز', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '5',
            'options' => ['1' => '⭐', '2' => '⭐⭐', '3' => '⭐⭐⭐', '4' => '⭐⭐⭐⭐', '5' => '⭐⭐⭐⭐⭐'],
        ]);

        $this->add_control('testimonials', [
            'label'       => esc_html__('نظرات', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['name' => 'مریم احمدی', 'content' => 'عالی‌ترین تجربه زیبایی که تا حالا داشتم.'],
                ['name' => 'سارا محمدی', 'content' => 'فضای سالن فوق‌العاده زیبا و تیم بسیار حرفه‌ای.'],
            ],
            'title_field' => '{{{ name }}}',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('استایل', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('bg_color', [
            'label' => esc_html__('رنگ پس‌زمینه', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#faf5f0',
            'selectors' => ['{{WRAPPER}} .rz-testimonials-section' => 'background-color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="rz-testimonials-section">
          <div class="rz-testimonials-grid">
            <?php foreach ($settings['testimonials'] as $testimonial) : ?>
              <div class="rz-testimonial-card">
                <div class="rz-testimonial-stars">
                  <?php for ($i = 0; $i < intval($testimonial['rating']); $i++) : ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="var(--rz-accent)" stroke="var(--rz-accent)" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <?php endfor; ?>
                </div>
                <p class="rz-testimonial-text">"<?php echo esc_html($testimonial['content']); ?>"</p>
                <div class="rz-testimonial-author">
                  <div class="rz-testimonial-avatar">
                    <?php if (!empty($testimonial['avatar']['url'])) : ?>
                      <img src="<?php echo esc_url($testimonial['avatar']['url']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>" />
                    <?php else : ?>
                      <div class="rz-testimonial-avatar-placeholder"><?php echo esc_html(mb_substr($testimonial['name'], 0, 1)); ?></div>
                    <?php endif; ?>
                  </div>
                  <div class="rz-testimonial-info">
                    <strong class="rz-testimonial-name"><?php echo esc_html($testimonial['name']); ?></strong>
                    <span class="rz-testimonial-role"><?php echo esc_html($testimonial['role']); ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php
    }
}
