<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="rz-main-content rz-section">
	<div class="rz-container">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
