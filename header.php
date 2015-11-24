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
	<title><?php
		$post_meta_data = get_post_custom($post->ID);
		if ( isset( $post_meta_data['_seo_custom_page_title'][0] ) ) {
			echo $post_meta_data['_seo_custom_page_title'][0];
		} else {
			if ( is_front_page() ) { bloginfo('name');
				?> @ Bellevue College<?php
			} else {
				wp_title( " :: ", true, 'right' );
			}
		}
	?></title>

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
	##############################################
	### Branded or Lite versions of the header
	##############################################

	if( $mayflower_brand == 'branded' ) {
		###############################
		### --- Branded version --- ###
		###############################

		bc_tophead_big();

		//display site title on branded version
		/* BEGIN MAYFLOWER HOMEPAGE SPECIFIC CODE */
		if ( !(is_404()) && is_front_page() ) { ?>
			<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?> bchome">
				<div id="main" class="container no-padding">
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
	} else {
		############################
		### --- Lite version --- ###
		############################

		bc_tophead(); ?>
		<div id="main-wrap" class="<?php echo $mayflower_brand_css; ?>">
			<div id="main" class="container no-padding">
				<div class="container" id="top">
					<div id="site-header" class="row">
						<div class="col-md-8">
							<div class="content-padding">
								<?php $header_image = get_header_image();
								if ( ! empty( $header_image ) ) : ?>
									<div class="header-image">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
											<img src="<?php header_image(); ?>" class="header-image"  alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> : <?php bloginfo('description'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
										</a>
									</div><!-- header-image -->
								<?php else : ?>
									<h1 class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
									</h1>
									<p class="site-description"><?php bloginfo('description'); ?></p>
								<?php endif; ?>
							</div><!-- .content-padding -->
						</div><!-- col-md-8 -->
						<div class="col-md-4">
							<div class="header-search content-padding
								<?php if ( get_bloginfo('description') ) {
									echo 'header-search-w-description ';
								}
								if(get_bloginfo('description') <> '') {
									echo 'header-social-links-no-margin ';
								} ?>">
								<div class="social-media">
									<ul>
										<?php if (!empty($mayflower_options['facebook'])) {
											$facebook = esc_url($mayflower_options['facebook'] ); ?>
											<li><a href="<?php echo $mayflower_options['facebook']; ?>" title="facebook"><img src="<?php echo $globals_url; ?>i/facebook.png" alt="facebook" /></a></li>
										<?php } ?>

										<?php if (!empty($mayflower_options['twitter'])) { ?>
											<li><a href="<?php echo $mayflower_options['twitter']; ?>" title="twitter"><img src="<?php echo $globals_url; ?>i/twitter.png" alt="twitter" /></a></li>
										<?php } ?>

										<?php if (!empty($mayflower_options['flickr'])) { ?>
											<li><a href="<?php echo $mayflower_options['flickr']; ?>" title="flickr"><img src="<?php echo $globals_url; ?>i/flickr.png" alt="flickr" /></a></li>
										<?php } ?>

										<?php if (!empty($mayflower_options['youtube'])) { ?>
											<li><a href="<?php echo $mayflower_options['youtube']; ?>" title="youtube"><img src="<?php echo $globals_url; ?>i/youtube.png" alt="youtube" /></a></li>
										<?php } ?>

										<?php if (!empty($mayflower_options['linkedin'])) { ?>
											<li><a href="<?php echo $mayflower_options['linkedin']; ?>" title="linkedin"><img src="<?php echo $globals_url; ?>i/linkedin.png" alt="facebook" /></a></li>
										<?php } ?>
									</ul>
								</div><!-- social-media -->

								<?php $mayflower_adminonly_options = get_option( 'mayflower_admin_theme_general_options' ); ?>

								<?php if( empty( $mayflower_adminonly_options['hide_searchform'] ) ) { ?>
									<div class="row">
										<div id="main-nav-link" class="col-xs-4">
											<a href="#college-navbar" title="Navigation Menu" class="btn btn-default btn-block">Menu</a>
										</div><!-- main-nav-link -->
										<div class="col-xs-8 col-sm-12">
											<?php get_search_form(); ?>
										</div>
									</div><!-- row -->

								<?php } else { ?>
									<div class="row">
										<div id="main-nav-link" class="col-xs-12">
											<a href="#college-navbar" title="Navigation Menu" class="btn btn-default btn-block">Menu</a>
										</div><!-- main-nav-link -->
									</div><!-- row -->

								<?php } ?>

							</div> <!--content-padding -->
						</div><!-- col-md-4 -->
					</div> <!--#site-header .row-->
				</div><!-- container -->

	<?php } //end lite ?>

	<div class="row">
		<div class="col-md-12">

			<?php //add flexwrap if we are in the lite version
			global $mayflower_brand;
			if( $mayflower_brand == 'lite') { ?>
				<div class="flexwrap">
			<?php }
