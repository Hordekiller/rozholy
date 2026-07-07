<?php
defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'rozholy_add_settings_page' );
function rozholy_add_settings_page() {
	$page = add_theme_page(
		esc_html__( 'Rozholy Options', 'rozholy' ),
		esc_html__( 'Rozholy Options', 'rozholy' ),
		'edit_theme_options',
		'rozholy-options',
		'rozholy_render_settings_page'
	);
	add_action( 'admin_enqueue_scripts', 'rozholy_settings_page_assets' );
	add_action( 'load-' . $page, 'rozholy_settings_help_tab' );
}

function rozholy_settings_page_assets( $hook ) {
	if ( 'appearance_page_rozholy-options' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_media();
	wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
	wp_enqueue_style( 'rozholy-panel', ROZHOLY_URI . '/assets/admin/css/panel.css', array(), ROZHOLY_VERSION );
	wp_enqueue_script( 'rozholy-panel', ROZHOLY_URI . '/assets/admin/js/panel.js', array( 'wp-color-picker', 'media' ), ROZHOLY_VERSION, true );
}

function rozholy_settings_help_tab() {
	$screen = get_current_screen();
	if ( ! $screen ) {
		return;
	}
	$screen->add_help_tab(
		array(
			'id'      => 'rozholy-panel-help',
			'title'   => __( 'Overview', 'rozholy' ),
			'content' => '<p>' . __( 'Rozholy theme options let you customize colors, typography, layout, and more. Changes are stored in a single options array for performance.', 'rozholy' ) . '</p>'
				. '<p>' . __( 'Use the Import/Export section to back up or transfer settings between sites.', 'rozholy' ) . '</p>'
				. '<p>' . __( 'To add a new field: add a key + default to <code>rozholy_default_options()</code> in <code>inc/panel/defaults.php</code>, then add a manifest entry in <code>rozholy_option_manifest()</code> in <code>inc/panel/sanitize.php</code>.', 'rozholy' ) . '</p>',
		)
	);
}

function rozholy_render_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( __( 'Unauthorized.', 'rozholy' ) );
	}

	$active_tab = sanitize_key( $_GET['tab'] ?? 'colors' );
	$tabs       = array(
		'colors'     => __( 'Colors', 'rozholy' ),
		'typography' => __( 'Typography', 'rozholy' ),
		'header'     => __( 'Header', 'rozholy' ),
		'footer'     => __( 'Footer', 'rozholy' ),
		'social'     => __( 'Social', 'rozholy' ),
		'layout'     => __( 'Layout', 'rozholy' ),
		'homepage'   => __( 'Homepage', 'rozholy' ),
		'blog'       => __( 'Blog', 'rozholy' ),
		'buttons'    => __( 'Buttons', 'rozholy' ),
		'dashboard'  => __( 'Dashboard', 'rozholy' ),
		'motion'     => __( 'Motion', 'rozholy' ),
		'seo'        => __( 'SEO', 'rozholy' ),
		'advanced'   => __( 'Advanced', 'rozholy' ),
	);

	if ( ! isset( $tabs[ $active_tab ] ) ) {
		$active_tab = 'colors';
	}

	settings_errors( 'rozholy_options' );
	?>
	<div class="wrap rozholy-panel-wrap">
		<h1><?php esc_html_e( 'Rozholy Theme Options', 'rozholy' ); ?></h1>
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<a href="?page=rozholy-options&tab=<?php echo esc_attr( $key ); ?>"
					class="nav-tab<?php echo $active_tab === $key ? ' nav-tab-active' : ''; ?>"
					role="tab" aria-selected="<?php echo $active_tab === $key ? 'true' : 'false'; ?>">
					<?php echo esc_html( $label ); ?>
				</a>
			<?php endforeach; ?>
		</h2>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'rozholy_options_group' );
			do_settings_sections( 'rozholy_options_' . $active_tab );
			submit_button();
			?>
		</form>

		<?php rozholy_render_reset_section(); ?>
		<?php rozholy_render_import_export(); ?>
	</div>
	<?php
}

