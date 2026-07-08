<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="rz-main-content rz-section woocommerce-page">
	<div class="rz-container">
		<?php woocommerce_content(); ?>
	</div>
</main>
<?php
get_footer();
