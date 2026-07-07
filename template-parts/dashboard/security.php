<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="dashboard-card">
	<div class="dashboard-card__header">
		<h2><?php echo esc_html__( 'تغییر رمز عبور', 'rozholy' ); ?></h2>
	</div>

	<div class="dashboard-card__body">
		<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="dashboard-form">
			<?php wp_nonce_field( 'rozholy_change_password' ); ?>
			<input type="hidden" name="action" value="rozholy_change_password">

			<div class="dashboard-form__field">
				<label for="current_password"><?php echo esc_html__( 'رمز عبور فعلی', 'rozholy' ); ?></label>
				<input type="password" id="current_password" name="current_password" required>
			</div>

			<div class="dashboard-form__field">
				<label for="new_password"><?php echo esc_html__( 'رمز عبور جدید', 'rozholy' ); ?></label>
				<input type="password" id="new_password" name="new_password" minlength="8" required>
				<p class="dashboard-form__hint"><?php echo esc_html__( 'حداقل ۸ کاراکتر', 'rozholy' ); ?></p>
			</div>

			<div class="dashboard-form__field">
				<label for="confirm_password"><?php echo esc_html__( 'تکرار رمز عبور جدید', 'rozholy' ); ?></label>
				<input type="password" id="confirm_password" name="confirm_password" minlength="8" required>
			</div>

			<div class="dashboard-form__actions">
				<button type="submit" class="dashboard-btn dashboard-btn--primary">
					<?php echo esc_html__( 'تغییر رمز عبور', 'rozholy' ); ?>
				</button>
			</div>
		</form>
	</div>
</div>