add_action( 'admin_init', 'rozholy_register_settings' );
function rozholy_register_settings() {
	register_setting(
		'rozholy_options_group',
		'rozholy_options',
		array(
			'sanitize_callback' => 'rozholy_sanitize_options',
			'default'           => rozholy_default_options(),
		)
	);

	$tabs = array(
		'colors'     => array(
			'primary_color'   => __( 'Primary Pink', 'rozholy' ),
			'primary_dark'    => __( 'Primary Dark', 'rozholy' ),
			'primary_light'   => __( 'Primary Light', 'rozholy' ),
			'secondary_color' => __( 'Secondary Purple', 'rozholy' ),
			'secondary_dark'  => __( 'Secondary Dark', 'rozholy' ),
			'accent_gold'     => __( 'Accent Gold', 'rozholy' ),
			'accent_light'    => __( 'Accent Light', 'rozholy' ),
			'base_bg'         => __( 'Base Background', 'rozholy' ),
			'base_alt'        => __( 'Base Alt', 'rozholy' ),
			'dark_color'      => __( 'Dark', 'rozholy' ),
			'text_color'      => __( 'Text Color', 'rozholy' ),
			'text_light'      => __( 'Text Light', 'rozholy' ),
			'border_color'    => __( 'Border Color', 'rozholy' ),
			'footer_bg'       => __( 'Footer Background', 'rozholy' ),
		),
		'typography' => array(
			'heading_font'   => __( 'Heading Font', 'rozholy' ),
			'body_font'      => __( 'Body Font', 'rozholy' ),
			'base_font_size' => __( 'Base Font Size (px)', 'rozholy' ),
			'heading_weight' => __( 'Heading Weight', 'rozholy' ),
		),
		'header'     => array(
			'header_layout'   => __( 'Header Layout', 'rozholy' ),
			'sticky_header'   => __( 'Sticky Header', 'rozholy' ),
			'header_cta_text' => __( 'CTA Button Text', 'rozholy' ),
			'header_cta_url'  => __( 'CTA Button URL', 'rozholy' ),
			'header_search'   => __( 'Show Search', 'rozholy' ),
		),
		'footer'     => array(
			'footer_layout' => __( 'Footer Columns', 'rozholy' ),
			'footer_text'   => __( 'Copyright Text', 'rozholy' ),
			'footer_social' => __( 'Show Social Icons', 'rozholy' ),
			'footer_bg'     => __( 'Footer Background', 'rozholy' ),
		),
		'social'     => array(
			'social_instagram' => 'Instagram',
			'social_telegram'  => 'Telegram',
			'social_whatsapp'  => 'WhatsApp',
			'social_youtube'   => 'YouTube',
			'social_facebook'  => 'Facebook',
			'social_twitter'   => 'Twitter / X',
			'social_linkedin'  => 'LinkedIn',
			'social_pinterest' => 'Pinterest',
		),
		'layout'     => array(
			'content_width'     => __( 'Content Width (px)', 'rozholy' ),
			'wide_width'        => __( 'Wide Width (px)', 'rozholy' ),
			'blog_columns'      => __( 'Blog Columns', 'rozholy' ),
			'shop_columns'      => __( 'Shop Columns', 'rozholy' ),
			'products_per_page' => __( 'Products Per Page', 'rozholy' ),
		),
		'homepage'   => array(
			'show_hero'         => __( 'Show Hero', 'rozholy' ),
			'show_services'     => __( 'Show Services', 'rozholy' ),
			'show_testimonials' => __( 'Show Testimonials', 'rozholy' ),
			'show_gallery'      => __( 'Show Gallery', 'rozholy' ),
			'show_booking'      => __( 'Show Booking', 'rozholy' ),
			'show_contact'      => __( 'Show Contact', 'rozholy' ),
		),
		'blog'       => array(
			'excerpt_length'  => __( 'Excerpt Length', 'rozholy' ),
			'show_author'     => __( 'Show Author', 'rozholy' ),
			'show_date'       => __( 'Show Date', 'rozholy' ),
			'show_categories' => __( 'Show Categories', 'rozholy' ),
			'show_tags'       => __( 'Show Tags', 'rozholy' ),
			'show_thumb'      => __( 'Show Featured Image', 'rozholy' ),
			'show_comments'   => __( 'Show Comments', 'rozholy' ),
		),
		'buttons'    => array(
			'button_radius' => __( 'Button Radius (px)', 'rozholy' ),
			'button_hover'  => __( 'Hover Effect', 'rozholy' ),
		),
		'dashboard'  => array(
			'dashboard_page' => __( 'Dashboard Page', 'rozholy' ),
			'avatar_size'    => __( 'Avatar Size (px)', 'rozholy' ),
		),
		'motion'     => array(
			'motion_intensity' => __( 'Motion Intensity', 'rozholy' ),
			'parallax'         => __( 'Parallax', 'rozholy' ),
		),
		'seo'        => array(
			'persian_slugs'        => __( 'Persian Slug Conversion', 'rozholy' ),
			'seo_business_name'    => __( 'Business Name', 'rozholy' ),
			'seo_business_address' => __( 'Business Address', 'rozholy' ),
			'seo_business_phone'   => __( 'Business Phone (+98...)', 'rozholy' ),
			'seo_enamad_code'      => __( 'Enamad Trust Logo', 'rozholy' ),
		),
		'advanced'   => array(
			'custom_css'     => __( 'Custom CSS', 'rozholy' ),
			'header_scripts' => __( 'Header Scripts', 'rozholy' ),
			'footer_scripts' => __( 'Footer Scripts', 'rozholy' ),
		),
	);

	foreach ( $tabs as $tab_key => $fields ) {
		add_settings_section(
			'rozholy_options_section_' . $tab_key,
			'',
			'__return_empty_string',
			'rozholy_options_' . $tab_key
		);
		foreach ( $fields as $field_key => $label ) {
			add_settings_field(
				$field_key,
				$label,
				'rozholy_render_field',
				'rozholy_options_' . $tab_key,
				'rozholy_options_section_' . $tab_key,
				array(
					'key'   => $field_key,
					'label' => $label,
				)
			);
		}
	}
}

