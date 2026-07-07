<?php
defined( 'ABSPATH' ) || exit;

/* ── Get social links from Customizer ── */
function rozholy_get_social_links() {
	$socials = array( 'instagram', 'telegram', 'whatsapp', 'youtube', 'facebook', 'twitter', 'linkedin', 'pinterest' );
	$links   = array();

	foreach ( $socials as $key ) {
		$url = rozholy_get_option( "social_{$key}" );
		if ( ! empty( $url ) ) {
			$links[ $key ] = $url;
		}
	}

	return $links;
}

/* ── Get header layout class ── */
function rozholy_header_class() {
	$layout  = rozholy_get_option( 'header_layout' );
	$sticky  = rozholy_get_option( 'sticky_header' );
	$classes = $layout === 'transparent' ? 'site-header--transparent' : '';
	if ( $sticky === 'off' ) {
		$classes .= ' site-header--no-sticky';
	}
	return trim( $classes );
}

/* ── Pagination helper ── */
function rozholy_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
		)
	);
}

/* ── Excerpt length from Customizer ── */
add_filter( 'excerpt_length', 'rozholy_excerpt_length' );
function rozholy_excerpt_length( $length ) {
	return rozholy_get_option( 'excerpt_length' );
}

/* ── Excerpt more ── */
add_filter( 'excerpt_more', 'rozholy_excerpt_more' );
function rozholy_excerpt_more( $more ) {
	return '...';
}

/* ── Body classes ── */
add_filter( 'body_class', 'rozholy_body_classes' );
function rozholy_body_classes( $classes ) {
	if ( is_rtl() ) {
		$classes[] = 'rtl';
	}

	$motion = rozholy_get_option( 'motion_intensity' );
	if ( $motion !== 'full' ) {
		$classes[] = 'motion-' . $motion;
	}

	$parallax = rozholy_get_option( 'parallax' );
	if ( $parallax === 'off' ) {
		$classes[] = 'parallax-off';
	}

	$sticky = rozholy_get_option( 'sticky_header' );
	if ( $sticky === 'off' ) {
		$classes[] = 'no-sticky-header';
	}

	return $classes;
}

/* ── Header scripts output ── */
add_action( 'wp_head', 'rozholy_header_scripts', 101 );
function rozholy_header_scripts() {
	$scripts = rozholy_get_option( 'header_scripts' );
	if ( ! empty( $scripts ) ) {
		echo wp_kses( $scripts, rozholy_allowed_script_tags() ) . "\n";
	}
}

/* ── Breadcrumb trail ── */
function rozholy_breadcrumb( bool $output = true ): array {
	$items = array();

	if ( is_front_page() ) {
		$items[] = array(
			'text' => __( 'Home', 'rozholy' ),
			'url'  => home_url( '/' ),
		);
		if ( ! $output ) {
			return $items;
		}
		echo '<nav aria-label="' . esc_attr__( 'Breadcrumb', 'rozholy' ) . '" class="rozholy-breadcrumb">';
		echo '<span><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'rozholy' ) . '</a></span>';
		echo '</nav>';
		return $items;
	}

	$items[] = array(
		'text' => __( 'Home', 'rozholy' ),
		'url'  => home_url( '/' ),
	);

	if ( is_category() ) {
		$cat     = get_queried_object();
		$items[] = array( 'text' => $cat->name );
	} elseif ( is_singular() ) {
		$post_type = get_post_type_object( get_post_type() );
		if ( $post_type && $post_type->has_archive && $post_type->rewrite ) {
			$items[] = array(
				'text' => $post_type->labels->name,
				'url'  => get_post_type_archive_link( get_post_type() ),
			);
		}
		$items[] = array( 'text' => get_the_title() );
	} elseif ( is_page() ) {
		$items[] = array( 'text' => get_the_title() );
	} elseif ( is_search() ) {
		$items[] = array( 'text' => sprintf( __( 'Search: %s', 'rozholy' ), get_search_query() ) );
	} elseif ( is_404() ) {
		$items[] = array( 'text' => __( 'Page not found', 'rozholy' ) );
	}

	if ( $output ) {
		echo '<nav aria-label="' . esc_attr__( 'Breadcrumb', 'rozholy' ) . '" class="rozholy-breadcrumb">';
		$count = count( $items );
		foreach ( $items as $i => $item ) {
			if ( $i < $count - 1 && ! empty( $item['url'] ) ) {
				echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['text'] ) . '</a>';
				echo ' / ';
			} else {
				echo '<span class="current">' . esc_html( $item['text'] ) . '</span>';
			}
		}
		echo '</nav>';
	}

	return $items;
}

/* ── Enamad logo output ── */
add_action( 'wp_footer', 'rozholy_output_enamad', 50 );
function rozholy_output_enamad(): void {
	$code = rozholy_get_option( 'seo_enamad_code' );
	if ( empty( $code ) ) {
		return;
	}
	echo '<div id="rozholy-enamad" style="text-align:center;padding:10px 0;font-size:0">';
	echo wp_kses(
		$code,
		array(
			'img' => array(
				'src'    => array(),
				'alt'    => array(),
				'width'  => array(),
				'height' => array(),
				'dir'    => array(),
				'lang'   => array(),
			),
			'a'   => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
				'dir'   => array(),
				'lang'  => array(),
			),
		)
	);
	echo '</div>';
}

/* ── Footer scripts output ── */
add_action( 'wp_footer', 'rozholy_footer_scripts', 100 );
function rozholy_footer_scripts() {
	$scripts = rozholy_get_option( 'footer_scripts' );
	if ( ! empty( $scripts ) ) {
		echo wp_kses( $scripts, rozholy_allowed_script_tags() ) . "\n";
	}
}

function rozholy_allowed_script_tags(): array {
	return array(
		'script'   => array(
			'src'   => array(),
			'async' => array(),
			'defer' => array(),
			'type'  => array(),
		),
		'meta'     => array(
			'name'     => array(),
			'content'  => array(),
			'property' => array(),
			'charset'  => array(),
		),
		'link'     => array(
			'href'        => array(),
			'rel'         => array(),
			'type'        => array(),
			'media'       => array(),
			'crossorigin' => array(),
		),
		'noscript' => array(),
		'style'    => array( 'type' => array() ),
		'iframe'   => array(
			'src'     => array(),
			'width'   => array(),
			'height'  => array(),
			'style'   => array(),
			'allow'   => array(),
			'loading' => array(),
		),
	);
}
