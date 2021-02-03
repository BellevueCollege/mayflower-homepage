<?php
/**
 * Theme Header
 *
 * Site header used across Mayflower, including both Lite and Branded.
 *
 * @package Mayflower
 */

/* Globally declare variables used in a variety of locations */
global $post, $mayflower_options, $mayflower_brand, $mayflower_brand_css, $mayflower_theme_version;


if ( ! ( is_array( $mayflower_options ) ) ) {
	$mayflower_options = mayflower_get_options();
}

$mayflower_theme_version = wp_get_theme();
$post_meta_data          = get_post_custom( $post->ID ?? null );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php if ( isset( $post_meta_data['_seo_meta_description'][0] ) ) { ?>
		<meta property="og:title" content="<?php echo esc_attr( $post_meta_data['_seo_custom_page_title'][0] ); ?>" />
	<?php } else { ?>
		<meta property="og:title" content="<?php echo esc_attr( get_the_title() . ' :: ' . get_bloginfo( 'name', 'display' ) . ' @ Bellevue College' ); ?>" />
	<?php } ?>

	<?php if ( isset( $post_meta_data['_seo_meta_description'][0] ) ) { ?>
		<meta name="description" content="<?php echo esc_html( $post_meta_data['_seo_meta_description'][0] ); ?>" />
		<meta property="og:description" content="<?php echo esc_html( $post_meta_data['_seo_meta_description'][0] ); ?>" />
	<?php } ?>
	<?php if ( isset( $post_meta_data['_seo_meta_keywords'][0] ) ) { ?>
		<meta name="keywords" content="<?php echo esc_html( $post_meta_data['_seo_meta_keywords'][0] ); ?>" />
	<?php } ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/img/bellevue.ico" />

	<?php if ( is_archive( $post->ID ?? null ) ) { ?>
		<meta name="robots" content="noindex, follow">
	<?php } ?>

	<meta class="funnelback" name="fb_site_name" content="<?php echo get_bloginfo( 'name', 'display' ) ?>" />
	<?php if ( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) : ?>
		<meta class="funnelback" name="fb_featured_image" content="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ); ?>" />
	<?php endif; ?>

	<link rel="profile" href="https://gmpg.org/xfn/11" />

	<!--- Open Graph Tags -->
	<?php if ( 'post' === get_post_type() ) : ?>
		<meta property="og:type" content="article" />
		<meta property="article:published_time" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" />
		<meta property="article:modified_time" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" />
		<meta property="og:updated_time" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" />
	<?php else : ?>
		<meta property="og:type" content="website" />
		<meta property="og:updated_time" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" />
	<?php endif; ?>

	<?php if ( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ) : ?>
		<meta property="og:image" content="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ); ?>" />
	<?php else : ?>
		<meta property="og:image" content="https://www.bellevuecollege.edu/bc-og-default.jpg" />
	<?php endif; ?>
	<meta property="og:url" content="<?php echo esc_url( get_permalink() ); ?>" />
	<meta property="og:site_name" content="Bellevue College" />


	<?php wp_head();
	/* BEGIN MAYFLOWER HOMEPAGE SPECIFIC CODE */

	$post_top_parent_id = 0; //if needed, this ID is set to the top parent of this post
	//set $post_top_parent_id and $is_main_site for later use (ignore error404 page)
	if ( ! ( is_404() ) ) {
		if ( $post->post_parent!="0" ){
			//this page has a parent
			if ( intval( $post->post_parent ) > 0 ) {
				while ( intval( $post->post_parent) > 0 ) {
					$post = get_post( $post->post_parent );
				}
			}
			$post_top_parent_id = $post->ID;  //now we now the top parent
		}
	}
	echo '<!-- parentid= ' . $post_top_parent_id . '-->';

	?>
</head>

<body <?php
	if ( $post_top_parent_id == 0 ){
		if (isset($post_meta_data['_gnav_college_nav_menu'][0])) {
			body_class( $post_meta_data['_gnav_college_nav_menu'][0] );
		} else {
				body_class();
		}
	} else {
		$meta_values = get_post_meta( $post_top_parent_id, '_gnav_college_nav_menu', true );
		if ( isset( $meta_values ) ) {
			body_class( $meta_values );
		} else {
			body_class();
		}
	}
	/* END MAYFLOWER HOMEPAGE SPECIFIC CODE */
	?>>
	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	/**
	 * Branded Header
	 */

		$globals = new Globals();
		$globals->tophead_big();

		/* BEGIN MAYFLOWER HOMEPAGE SPECIFIC CODE */

	/* Front Page Specific Code */
	if ( ! ( is_front_page() ) ) { ?>
		<div id="site-header" class="container <?php echo esc_attr( $mayflower_brand_css ); ?>">
			<?php if ( ! is_404() ) : ?>
				<h1 class="site-title">
					<?php if ( $post_top_parent_id === 0 ){
						the_title();
					} else {
						echo '<a href="'.get_permalink($post_top_parent_id).'">'.get_the_title($post_top_parent_id).'</a>';
					} ?>
				</h1>
			<?php else : ?>
				<p class="site-title">404 Error</p>
			<?php endif; ?>
		</div>
		<div id="main" class="<?php echo esc_attr( $mayflower_brand_css ); ?> container <?php echo 'lite' === $mayflower_brand ? 'shadow' : ''; ?>">
			<div class="row pt-md-4"><!--endnoindex-->
	<?php } /* END MAYFLOWER HOMEPAGE SPECIFIC CODE */
