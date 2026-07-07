<?php
/**
 * Template Name: Dashboard
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_user_logged_in() ) {
	wp_safe_redirect( wp_login_url( get_permalink() ) );
	exit;
}

get_header();

$current_tab  = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'profile';
$allowed_tabs = array( 'profile', 'security', 'activity' );
if ( ! in_array( $current_tab, $allowed_tabs, true ) ) {
	$current_tab = 'profile';
}

$user = wp_get_current_user();
?>

<div class="dashboard-wrap">
	<div class="dashboard-sidebar">
		<?php get_template_part( 'template-parts/dashboard/sidebar' ); ?>
	</div>

	<div class="dashboard-content">
		<div class="dashboard-content__header">
			<h1 class="dashboard-content__title">
				<?php echo esc_html__( 'داشبورد کاربری', 'rozholy' ); ?>
			</h1>
			<p class="dashboard-content__greeting">
				<?php
				printf(
					esc_html__( 'خوش آمدید، %s', 'rozholy' ),
					esc_html( $user->display_name )
				);
				?>
			</p>
		</div>

		<?php
		if ( isset( $_GET['updated'] ) ) {
			echo '<div class="dashboard-notice dashboard-notice--success">' . esc_html__( 'پروفایل با موفقیت به‌روزرسانی شد.', 'rozholy' ) . '</div>';
		}

		if ( isset( $_GET['error'] ) ) {
			$error_messages = array(
				'wrong_password'    => __( 'رمز عبور فعلی اشتباه است.', 'rozholy' ),
				'password_mismatch' => __( 'رمز عبور جدید و تکرار آن مطابقت ندارند.', 'rozholy' ),
			);
			$error_key      = sanitize_key( $_GET['error'] );
			$error_msg      = isset( $error_messages[ $error_key ] ) ? $error_messages[ $error_key ] : __( 'خطایی رخ داده است.', 'rozholy' );
			echo '<div class="dashboard-notice dashboard-notice--error">' . esc_html( $error_msg ) . '</div>';
		}

		get_template_part( 'template-parts/dashboard/' . $current_tab );
		?>
	</div>
</div>

<?php
get_footer();
