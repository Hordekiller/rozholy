<?php
defined('ABSPATH') || exit;

class Rozholy_Booking_Form extends \Elementor\Widget_Base {

    public function get_name() {
        return 'rozholy_booking_form';
    }

    public function get_title() {
        return esc_html__('Booking Form', 'rozholy');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
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
            'default' => esc_html__('رزرو نوبت آنلاین', 'rozholy'),
        ]);

        $this->add_control('description', [
            'label'   => esc_html__('Description', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('برای رزرو وقت، اطلاعات خود را وارد کنید.', 'rozholy'),
        ]);

        $this->add_control('form_shortcode', [
            'label'       => esc_html__('Form Shortcode', 'rozholy'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'description' => esc_html__('e.g. [contact-form-7 id="123"]', 'rozholy'),
            'placeholder' => '[contact-form-7 id="booking"]',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div style="padding:clamp(4rem, 10vh, 9rem) 20px;background:#f5ece4">
            <div style="max-width:650px;margin:0 auto" data-reveal="fade-up">
                <div class="glass-card" style="padding:45px;border-radius:16px;background:#fff;border:1px solid #e8ddd5;text-align:center">
                    <h3 style="font-size:1.8rem;margin:0 0 12px"><span class="text-gradient"><?php echo esc_html($settings['title']); ?></span></h3>
                    <p style="color:#7a7a7a;margin:0 0 24px"><?php echo esc_html($settings['description']); ?></p>
                    <?php if (! empty($settings['form_shortcode'])) : ?>
                        <?php echo do_shortcode($settings['form_shortcode']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
