<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="rz-main-content rz-section">
	<div class="rz-container">
		<header class="rz-search-header">
			<h1 class="rz-search-title"><?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'نتیجه جستجو برای: %s', 'rozholy' ),
					'<span>' . get_search_query() . '</span>'
				);
			?></h1>
		</header>
		<?php if ( have_posts() ) : ?>
			<div class="rz-search-results">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'rz-search-item' ); ?>>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="rz-search-excerpt"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'نتیجه‌ای یافت نشد. لطفاً با عبارت دیگری جستجو کنید.', 'rozholy' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
