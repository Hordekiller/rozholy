<?php
defined('ABSPATH') || exit;

class Rozholy_Service_Grid extends \Elementor\Widget_Base {

    public function get_name() {
        return 'rozholy_service_grid';
    }

    public function get_title() {
        return esc_html__('Service Grid', 'rozholy');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['rozholy'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('section_title', [
            'label'   => esc_html__('Section Title', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('خدمات تخصصی ما', 'rozholy'),
        ]);

        $this->add_control('section_desc', [
            'label'   => esc_html__('Section Description', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('ارائه بهترین خدمات زیبایی با جدیدترین متدهای روز دنیا', 'rozholy'),
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('icon', [
            'label'   => esc_html__('Icon Emoji', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '💇‍♀️',
        ]);

        $repeater->add_control('title', [
            'label'   => esc_html__('Title', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Service', 'rozholy'),
        ]);

        $repeater->add_control('description', [
            'label'   => esc_html__('Description', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('Service description', 'rozholy'),
        ]);

        $this->add_control('services', [
            'label'   => esc_html__('Services', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                ['icon' => '💇‍♀️', 'title' => esc_html__('کوتاهی مو', 'rozholy')],
                ['icon' => '🎨', 'title' => esc_html__('رنگ و مش', 'rozholy')],
                ['icon' => '💅', 'title' => esc_html__('ناخن و کاشت', 'rozholy')],
                ['icon' => '💄', 'title' => esc_html__('میکاپ حرفه‌ای', 'rozholy')],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div style="padding:clamp(4rem, 10vh, 9rem) 20px;text-align:center">
            <div data-reveal="fade-up" style="max-width:600px;margin:0 auto 50px">
                <h2 style="font-size:clamp(2rem, 5vw, 2.5rem)"><span class="text-gradient"><?php echo esc_html($settings['section_title']); ?></span></h2>
                <p style="color:#7a7a7a;font-size:1.1rem"><?php echo esc_html($settings['section_desc']); ?></p>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;max-width:1200px;margin:0 auto">
                <?php foreach ($settings['services'] as $index => $service) : ?>
                    <div data-reveal="fade-up" data-reveal-delay="<?php echo $index + 1; ?>" data-tilt style="perspective:800px">
                        <div class="glass-card" style="padding:35px 25px;border-radius:16px;background:#fff;border:1px solid #e8ddd5" data-tilt-target>
                            <p style="font-size:2.5rem;margin:0 0 12px"><?php echo esc_html($service['icon']); ?></p>
                            <h3 style="font-size:1.15rem;margin:0 0 8px"><?php echo esc_html($service['title']); ?></h3>
                            <p style="color:#7a7a7a;font-size:0.9rem;margin:0"><?php echo esc_html($service['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
