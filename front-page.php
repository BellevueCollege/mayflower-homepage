<?php
/**
 * Front Page Template File
 *
 * Loads Custom BC Homepage Template
 *
 */
get_header(); ?>

<?php
define('NEWS_WEBSITE_ID', get_theme_mod( 'news_site_id' ) );
define('NEW_CATEGORY_NAME', get_theme_mod( 'news_category_name' ) );
?>
<div id = "bc-home-front-page" >
	<h1 class="sr-only"><?php _e('Welcome to Bellevue College','mayflower-homepage') ?></h1>
	<div class="row">
		<?php if ( is_active_sidebar( 'home_menus_area' ) ) : ?>
			<div id class="col-xs-7 col-sm-8 col-md-3 col-xl-2 resources-menu">
				<?php dynamic_sidebar( 'home_menus_area' ); ?>
			</div>
		<?php endif; ?>
		<div class="col-xs-5 col-sm-4" id="mobilelinks">
			<section>
				<a class="btn btn-info btn-block" href="//www.bellevuecollege.edu/location/maps/" class="btn btn-info"><?php _e( 'Maps', 'mayflower-homepage' ); ?></a>
				<a class="btn btn-info btn-block" href="//www.bellevuecollege.edu/location/directions/" class="btn btn-info"><?php _e( 'Directions', 'mayflower-homepage' ); ?></a>
				<a class="btn btn-info btn-block" href="//www.bellevuecollege.edu/contacts/" class="btn btn-info"><?php _e( 'Contact Us', 'mayflower-homepage' ); ?></a>
			</section>
		</div>
	<?php /* Expand slideshow to full-width if no widgets are present in Menus area */
		if ( is_active_sidebar( 'home_menus_area' ) ) { ?>
		<div class="col-xs-12 col-md-9 col-xl-10">
	<?php } else { ?>
		<div class="col-xs-12">
	<?php } ?>
			<section id="homeslider">
				<?php
				//display featured slider
				get_template_part('parts/featured-full');
				?>
			</section><!--#homeslider-->
		</div><!--#content .row-->
	</div>
	<div class="row row-padding">
		<div class="col-md-8 col-lg-9">
			<section class="col-md-6 col-no-padding" id="home-news">
				<header class="content-padding">
					<h2><?php _e( 'News &amp; Announcements', 'mayflower-homepage' ); ?></h2>
				</header>
				<div class="content-padding">
					<ul>
						<?php
						if ( is_multisite() )
						{
						global $switched;
						switch_to_blog(NEWS_WEBSITE_ID); //switched to the news site
							$the_query = new WP_Query(array(
								'post_type'=>'post',
								'category_name' => NEW_CATEGORY_NAME,
								'orderby'=> 'date',
								'order'=> 'DESC',
								'posts_per_page' => 3,
							));
							while ( $the_query->have_posts() ) :
							$the_query->the_post(); ?>
											<li><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></li>
											<?php endwhile;
											// wp_reset_postdata();
											restore_current_blog(); }
											?>
											<li><a class="more" href="//www.bellevuecollege.edu/news/"><strong>More news...</strong><span class="arrow"></span></a></li>
											</ul>
				</div><!--.content-padding-->
			</section>
			<section class="col-md-6 col-no-padding"  id="home-events">
				<header class="content-padding">
					<h2><?php _e( 'Events', 'mayflower-homepage' ); ?></h2>
				</header>
				<div class="content-padding">
					<ul>
						<?php
							$the_query = new WP_Query(array(
								'post_type'=>'post',
								'category_name' => get_theme_mod( 'events_category' ),
								'orderby'=> 'date',
								'order'=> 'ASC',
							));

							while ( $the_query->have_posts() ) :
							$the_query->the_post();
						?>
						<!-- begin event listing -->
						<li><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></li>
						<!-- end event listing -->
						<?php
							endwhile;
								wp_reset_postdata();
						?>

						<li><a class="more" href="//www.bellevuecollege.edu/events"><strong><?php _e( 'More events...', 'mayflower-homepage' ); ?></strong></a></li>
						<li><a id="calendar" href="//www.bellevuecollege.edu/enrollment/calendar/"><?php _e( 'Academic Calendar', 'mayflower-homepage' ); ?><strong></strong></a> </li>
					</ul>
				</div><!--.content-padding-->
			</section><!--#home-events-->
		</div>
		<div class="col-md-4 col-lg-3">
			<p id="apply" >
				<?php echo get_theme_mod( 'apply_btn_html' ); ?>
			</p>
			<?php
				$the_query = new WP_Query(array(
					'post_type'=>'small_ad',
					'orderby'=> 'rand',
					'order'=> 'ASC',
					'posts_per_page' => 1,
				));

				while ( $the_query->have_posts() ) :
				$the_query->the_post();

				// If url field has content, add the URL to the post thumbnail.
					$small_ad_ext_url = get_post_meta( $post->ID, '_small_ad_url', true );

					if ( !empty( $small_ad_ext_url ) ){ ?>
						<p id="homead">
							<a href="<?php echo esc_url($small_ad_ext_url);?>"><?php the_post_thumbnail('home-small-ad', array('class' => 'box-shadow img-responsive'));?></a>
						</p>
				<?php }  //end if ?>

			<?php
				endwhile;
					wp_reset_postdata();
			?>
		</div><!--#home-sidelinks-->
	</div><!-- .content-row -->
</div>

<?php get_footer(); ?>
