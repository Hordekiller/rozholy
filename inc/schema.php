<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'rozholy_output_schema', 20 );
function rozholy_output_schema(): void {
	if ( rozholy_seo_plugin_active() ) {
		return;
	}

	$schema = array();

	if ( is_front_page() || is_home() ) {
		$org = rozholy_get_organization_schema();
		if ( $org ) {
			$schema[] = $org;
		}

		$schema[] = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'WebSite',
			'name'            => get_bloginfo( 'name' ),
			'url'             => home_url( '/' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);
	}

	if ( is_singular( 'post' ) ) {
		$schema[] = rozholy_get_article_schema();
	}

	$breadcrumb = rozholy_get_breadcrumb_schema();
	if ( $breadcrumb ) {
		$schema[] = $breadcrumb;
	}

	$local_biz = rozholy_get_local_business_schema();
	if ( $local_biz ) {
		$schema[] = $local_biz;
	}

	if ( empty( $schema ) ) {
		return;
	}

	echo '<script type="application/ld+json">' . "\n";
	echo wp_json_encode( count( $schema ) === 1 ? $schema[0] : $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR ) . "\n";
	echo "</script>\n";
}

function rozholy_seo_plugin_active(): bool {
	return defined( 'WPSEO_VERSION' )
		|| class_exists( 'RankMath' )
		|| defined( 'THE_SE_FRAMEWORK_VERSION' )
		|| class_exists( 'All_in_One_SEO_Pack' );
}

function rozholy_get_organization_schema(): ?array {
	$logo_id  = get_theme_mod( 'custom_logo' );
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';

	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
	);

	if ( $logo_url ) {
		$schema['logo'] = $logo_url;
	}

	return $schema;
}

function rozholy_get_article_schema(): array {
	$post   = get_post();
	$author = get_userdata( $post->post_author );

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'Article',
		'headline'      => get_the_title( $post ),
		'datePublished' => get_the_date( 'c', $post ),
		'dateModified'  => get_the_modified_date( 'c', $post ),
		'author'        => array(
			'@type' => 'Person',
			'name'  => $author ? $author->display_name : '',
		),
		'publisher'     => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
		),
	);

	if ( has_post_thumbnail( $post ) ) {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'full' );
		if ( $thumbnail ) {
			$schema['image'] = array(
				'@type'  => 'ImageObject',
				'url'    => $thumbnail[0],
				'width'  => $thumbnail[1],
				'height' => $thumbnail[2],
			);
		}
	}

	$schema['mainEntityOfPage'] = array(
		'@type' => 'WebPage',
		'@id'   => get_permalink( $post ),
	);

	return $schema;
}

function rozholy_get_breadcrumb_schema(): ?array {
	if ( ! function_exists( 'rozholy_breadcrumb' ) ) {
		return null;
	}

	$items = rozholy_breadcrumb( false );
	if ( empty( $items ) ) {
		return null;
	}

	$item_list = array();
	$position  = 1;

	foreach ( $items as $crumb ) {
		$item_list[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => $crumb['text'],
			'item'     => $crumb['url'] ?? '',
		);
		++$position;
	}

	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $item_list,
	);
}

function rozholy_get_local_business_schema(): ?array {
	$o = rozholy_get_all_options();

	$name    = $o['seo_business_name'] ?? '';
	$address = $o['seo_business_address'] ?? '';
	$phone   = $o['seo_business_phone'] ?? '';

	if ( empty( $name ) && empty( $address ) && empty( $phone ) ) {
		return null;
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'LocalBusiness',
		'name'     => $name ?: get_bloginfo( 'name' ),
	);

	if ( ! empty( $address ) ) {
		$schema['address'] = array(
			'@type'          => 'PostalAddress',
			'addressCountry' => 'IR',
			'streetAddress'  => $address,
		);
	}

	if ( ! empty( $phone ) ) {
		$schema['telephone'] = $phone;
	}

	$schema['openingHoursSpecification'] = array(
		'@type'     => 'OpeningHoursSpecification',
		'dayOfWeek' => array(
			'Saturday',
			'Sunday',
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
		),
		'opens'     => '09:00',
		'closes'    => '21:00',
	);

	return $schema;
}