function rozholy_render_field( array $args ) {
	$key      = $args['key'];
	$value    = rozholy_get_option( $key );
	$manifest = rozholy_option_manifest();
	$rule     = $manifest[ $key ] ?? array( 'type' => 'text' );
	$name     = 'rozholy_options[' . $key . ']';

	switch ( $rule['type'] ) {
		case 'color':
			printf(
				'<input type="text" name="%s" value="%s" class="rozholy-color-picker" data-default-color="%s">',
				esc_attr( $name ),
				esc_attr( $value ),
				esc_attr( $rule['default'] ?? '' )
			);
			break;
		case 'select':
			$choices = $rule['choices'];
			echo '<select name="' . esc_attr( $name ) . '">';
			foreach ( $choices as $val => $label ) {
				printf(
					'<option value="%s" %s>%s</option>',
					esc_attr( $val ),
					selected( $value, $val, false ),
					esc_html( is_numeric( $label ) ? $val : $label )
				);
			}
			echo '</select>';
			break;
		case 'checkbox':
			printf(
				'<label><input type="checkbox" name="%s" value="1" %s> %s</label>',
				esc_attr( $name ),
				checked( $value, '1', false ),
				esc_html( $rule['checkbox_label'] ?? '' )
			);
			break;
		case 'number':
			$min = $rule['min'] ?? 0;
			$max = $rule['max'] ?? 9999;
			printf(
				'<input type="number" name="%s" value="%s" min="%d" max="%d" step="1" style="width:100px">',
				esc_attr( $name ),
				esc_attr( $value ),
				$min,
				$max
			);
			break;
		case 'url':
			printf(
				'<input type="url" name="%s" value="%s" class="regular-text">',
				esc_attr( $name ),
				esc_attr( $value )
			);
			break;
		case 'html':
			printf(
				'<textarea name="%s" rows="3" class="large-text">%s</textarea>',
				esc_attr( $name ),
				esc_textarea( $value )
			);
			break;
		case 'css':
			printf(
				'<textarea name="%s" rows="6" class="large-text code" style="font-family:monospace;direction:ltr">%s</textarea>',
				esc_attr( $name ),
				esc_textarea( $value )
			);
			break;
		case 'scripts':
			printf(
				'<textarea name="%s" rows="6" class="large-text code" style="font-family:monospace;direction:ltr">%s</textarea>',
				esc_attr( $name ),
				esc_textarea( $value )
			);
			break;
		case 'image':
			$img_url    = $value ? wp_get_attachment_image_url( $value, 'thumbnail' ) : '';
			$preview_id = 'rozholy-img-preview-' . $key;
			?>
			<input type="hidden" name="<?php echo esc_attr( $name ); ?>" id="rozholy-img-<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>">
			<div id="<?php echo esc_attr( $preview_id ); ?>" class="rozholy-image-preview">
				<?php if ( $img_url ) : ?>
					<img src="<?php echo esc_url( $img_url ); ?>" alt="">
				<?php endif; ?>
			</div>
			<button type="button" class="button rozholy-upload-image"
					data-target="rozholy-img-<?php echo esc_attr( $key ); ?>"
					data-preview="<?php echo esc_attr( $preview_id ); ?>"
					data-title="<?php esc_attr_e( 'Select Image', 'rozholy' ); ?>"
					data-button="<?php esc_attr_e( 'Use Image', 'rozholy' ); ?>">
				<?php esc_html_e( 'Choose Image', 'rozholy' ); ?>
			</button>
			<button type="button" class="button rozholy-remove-image"
					data-target="rozholy-img-<?php echo esc_attr( $key ); ?>"
					data-preview="<?php echo esc_attr( $preview_id ); ?>">
				<?php esc_html_e( 'Remove', 'rozholy' ); ?>
			</button>
			<?php
			break;
		default:
			printf(
				'<input type="text" name="%s" value="%s" class="regular-text">',
				esc_attr( $name ),
				esc_attr( $value )
			);
	}
}

