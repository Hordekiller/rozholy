<?php
/**
 * Template Name: Elementor Canvas
 * Description: Blank page for Elementor — no header or footer.
 */

defined('ABSPATH') || exit;

if (! defined('ELEMENTOR_VERSION')) {
    wp_safe_redirect(get_permalink());
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('elementor-canvas'); ?>>
<?php wp_body_open(); ?>

<?php
do_action('elementor/page_templates/canvas/before_content');

while (have_posts()) {
    the_post();
    the_content();
}

do_action('elementor/page_templates/canvas/after_content');

wp_footer();
?>
</body>
</html>
