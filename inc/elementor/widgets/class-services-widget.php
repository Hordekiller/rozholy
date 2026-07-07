<?php
defined( 'ABSPATH' ) || exit;

class Rozholy_Services_Widget extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'rozholy_services'; }
	public function get_title(): string {
		return esc_html__( 'Rozholy Services', 'rozholy' ); }
	public function get_icon(): string {
		return 'eicon-info-box'; }
	public function get_categories(): array {
		return array( 'rozholy' ); }
	public function get_keywords(): array {
		return array( 'services', 'cards', 'features' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Section Title', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Services', 'rozholy' ),
			)
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon (emoji/class)', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '&#10024;',
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Service Title', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Haircut', 'rozholy' ),
			)
		);
		$repeater->add_control(
			'desc',
			array(
				'label'   => esc_html__( 'Description', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Professional haircut service.', 'rozholy' ),
			)
		);
		$repeater->add_control(
			'price',
			array(
				'label'   => esc_html__( 'Price', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '₨ 200,000',
			)
		);
		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Booking Link', 'rozholy' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://',
			)
		);
		$this->add_control(
			'services',
			array(
				'label'       => esc_html__( 'Services', 'rozholy' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'icon'  => '&#10024;',
						'title' => esc_html__( 'Hair Styling', 'rozholy' ),
						'desc'  => esc_html__( 'Professional hair styling for any occasion.', 'rozholy' ),
						'price' => '₨ 200,000',
					),
					array(
						'icon'  => '&#127912;',
						'title' => esc_html__( 'Nail Art', 'rozholy' ),
						'desc'  => esc_html__( 'Creative nail designs and care.', 'rozholy' ),
						'price' => '₨ 150,000',
					),
					array(
						'icon'  => '&#129466;',
						'title' => esc_html__( 'Facial', 'rozholy' ),
						'desc'  => esc_html__( 'Rejuvenating facial treatments.', 'rozholy' ),
						'price' => '₨ 350,000',
					),
				),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$s        = $this->get_settings_for_display();
		$cols     = (int) ( $s['columns'] ?: 3 );
		$services = $s['services'] ?? array();
		?>
		<?php if ( $s['title'] ) : ?>
			<h2 style="text-align:center;font-size:2rem;margin-bottom:40px;color:#2d2d2d;"><?php echo esc_html( $s['title'] ); ?></h2>
		<?php endif; ?>
		<div style="display:grid;grid-template-columns:repeat(<?php echo $cols; ?>,1fr);gap:24px;">
			<?php foreach ( $services as $svc ) : ?>
				<div class="rz-service-card" style="background:#fff;border-radius:16px;padding:32px 24px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:transform 0.3s,box-shadow 0.3s;">
					<div style="font-size:2.5rem;margin-bottom:12px;"><?php echo $svc['icon']; ?></div>
					<h3 style="margin:0 0 8px;font-size:1.1rem;color:#2d2d2d;"><?php echo esc_html( $svc['title'] ); ?></h3>
					<p style="color:#7a7a7a;font-size:0.9rem;line-height:1.6;margin:0 0 12px;"><?php echo esc_html( $svc['desc'] ); ?></p>
					<div style="font-size:1.2rem;font-weight:700;color:#d4a0a0;margin-bottom:16px;"><?php echo esc_html( $svc['price'] ); ?></div>
					<a href="<?php echo esc_url( $svc['link']['url'] ?? '#' ); ?>" style="display:inline-block;padding:10px 28px;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#c08080);color:#fff;text-decoration:none;font-size:0.85rem;font-weight:600;">
						<?php esc_html_e( 'Book Now', 'rozholy' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
