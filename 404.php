<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="rz-main-content rz-section rz-error-page">
	<div class="rz-container" style="text-align:center;padding:80px 20px;">
		<h1 style="font-size:4rem;margin:0 0 16px;color:var(--rz-primary-color,#d4a0a0);">404</h1>
		<p style="font-size:1.1rem;color:#6b7280;margin:0 0 24px;"><?php esc_html_e( 'صفحه مورد نظر شما یافت نشد.', 'rozholy' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rz-btn rz-btn-primary" style="display:inline-block;padding:12px 32px;background:var(--rz-primary-color,#d4a0a0);color:#fff;border-radius:999px;text-decoration:none;font-weight:600;"><?php esc_html_e( 'بازگشت به صفحه اصلی', 'rozholy' ); ?></a>
	</div>
</main>
<?php
get_footer();
