<?php
defined( 'ABSPATH' ) || exit;

class Rozholy_Header_Widget extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'rozholy_header';
	}

	public function get_title(): string {
		return esc_html__( 'Rozholy Header', 'rozholy' );
	}

	public function get_icon(): string {
		return 'eicon-header';
	}

	public function get_categories(): array {
		return array( 'rozholy' );
	}

	public function get_keywords(): array {
		return array( 'header', 'nav', 'menu', 'navigation' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Header Content', 'rozholy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default (Logo Left + Menu Right)', 'rozholy' ),
					'centered' => esc_html__( 'Centered (Logo + Menu Below)', 'rozholy' ),
					'split'    => esc_html__( 'Split (Menu Left + Logo Center + Menu Right)', 'rozholy' ),
				),
			)
		);

		$this->add_control(
			'logo',
			array(
				'label'   => esc_html__( 'Logo', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => '' ),
			)
		);

		$menus        = wp_get_nav_menus();
		$menu_options = array( '' => esc_html__( '— Select Menu —', 'rozholy' ) );
		foreach ( $menus as $menu ) {
			$menu_options[ $menu->slug ] = $menu->name;
		}

		$this->add_control(
			'menu',
			array(
				'label'   => esc_html__( 'Navigation Menu', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $menu_options,
			)
		);

		$this->add_control(
			'show_search',
			array(
				'label'        => esc_html__( 'Show Search', 'rozholy' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'rozholy' ),
				'label_off'    => esc_html__( 'Hide', 'rozholy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$this->add_control(
				'show_cart',
				array(
					'label'        => esc_html__( 'Show Mini Cart', 'rozholy' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Show', 'rozholy' ),
					'label_off'    => esc_html__( 'Hide', 'rozholy' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);
		}

		$this->add_control(
			'show_account',
			array(
				'label'        => esc_html__( 'Show Account Link', 'rozholy' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'rozholy' ),
				'label_off'    => esc_html__( 'Hide', 'rozholy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
				'default'   => 'rgba(255,255,255,0.95)',
				'selectors' => array(
					'{{WRAPPER}} .rz-header' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'sticky_enabled',
			array(
				'label'        => esc_html__( 'Sticky Header', 'rozholy' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'sticky_bg',
			array(
				'label'     => esc_html__( 'Sticky Background', 'rozholy' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.92)',
				'condition' => array( 'sticky_enabled' => 'yes' ),
				'selectors' => array(
					'{{WRAPPER}} .rz-header.is-scrolled' => 'background: {{VALUE}}; backdrop-filter: blur(16px);',
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text / Link Color', 'rozholy' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4a4a4a',
				'selectors' => array(
					'{{WRAPPER}} .rz-header a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'rozholy' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d4a0a0',
				'selectors' => array(
					'{{WRAPPER}} .rz-header a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$s         = $this->get_settings_for_display();
		$menu_slug = $s['menu'] ?? '';
		$layout    = $s['layout'] ?? 'default';

		$classes = array( 'rz-header', 'rz-header--' . $layout );
		if ( 'yes' === ( $s['sticky_enabled'] ?? '' ) ) {
			$classes[] = 'rz-header-sticky';
		}
		?>
		<header class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" role="banner">
			<div class="rz-header-inner" style="display:flex;align-items:center;justify-content:space-between;max-width:1200px;margin:0 auto;padding:12px 20px;gap:20px;">
				<div class="rz-header-logo">
					<?php if ( ! empty( $s['logo']['url'] ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo esc_url( $s['logo']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="max-height:48px;width:auto;" />
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-size:1.4rem;font-weight:700;color:var(--rz-primary,#d4a0a0);text-decoration:none;">
							<?php bloginfo( 'name' ); ?>
						</a>
					<?php endif; ?>
				</div>
				<?php if ( $menu_slug && ( $menu_obj = wp_get_nav_menu_object( $menu_slug ) ) ) : ?>
					<nav class="rz-header-nav" style="display:flex;align-items:center;gap:8px;">
						<?php
						wp_nav_menu(
							array(
								'menu'        => $menu_obj,
								'container'   => false,
								'menu_class'  => 'rz-nav-menu',
								'fallback_cb' => false,
								'depth'       => 2,
								'echo'        => true,
							)
						);
						?>
					</nav>
				<?php endif; ?>
				<div class="rz-header-actions" style="display:flex;align-items:center;gap:12px;">
					<?php if ( 'yes' === ( $s['show_search'] ?? '' ) ) : ?>
						<button class="rz-search-toggle" aria-label="<?php esc_attr_e( 'Search', 'rozholy' ); ?>" style="background:none;border:none;cursor:pointer;font-size:1.2rem;">&#128269;</button>
					<?php endif; ?>
					<?php if ( 'yes' === ( $s['show_account'] ?? '' ) ) : ?>
						<a href="<?php echo esc_url( is_user_logged_in() ? get_permalink( get_page_by_path( 'dashboard' ) ) : wp_login_url() ); ?>" style="text-decoration:none;font-size:1.2rem;" aria-label="<?php esc_attr_e( 'My Account', 'rozholy' ); ?>">&#128100;</a>
					<?php endif; ?>
					<?php if ( class_exists( 'WooCommerce' ) && 'yes' === ( $s['show_cart'] ?? '' ) ) : ?>
						<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="rz-cart-icon" style="text-decoration:none;font-size:1.2rem;position:relative;" aria-label="<?php esc_attr_e( 'Cart', 'rozholy' ); ?>">
							&#128722;
							<span class="rz-cart-count" style="position:absolute;top:-6px;right:-8px;background:#d4a0a0;color:#fff;border-radius:50%;font-size:0.7rem;width:18px;height:18px;display:flex;align-items:center;justify-content:center;">
								<?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
							</span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</header>
		<?php if ( 'yes' === ( $s['sticky_enabled'] ?? '' ) ) : ?>
		<script>
		(function(){var h=document.querySelector('.rz-header-sticky');if(!h)return;var t=h.dataset.scrollThreshold||40;var ticking=false;window.addEventListener('scroll',function(){if(!ticking){window.requestAnimationFrame(function(){if(window.scrollY>t){h.classList.add('is-scrolled')}else{h.classList.remove('is-scrolled')}ticking=false});ticking=true}},{passive:true})})();
		</script>
			<?php
		endif;
	}
}
