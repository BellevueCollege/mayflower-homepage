<!DOCTYPE html>
<?php
	global $mayflower_options;
	$mayflower_options = mayflower_get_options();
	global $globals_version;
	global $globals_url;
	global $globals_path;
	global $mayflower_brand;
	global $mayflower_brand_css;
	global $mayflower_theme_version;
	$mayflower_theme_version = wp_get_theme();
?>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php if ( isset ( $post_meta_data['_seo_meta_description'][0] ) ) { ?>
		<meta name="description" content="<?php echo $post_meta_data['_seo_meta_description'][0]; ?>" />
	<?php } ?>
	<?php if (isset($post_meta_data['_seo_meta_description'][0])) { ?>
		<meta name="keywords" content="<?php echo $post_meta_data['_seo_meta_keywords'][0]; ?>" />
	<?php } ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/bellevue.ico" />
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/bellevue.ico" />
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<?php wp_head();

	/* BEGIN MAYFLOWER HOMEPAGE SPECIFIC CODE */

	$post_top_parent_id = 0; //if needed, this ID is set to the top parent of this post
	//set $post_top_parent_id and $is_main_site for later use (ignore error404 page)
	if ( !(is_404())) {
		if ($post->post_parent!="0"){
			//this page has a parent
			if(intval($post->post_parent)>0)
			{
				while(intval($post->post_parent)>0)
					$post = get_post($post->post_parent);
			}
			$post_top_parent_id = $post->ID;  //now we now the top parent
		}
	}
	echo '<!-- parentid= '. $post_top_parent_id . '-->';

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
	###############################
	### --- Branded version --- ###
	###############################

	bc_tophead_big();

	//display site title on branded version
	/* BEGIN MAYFLOWER HOMEPAGE SPECIFIC CODE */

	/* Front Page Specific Code */
	if ( ! ( is_404() ) && is_front_page() ) { ?>
		<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?> bchome">
			<div id="main">


	<?php } else if ( is_404() ) { ?>
		<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
			<div id="main" class="container no-padding">
	<?php } else { ?>
		<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
			<div id="main" class="container no-padding">
				<div class="content-padding">
					<div id="site-header">
						<h1 class="site-title">
							<?php if ( $post_top_parent_id == 0 ){
								the_title();
							} else {
								echo '<a href="'.get_permalink($post_top_parent_id).'">'.get_the_title($post_top_parent_id).'</a>';
							} ?>
						</h1>
					</div><!-- container header -->
				</div><!-- content-padding -->
	<?php } /* END MAYFLOWER HOMEPAGE SPECIFIC CODE */


	if ( ! is_front_page() ) { ?>
		<div class="row">
			<div class="col-md-12">
	<?php } ?>