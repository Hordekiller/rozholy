<?php
defined( 'ABSPATH' ) || exit;

if ( rozholy_is_elementor() ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
} else {
	while ( have_posts() ) {
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	}
}
