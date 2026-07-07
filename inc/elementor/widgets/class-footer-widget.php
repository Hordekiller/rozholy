<?php
defined( 'ABSPATH' ) || exit;

class Rozholy_Footer_Widget extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'rozholy_footer'; }
	public function get_title(): string {
		return esc_html__( 'Rozholy Footer', 'rozholy' ); }
	public function get_icon(): string {
		return 'eicon-footer'; }
	public function get_categories(): array {
		return array( 'rozholy' ); }
	public function get_keywords(): array {
		return array( 'footer', 'copyright', 'newsletter' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'column_1',
			array(
				'label' => esc_html__( 'Column 1', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'col1_title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'About Us', 'rozholy' ),
			)
		);
		$this->add_control(
			'col1_content',
			array(
				'label'   => esc_html__( 'Content', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Your beauty salon description here.', 'rozholy' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'column_2',
			array(
				'label' => esc_html__( 'Column 2 (Links)', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'col2_title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Quick Links', 'rozholy' ),
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'link_text',
			array(
				'label'   => esc_html__( 'Link Text', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Link', 'rozholy' ),
			)
		);
		$repeater->add_control(
			'link_url',
			array(
				'label' => esc_html__( 'URL', 'rozholy' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->add_control(
			'links',
			array(
				'label'       => esc_html__( 'Links', 'rozholy' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ link_text }}}',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'column_3',
			array(
				'label' => esc_html__( 'Column 3 (Contact)', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'col3_title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact', 'rozholy' ),
			)
		);
		$this->add_control(
			'address',
			array(
				'label'   => esc_html__( 'Address', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( '123 Salon St., City', 'rozholy' ),
			)
		);
		$this->add_control(
			'phone',
			array(
				'label'   => esc_html__( 'Phone', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '+98 21 1234 5678',
			)
		);
		$this->add_control(
			'email',
			array(
				'label'   => esc_html__( 'Email', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'info@example.com',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'newsletter_section',
			array(
				'label' => esc_html__( 'Newsletter', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'newsletter_title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Stay in Touch', 'rozholy' ),
			)
		);
		$this->add_control(
			'newsletter_placeholder',
			array(
				'label'   => esc_html__( 'Placeholder', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your email address', 'rozholy' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'copyright_section',
			array(
				'label' => esc_html__( 'Copyright', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'copyright_text',
			array(
				'label'   => esc_html__( 'Copyright Text', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => sprintf( esc_html__( '© %s Rozholy. All rights reserved.', 'rozholy' ), date( 'Y' ) ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'bg_color',
			array(
				'label'     => esc_html__( 'Background', 'rozholy' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2d2d2d',
				'selectors' => array( '{{WRAPPER}} .rz-footer' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'rozholy' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e8ddd5',
				'selectors' => array( '{{WRAPPER}} .rz-footer, {{WRAPPER}} .rz-footer a:not(:hover)' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'rozholy' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d4a0a0',
				'selectors' => array( '{{WRAPPER}} .rz-footer h4' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	protected function render(): void {
		$s = $this->get_settings_for_display();
		?>
		<footer class="rz-footer" style="padding:60px 20px 0;color:#e8ddd5;">
			<div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:40px;">
				<div>
					<h4 style="color:#d4a0a0;margin:0 0 16px;font-size:1.1rem;"><?php echo esc_html( $s['col1_title'] ); ?></h4>
					<div style="line-height:1.8;font-size:0.95rem;"><?php echo $s['col1_content']; ?></div>
				</div>
				<div>
					<h4 style="color:#d4a0a0;margin:0 0 16px;font-size:1.1rem;"><?php echo esc_html( $s['col2_title'] ); ?></h4>
					<ul style="list-style:none;padding:0;margin:0;">
						<?php foreach ( ( $s['links'] ?? array() ) as $link ) : ?>
							<li style="margin-bottom:8px;">
								<a href="<?php echo esc_url( $link['link_url']['url'] ?? '#' ); ?>" style="color:inherit;text-decoration:none;font-size:0.95rem;"><?php echo esc_html( $link['link_text'] ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div>
					<h4 style="color:#d4a0a0;margin:0 0 16px;font-size:1.1rem;"><?php echo esc_html( $s['col3_title'] ); ?></h4>
					<div style="line-height:1.8;font-size:0.95rem;">
						<?php
						if ( $s['address'] ) :
							?>
							<p style="margin:0 0 8px;"><?php echo esc_html( $s['address'] ); ?></p><?php endif; ?>
						<?php
						if ( $s['phone'] ) :
							?>
							<p style="margin:0 0 8px;">&phone; <?php echo esc_html( $s['phone'] ); ?></p><?php endif; ?>
						<?php
						if ( $s['email'] ) :
							?>
							<p style="margin:0 0 8px;">&#9993; <?php echo esc_html( $s['email'] ); ?></p><?php endif; ?>
					</div>
				</div>
				<div>
					<h4 style="color:#d4a0a0;margin:0 0 16px;font-size:1.1rem;"><?php echo esc_html( $s['newsletter_title'] ); ?></h4>
					<form class="rz-newsletter-form" action="#" method="post" style="display:flex;gap:8px;">
						<input type="email" name="email" required placeholder="<?php echo esc_attr( $s['newsletter_placeholder'] ); ?>" style="flex:1;padding:10px 14px;border:1px solid rgba(255,255,255,0.2);border-radius:8px;background:rgba(255,255,255,0.1);color:#fff;font-size:0.9rem;" />
						<button type="submit" style="padding:10px 20px;border:none;border-radius:8px;background:#d4a0a0;color:#fff;font-weight:600;cursor:pointer;">&#9993;</button>
					</form>
				</div>
			</div>
			<div style="max-width:1200px;margin:0 auto;padding:24px 0;text-align:center;border-top:1px solid rgba(255,255,255,0.1);margin-top:40px;font-size:0.85rem;">
				<?php echo esc_html( $s['copyright_text'] ); ?>
			</div>
		</footer>
		<?php
	}
}
