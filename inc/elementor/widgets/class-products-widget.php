<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

class Rozholy_Products_Widget extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'rozholy_products'; }
	public function get_title(): string {
		return esc_html__( 'Rozholy Products Grid', 'rozholy' ); }
	public function get_icon(): string {
		return 'eicon-products'; }
	public function get_categories(): array {
		return array( 'rozholy' ); }
	public function get_keywords(): array {
		return array( 'products', 'shop', 'woocommerce', 'grid' ); }

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
				'default' => esc_html__( 'Our Products', 'rozholy' ),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
			)
		);

		$this->add_control(
			'count',
			array(
				'label'   => esc_html__( 'Number of Products', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
			)
		);

		$categories  = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			)
		);
		$cat_options = array( '' => esc_html__( 'All Categories', 'rozholy' ) );
		foreach ( $categories as $cat ) {
			$cat_options[ $cat->slug ] = $cat->name;
		}

		$this->add_control(
			'category',
			array(
				'label'   => esc_html__( 'Category', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $cat_options,
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'       => esc_html__( 'Date (Newest)', 'rozholy' ),
					'price'      => esc_html__( 'Price', 'rozholy' ),
					'popularity' => esc_html__( 'Popularity', 'rozholy' ),
					'rating'     => esc_html__( 'Rating', 'rozholy' ),
					'title'      => esc_html__( 'Title', 'rozholy' ),
					'rand'       => esc_html__( 'Random', 'rozholy' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'rozholy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array(
					'ASC'  => esc_html__( 'Ascending', 'rozholy' ),
					'DESC' => esc_html__( 'Descending', 'rozholy' ),
				),
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
			'heading_color',
			array(
				'label'     => esc_html__( 'Title Color', 'rozholy' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2d2d2d',
				'selectors' => array( '{{WRAPPER}} .rz-products-title' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Card Border Radius', 'rozholy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} .rz-product-card'     => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rz-product-card img' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0;',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$s = $this->get_settings_for_display();

		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => (int) ( $s['count'] ?: 8 ),
			'orderby'        => $s['orderby'] ?? 'date',
			'order'          => ( $s['order'] ?? 'DESC' ) === 'ASC' ? 'ASC' : 'DESC',
		);

		if ( ! empty( $s['category'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $s['category'] ),
				),
			);
		}

		if ( $s['orderby'] === 'popularity' ) {
			$args['meta_key'] = 'total_sales';
			$args['orderby']  = 'meta_value_num';
		} elseif ( $s['orderby'] === 'rating' ) {
			$args['meta_key'] = '_wc_average_rating';
			$args['orderby']  = 'meta_value_num';
		}

		$query = new WP_Query( $args );
		$cols  = (int) ( $s['columns'] ?: 4 );

		if ( $s['title'] ) : ?>
			<h2 class="rz-products-title" style="text-align:center;font-size:2rem;margin-bottom:40px;"><?php echo esc_html( $s['title'] ); ?></h2>
		<?php endif; ?>

		<div class="rz-products-grid" style="display:grid;grid-template-columns:repeat(<?php echo $cols; ?>,1fr);gap:24px;">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				global $product;
				?>
				<div class="rz-product-card" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:transform 0.3s,box-shadow 0.3s;">
					<a href="<?php the_permalink(); ?>" style="display:block;text-decoration:none;color:inherit;">
						<?php if ( has_post_thumbnail() ) : ?>
							<div style="overflow:hidden;"><?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:240px;object-fit:cover;transition:transform 0.3s;display:block;' ) ); ?></div>
						<?php endif; ?>
						<div style="padding:16px 20px 20px;">
							<h3 style="margin:0 0 4px;font-size:1rem;font-weight:600;color:#2d2d2d;"><?php the_title(); ?></h3>
							<?php if ( $product && $product->is_type( 'simple' ) ) : ?>
								<div style="font-size:1.1rem;font-weight:700;color:#d4a0a0;margin-bottom:12px;"><?php echo $product->get_price_html(); ?></div>
							<?php endif; ?>
							<a href="<?php echo esc_url( $product ? $product->add_to_cart_url() : '#' ); ?>" class="button rz-add-to-cart" data-product_id="<?php echo esc_attr( $product ? $product->get_id() : 0 ); ?>" style="display:inline-block;padding:10px 24px;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#c08080);color:#fff;text-decoration:none;font-size:0.85rem;font-weight:600;border:none;cursor:pointer;">
								<?php esc_html_e( 'Add to Cart', 'rozholy' ); ?>
							</a>
						</div>
					</a>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<?php
	}
}
