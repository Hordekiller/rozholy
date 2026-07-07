<?php
defined('ABSPATH') || exit;

class Rozholy_Testimonials extends \Elementor\Widget_Base {

    public function get_name() {
        return 'rozholy_testimonials';
    }

    public function get_title() {
        return esc_html__('Testimonials', 'rozholy');
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return ['rozholy'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('rating', [
            'label'   => esc_html__('Rating', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 5,
            'default' => 5,
        ]);

        $repeater->add_control('content', [
            'label'   => esc_html__('Testimonial', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('Great service!', 'rozholy'),
        ]);

        $repeater->add_control('name', [
            'label'   => esc_html__('Name', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Customer', 'rozholy'),
        ]);

        $repeater->add_control('tag', [
            'label'   => esc_html__('Tag', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('مشتری ثابت', 'rozholy'),
        ]);

        $repeater->add_control('icon', [
            'label'   => esc_html__('Icon Emoji', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '🌹',
        ]);

        $this->add_control('testimonials', [
            'label'   => esc_html__('Testimonials', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (empty($settings['testimonials'])) return;
        ?>
        <div style="padding:clamp(4rem, 10vh, 9rem) 20px;background:#faf5f0">
            <div style="max-width:1200px;margin:0 auto">
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px">
                    <?php foreach ($settings['testimonials'] as $index => $item) : ?>
                        <div class="glass-card" style="padding:35px 30px;border-radius:16px;background:#fff;border:1px solid #e8ddd5" data-reveal="fade-up" data-reveal-delay="<?php echo $index + 1; ?>">
                            <p style="color:#c8a87c;font-size:1.1rem;margin:0 0 12px"><?php echo str_repeat('⭐', intval($item['rating'])); ?></p>
                            <p style="font-style:italic;font-size:1rem;margin:0 0 16px"><?php echo esc_html($item['content']); ?></p>
                            <div style="display:flex;align-items:center;gap:12px">
                                <span style="font-size:2rem"><?php echo esc_html($item['icon']); ?></span>
                                <div>
                                    <p style="font-weight:600;font-size:0.95rem;margin:0"><?php echo esc_html($item['name']); ?></p>
                                    <p style="color:#7a7a7a;font-size:0.8rem;margin:0"><?php echo esc_html($item['tag']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
