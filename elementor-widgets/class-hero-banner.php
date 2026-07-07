<?php
defined('ABSPATH') || exit;

class Rozholy_Hero_Banner extends \Elementor\Widget_Base {

    public function get_name() {
        return 'rozholy_hero_banner';
    }

    public function get_title() {
        return esc_html__('Hero Banner', 'rozholy');
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return ['rozholy'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content', 'rozholy'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label'   => esc_html__('Title', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('زیبایی تو، هنر ماست', 'rozholy'),
        ]);

        $this->add_control('subtitle', [
            'label'   => esc_html__('Subtitle', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('با تیمی حرفه‌ای از بهترین متخصصان زیبایی', 'rozholy'),
        ]);

        $this->add_control('button_text', [
            'label'   => esc_html__('Button Text', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('رزرو وقت', 'rozholy'),
        ]);

        $this->add_control('button_url', [
            'label'   => esc_html__('Button URL', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::URL,
            'placeholder' => '#',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="wp-block-cover alignfull hero-aurora has-grain" style="min-height:85vh;padding:80px 0">
            <span class="wp-block-cover__background has-dark-background-color has-background-dim-60 has-background-dim"></span>
            <div class="wp-block-cover__inner-container" style="text-align:center">
                <h1 style="color:#fff;font-size:clamp(2.5rem, 8vw, 5rem);font-weight:800;margin-bottom:16px" data-reveal="fade-up">
                    <?php echo esc_html($settings['title']); ?>
                </h1>
                <p style="color:rgba(255,255,255,0.85);font-size:clamp(1rem, 2.5vw, 1.3rem);margin-bottom:32px" data-reveal="fade-up" data-reveal-delay="1">
                    <?php echo esc_html($settings['subtitle']); ?>
                </p>
                <?php if (! empty($settings['button_text'])) : ?>
                    <div class="wp-block-buttons" style="justify-content:center" data-reveal="fade-up" data-reveal-delay="2">
                        <div class="wp-block-button btn-spring">
                            <a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="<?php echo esc_url($settings['button_url']['url'] ?? '#'); ?>" data-magnetic="0.2">
                                <?php echo esc_html($settings['button_text']); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
