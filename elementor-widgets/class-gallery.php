<?php

class Rozholy_Gallery extends \Elementor\Widget_Base {
    public function get_name() { return 'rozholy_gallery'; }
    public function get_title() { return esc_html__('گالری تصاویر Rozholy', 'rozholy'); }
    public function get_icon() { return 'eicon-gallery-masonry'; }
    public function get_categories() { return ['rozholy']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('گالری', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('image', [
            'label' => esc_html__('تصویر', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ]);
        $repeater->add_control('title', [
            'label' => esc_html__('عنوان', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::TEXT,
        ]);
        $repeater->add_control('filter', [
            'label' => esc_html__('دسته‌بندی (فیلتر)', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::TEXT,
        ]);

        $this->add_control('images', [
            'label'       => esc_html__('تصاویر', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [[], [], [], [], [], []],
            'title_field' => '{{{ title }}}',
        ]);

        $this->add_control('layout', [
            'label'   => esc_html__('نوع چیدمان', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid'    => esc_html__('شبکه‌ای', 'rozholy'),
                'masonry' => esc_html__('ماسونری', 'rozholy'),
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout = $settings['layout'] ?? 'grid';
        ?>
        <div class="rz-gallery-section">
          <div class="rz-gallery-filters">
            <button class="rz-gallery-filter active" data-filter="all"><?php esc_html_e('همه', 'rozholy'); ?></button>
            <?php
            $filters = [];
            foreach ($settings['images'] as $img) {
                if (!empty($img['filter'])) $filters[$img['filter']] = $img['filter'];
            }
            foreach ($filters as $filter) : ?>
              <button class="rz-gallery-filter" data-filter="<?php echo esc_attr($filter); ?>"><?php echo esc_html($filter); ?></button>
            <?php endforeach; ?>
          </div>
          <div class="rz-gallery-grid" data-layout="<?php echo esc_attr($layout); ?>">
            <?php foreach ($settings['images'] as $image) :
                if (empty($image['image']['url'])) continue;
            ?>
              <div class="rz-gallery-item" data-filter="<?php echo esc_attr($image['filter'] ?? 'all'); ?>">
                <img src="<?php echo esc_url($image['image']['url']); ?>" alt="<?php echo esc_attr($image['title'] ?? ''); ?>" />
                <div class="rz-gallery-item-overlay">
                  <h4><?php echo esc_html($image['title'] ?? ''); ?></h4>
                  <span class="rz-gallery-zoom">+</span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php
    }
}
