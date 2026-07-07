<?php
defined( 'ABSPATH' ) || exit;

add_action( 'admin_post_rozholy_export_options', 'rozholy_handle_export' );
add_action( 'admin_post_rozholy_import_options', 'rozholy_handle_import' );

function rozholy_handle_export() {
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ?? '' ) ), 'rozholy_export' ) ) {
		wp_die( __( 'Security check failed.', 'rozholy' ) );
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( __( 'Unauthorized.', 'rozholy' ) );
	}

	$options = rozholy_get_all_options();
	$export  = array(
		'rozholy_options' => $options,
		'version'         => $options['schema_version'],
		'date'            => current_time( 'mysql' ),
		'site'            => home_url(),
	);

	$filename = 'rozholy-options-' . date( 'Y-m-d' ) . '.json';
	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	echo wp_json_encode( $export, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	exit;
}

function rozholy_handle_import() {
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ?? '' ) ), 'rozholy_import' ) ) {
		wp_die( __( 'Security check failed.', 'rozholy' ) );
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( __( 'Unauthorized.', 'rozholy' ) );
	}

	if ( ! isset( $_FILES['rozholy_import_file'] ) || UPLOAD_ERR_OK !== $_FILES['rozholy_import_file']['error'] ) {
		wp_die( __( 'File upload error.', 'rozholy' ) );
	}

	$tmp_name = sanitize_text_field( wp_unslash( $_FILES['rozholy_import_file']['tmp_name'] ) );
	$contents = file_get_contents( $tmp_name );
	$data     = json_decode( $contents, true );

	if ( empty( $data['rozholy_options'] ) || ! is_array( $data['rozholy_options'] ) ) {
		wp_die( __( 'Invalid import file.', 'rozholy' ) );
	}

	$sanitized = rozholy_sanitize_options( $data['rozholy_options'] );
	update_option( 'rozholy_options', $sanitized );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'     => 'rozholy-options',
				'imported' => '1',
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}

function rozholy_render_import_export() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<hr style="margin:30px 0">
	<h2><?php esc_html_e( 'Import / Export', 'rozholy' ); ?></h2>
	<table class="form-table" role="presentation">
		<tr>
			<th scope="row"><?php esc_html_e( 'Export', 'rozholy' ); ?></th>
			<td>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=rozholy_export_options' ), 'rozholy_export' ) ); ?>"
					class="button button-secondary">
					<?php esc_html_e( 'Download JSON', 'rozholy' ); ?>
				</a>
				<p class="description"><?php esc_html_e( 'Downloads all options as a JSON file for backup.', 'rozholy' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Import', 'rozholy' ); ?></th>
			<td>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
					<?php wp_nonce_field( 'rozholy_import' ); ?>
					<input type="hidden" name="action" value="rozholy_import_options">
					<input type="file" name="rozholy_import_file" accept=".json" required>
					<?php submit_button( __( 'Import JSON', 'rozholy' ), 'secondary', 'submit', false ); ?>
					<p class="description"><?php esc_html_e( 'Upload a previously exported JSON file.', 'rozholy' ); ?></p>
				</form>
			</td>
		</tr>
	</table>
	<?php rozholy_render_presets(); ?>
	<?php
}

function rozholy_render_presets() {
	$presets_dir = ROZHOLY_DIR . '/assets/presets';
	if ( ! is_dir( $presets_dir ) ) {
		return;
	}
	$presets = glob( $presets_dir . '/*.json' );
	if ( empty( $presets ) ) {
		return;
	}
	?>
	<h3><?php esc_html_e( 'Demo Presets', 'rozholy' ); ?></h3>
	<p class="description"><?php esc_html_e( 'Apply a pre-built configuration preset.', 'rozholy' ); ?></p>
	<?php foreach ( $presets as $preset_path ) : ?>
		<?php
		$name      = pathinfo( $preset_path, PATHINFO_FILENAME );
		$label     = ucfirst( str_replace( array( '-', '_' ), ' ', $name ) );
		$nonce_url = wp_nonce_url(
			admin_url( 'admin-post.php?action=rozholy_apply_preset&preset=' . urlencode( $name ) ),
			'rozholy_apply_preset_' . $name
		);
		?>
		<span class="rozholy-preset-label">
			<a href="<?php echo esc_url( $nonce_url ); ?>"
				class="button button-secondary button-small"
				onclick="return confirm('<?php echo esc_js( sprintf( __( 'Apply the "%s" preset? Current settings will be overwritten.', 'rozholy' ), $label ) ); ?>')">
				<?php echo esc_html( $label ); ?>
			</a>
		</span>
	<?php endforeach; ?>
	<?php
}

add_action( 'admin_post_rozholy_apply_preset', 'rozholy_handle_apply_preset' );
function rozholy_handle_apply_preset() {
	$preset_name = basename( sanitize_file_name( wp_unslash( $_GET['preset'] ?? '' ) ) );
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ?? '' ) ), 'rozholy_apply_preset_' . $preset_name ) ) {
		wp_die( __( 'Security check failed.', 'rozholy' ) );
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( __( 'Unauthorized.', 'rozholy' ) );
	}

	$preset_file = ROZHOLY_DIR . '/assets/presets/' . $preset_name . '.json';
	if ( ! file_exists( $preset_file ) ) {
		wp_die( __( 'Preset not found.', 'rozholy' ) );
	}

	$contents = file_get_contents( $preset_file );
	$data     = json_decode( $contents, true );
	if ( empty( $data['rozholy_options'] ) || ! is_array( $data['rozholy_options'] ) ) {
		wp_die( __( 'Invalid preset file.', 'rozholy' ) );
	}

	$sanitized                   = rozholy_sanitize_options( $data['rozholy_options'] );
	$sanitized['schema_version'] = rozholy_default_options()['schema_version'];
	update_option( 'rozholy_options', $sanitized );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'        => 'rozholy-options',
				'preset'      => '1',
				'preset_name' => rawurlencode( $preset_name ),
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}
