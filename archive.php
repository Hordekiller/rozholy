<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="rz-main-content rz-section">
	<div class="rz-container">
		<header class="rz-archive-header">
			<?php
			the_archive_title( '<h1 class="rz-archive-title">', '</h1>' );
			the_archive_description( '<div class="rz-archive-desc">', '</div>' );
			?>
		</header>
		<?php if ( have_posts() ) : ?>
			<div class="rz-archive-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'rz-archive-item' ); ?>>
						<h2 class="rz-archive-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="rz-archive-item-excerpt"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'محتوایی یافت نشد.', 'rozholy' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
