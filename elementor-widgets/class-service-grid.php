<?php

class Rozholy_Service_Grid extends \Elementor\Widget_Base {
    public function get_name() { return 'rozholy_service_grid'; }
    public function get_title() { return esc_html__('شبکه خدمات Rozholy', 'rozholy'); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return ['rozholy']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('خدمات', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('icon', [
            'label' => esc_html__('آیکون', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::ICONS,
        ]);

        $repeater->add_control('title', [
            'label'   => esc_html__('عنوان خدمت', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('کوتاهی مو', 'rozholy'),
        ]);

        $repeater->add_control('description', [
            'label'   => esc_html__('توضیحات', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('انجام انواع کوتاهی مو با جدیدترین متدهای روز دنیا توسط متخصصان مجرب.', 'rozholy'),
        ]);

        $repeater->add_control('price', [
            'label'   => esc_html__('قیمت', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '۵۰۰,۰۰۰ تومان',
        ]);

        $repeater->add_control('link', [
            'label' => esc_html__('لینک', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::URL,
        ]);

        $this->add_control('services', [
            'label'       => esc_html__('لیست خدمات', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['title' => esc_html__('کوتاهی مو', 'rozholy')],
                ['title' => esc_html__('رنگ مو', 'rozholy')],
                ['title' => esc_html__('کاشت ناخن', 'rozholy')],
                ['title' => esc_html__('میکاپ', 'rozholy')],
            ],
            'title_field' => '{{{ title }}}',
        ]);

        $this->add_control('columns', [
            'label'   => esc_html__('تعداد ستون', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '4',
            'options' => [
                '3' => '۳ ستون',
                '4' => '۴ ستون',
                '6' => '۶ ستون',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $services = $settings['services'];
        $columns  = $settings['columns'] ?? '4';
        ?>
        <div class="rz-services-section">
          <div class="rz-services-grid" style="--rz-services-cols: <?php echo esc_attr($columns); ?>">
            <?php foreach ($services as $service) : ?>
              <div class="rz-service-card">
                <div class="rz-service-icon">
                  <?php if (!empty($service['icon']['library'])) {
                      \Elementor\Icons_Manager::render_icon($service['icon'], ['aria-hidden' => 'true']);
                  } else { ?>
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                  <?php } ?>
                </div>
                <h3 class="rz-service-title"><?php echo esc_html($service['title']); ?></h3>
                <p class="rz-service-desc"><?php echo esc_html($service['description']); ?></p>
                <span class="rz-service-price"><?php echo esc_html($service['price']); ?></span>
                <?php if (!empty($service['link']['url'])) : ?>
                  <a href="<?php echo esc_url($service['link']['url']); ?>" class="rz-service-link"><?php esc_html_e('جزئیات بیشتر', 'rozholy'); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </a>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php
    }
}
