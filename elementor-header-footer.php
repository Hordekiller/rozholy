<?php
/**
 * Template Name: Elementor Full Width
 * Description: Full-width page with theme header/footer, optimized for Elementor.
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="rozholy-elementor-main">
    <?php
    while (have_posts()) {
        the_post();
        the_content();
    }
    ?>
</main>

<?php
get_footer();
