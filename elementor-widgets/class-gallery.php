<?php
defined('ABSPATH') || exit;

class Rozholy_Gallery extends \Elementor\Widget_Base {

    public function get_name() {
        return 'rozholy_gallery';
    }

    public function get_title() {
        return esc_html__('Gallery', 'rozholy');
    }

    public function get_icon() {
        return 'eicon-gallery-masonry';
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
            'default' => esc_html__('گالری تصاویر', 'rozholy'),
        ]);

        $gallery = new \Elementor\Repeater();

        $gallery->add_control('image', [
            'label' => esc_html__('Image', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ]);

        $gallery->add_control('alt', [
            'label' => esc_html__('Alt Text', 'rozholy'),
            'type'  => \Elementor\Controls_Manager::TEXT,
        ]);

        $this->add_control('images', [
            'label'   => esc_html__('Images', 'rozholy'),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $gallery->get_controls(),
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div style="padding:clamp(4rem, 10vh, 9rem) 20px;text-align:center">
            <div data-reveal="fade-up" style="max-width:600px;margin:0 auto 50px">
                <h2 style="font-size:clamp(2rem, 5vw, 2.5rem)"><span class="text-gradient"><?php echo esc_html($settings['section_title']); ?></span></h2>
            </div>
            <?php if (! empty($settings['images'])) : ?>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:16px;max-width:1200px;margin:0 auto">
                    <?php foreach ($settings['images'] as $index => $item) : ?>
                        <figure data-reveal="fade-scale" data-reveal-delay="<?php echo ($index % 3) + 1; ?>">
                            <img src="<?php echo esc_url($item['image']['url'] ?? 'https://placehold.co/600x600/d4a0a0/ffffff?text=Salon'); ?>" alt="<?php echo esc_attr($item['alt']); ?>" style="border-radius:12px;width:100%;height:auto">
                        </figure>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