add_action( 'admin_post_rozholy_reset_options', 'rozholy_handle_reset' );
function rozholy_handle_reset() {
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ?? '' ) ), 'rozholy_reset' ) ) {
		wp_die( __( 'Security check failed.', 'rozholy' ) );
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( __( 'Unauthorized.', 'rozholy' ) );
	}
	delete_option( 'rozholy_options' );
	wp_safe_redirect(
		add_query_arg(
			array(
				'page'  => 'rozholy-options',
				'reset' => '1',
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}

add_action( 'admin_notices', 'rozholy_panel_notices' );
function rozholy_panel_notices() {
	if ( ! empty( $_GET['reset'] ) ) {
		echo '<div class="notice notice-warning is-dismissible"><p>' . esc_html__( 'Options reset to defaults.', 'rozholy' ) . '</p></div>';
	}
	if ( ! empty( $_GET['imported'] ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Options imported successfully.', 'rozholy' ) . '</p></div>';
	}
	if ( ! empty( $_GET['preset'] ) ) {
		$name_raw = isset( $_GET['preset_name'] ) ? sanitize_text_field( wp_unslash( $_GET['preset_name'] ) ) : '';
		$name     = $name_raw ? esc_html( ucfirst( str_replace( array( '-', '_' ), ' ', $name_raw ) ) ) : '';
		echo '<div class="notice notice-success is-dismissible"><p>' . sprintf( esc_html__( 'Preset "%s" applied.', 'rozholy' ), $name ) . '</p></div>';
	}
}

function rozholy_render_reset_section() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div class="rozholy-reset-section">
		<h2><?php esc_html_e( 'Reset to Defaults', 'rozholy' ); ?></h2>
		<p class="description"><?php esc_html_e( 'This will delete all saved options and restore factory defaults. This action cannot be undone.', 'rozholy' ); ?></p>
		<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=rozholy_reset_options' ), 'rozholy_reset' ) ); ?>"
			class="button button-secondary"
			onclick="return confirm('<?php echo esc_js( __( 'Are you sure? All settings will be lost.', 'rozholy' ) ); ?>')">
			<?php esc_html_e( 'Reset to Defaults', 'rozholy' ); ?>
		</a>
	</div>
	<?php
}
