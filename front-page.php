<?php
defined( 'ABSPATH' ) || exit;

get_header();

echo '<main class="rozholy-elementor-main">';
while ( have_posts() ) {
	the_post();
	the_content();
}
echo '</main>';

get_footer();
