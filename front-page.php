<?php
/**
 * Front Page Template File
 *
 * Loads Custom BC Homepage Template
 *
 */
get_header(); ?>
<div id = "bc-home-front-page" >
	<h1 class="sr-only" id="content"><?php esc_html_e( 'Welcome to Bellevue College', 'mayflower-homepage' ) ?></h1>
	<div class="row">
		<?php if ( is_active_sidebar( 'home_menus_area' ) ) : ?>
			<div id class="col-xs-7 col-sm-8 col-md-3 col-xl-2 resources-menu">
				<?php dynamic_sidebar( 'home_menus_area' ); ?>
			</div>
		<?php endif; ?>
		<div class="col-xs-5 col-sm-4" id="mobilelinks">
			<section>
				<a class="btn btn-info btn-block" href="//www.bellevuecollege.edu/location/maps/" class="btn btn-info"><?php esc_html_e( 'Maps', 'mayflower-homepage' ); ?></a>
				<a class="btn btn-info btn-block" href="//www.bellevuecollege.edu/location/directions/" class="btn btn-info"><?php esc_html_e( 'Directions', 'mayflower-homepage' ); ?></a>
				<a class="btn btn-info btn-block" href="//www.bellevuecollege.edu/contacts/" class="btn btn-info"><?php esc_html_e( 'Contact Us', 'mayflower-homepage' ); ?></a>
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
				get_template_part( 'parts/featured-full' ); ?>
			</section><!--#homeslider-->
		</div><!--#content .row-->
	</div>
	<div class="row row-padding">
		<div class="col-md-8 col-lg-9">
			<section class="col-md-6 col-no-padding" id="home-news">
				<header class="content-padding">
					<h2><?php esc_html_e( 'News &amp; Announcements', 'mayflower-homepage' ); ?></h2>
				</header>
				<div class="content-padding">
					<ul>
						<?php
						if ( is_multisite() ) {
							global $switched;
							$news_category_name = get_theme_mod( 'news_category_name' );
							switch_to_blog( get_theme_mod( 'news_site_id' ) ); //switched to the news site
							$the_query = new WP_Query( array(
								'post_type'      => 'post',
								'category_name'  => $news_category_name,
								'orderby'        => 'date',
								'order'          => 'DESC',
								'posts_per_page' => 3,
							));
							while ( $the_query->have_posts() ) :
								$the_query->the_post(); ?>
								<li><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php endwhile;
							restore_current_blog();
						}
						?>
						<li><a class="more" href="//www.bellevuecollege.edu/news/"><strong>More news...</strong><span class="arrow"></span></a></li>
					</ul>
				</div><!--.content-padding-->
			</section>
			<section class="col-md-6 col-no-padding"  id="home-events">
				<header class="content-padding">
					<h2><?php esc_html_e( 'Events', 'mayflower-homepage' ); ?></h2>
				</header>
				<div class="content-padding">
					<ul>
						<?php
						$the_query = new WP_Query( array(
							'post_type'     => 'post',
							'category_name' => get_theme_mod( 'events_category' ),
							'orderby'       => 'date',
							'order'         => 'ASC',
						));
						while ( $the_query->have_posts() ) :
							$the_query->the_post(); ?>
							<!-- begin event listing -->
							<li><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></li>
							<!-- end event listing -->
						<?php
						endwhile;
						wp_reset_postdata();
						?>

						<li><a class="more" href="//www.bellevuecollege.edu/events"><strong><?php esc_html_e( 'More events...', 'mayflower-homepage' ); ?></strong></a></li>
						<li><a id="calendar" href="//www.bellevuecollege.edu/enrollment/calendar/"><?php esc_html_e( 'Academic Calendar', 'mayflower-homepage' ); ?><strong></strong></a> </li>
					</ul>
				</div><!--.content-padding-->
			</section><!--#home-events-->
		</div> 
		<!--
			========
			Small Ad 
			========
		-->
		<div class="col-md-4 col-lg-3">
			<p id="apply" >
				<?php echo get_theme_mod( 'apply_btn_html' ); ?>
			</p>
			<?php  $number = 0; // small ad
				$the_query = new WP_Query(array(
					'post_type'=>'small_ad',
					'orderby'=> 'ID',
					'order'=> 'ASC',
					'posts_per_page' => $number,
				));
				?>
				<div id="smallAd">
					<div id="smallAd-carousel" class="carousel slide" data-ride="carousel" data-wrap="true" data-interval="false"> 
						<!-- Wrapper for slides -->
						<div class="carousel-inner center-block" role="listbox"  id="smallAdImages"  style="display:none">
							<?php							
							while ( $the_query->have_posts() ) :
								$the_query->the_post();

								// If url field has content, add the URL to the post thumbnail.
								$small_ad_ext_url = get_post_meta( $post->ID, '_small_ad_url', true );
								
									if ( $the_query->current_post == 0 ) { ?>
									<div class="item active">
								<?php }  else { ?>
									<div class="item">
								<?php } 	
									if( $small_ad_ext_url ) { ?>					
										<a href="<?php echo esc_url( $small_ad_ext_url );?>"><?php the_post_thumbnail( 'home-small-ad', array( 'class' => 'img-responsive' ) );?></a>
									<?php }  else {
										the_post_thumbnail( 'home-small-ad', array( 'class' => 'img-responsive' ) );
									} ?>
									</div>
							<?php // }  //end if ?>
							<?php endwhile; ?>
						</div>				

					<!-- Indicators -->
					<?php
					if( $the_query->post_count > 1 ) { ?>
					<ol class="carousel-indicators">
					<?php
					while ( $the_query->have_posts() > 0 ) : $the_query->the_post();
						$number = $the_query->current_post;
						if( $number >= 0 || $number <= 5 ) {
							if ( 0 === $number ) { ?>
								<li data-target="#smallAd-carousel" data-slide-to="<?php echo intval( $number ); ?>" class="active"></li>
							<?php } else { ?>
								<li data-target="#smallAd-carousel" data-slide-to="<?php echo intval( $number ); ?>"></li>
							<?php }
						}
					endwhile; ?>
					</ol>
						<!-- Controls -->
						<a class="left carousel-control" href="#smallAd-carousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-triangle-left" aria-hidden="true" value="left"></span>
						</a>
						<a class="right carousel-control" href="#smallAd-carousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-triangle-right" aria-hidden="true" value="right"></span>
						</a>
					<?php } ?> 
					<?php wp_reset_postdata(); ?>
				</div><!-- smallAd-carousel-->
			</div><!-- small Ad -->	
		</div><!--#home-sidelinks-->
	</div><!-- .content-row -->
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	/* store images in a variable object */
	var images = $( "#smallAdImages" ).children();

	function shuffle(array) {
		/* https://github.com/Daplie/knuth-shuffle */
		var currentSlide = array.length,
			rand, temp;
		while ( 0 !== currentSlide ) {
			rand = Math.floor( Math.random() * currentSlide );
			currentSlide -= 1;

			temp = array[currentSlide];
			array[currentSlide] = array[rand];
			array[rand] = temp;
		}
		return array;
	}
		/* shuffle array */
	var shufImg = shuffle( images );
	shufImg.each( function() {
		$( this ).removeClass( "active" ).attr('aria-selected', 'false' ).attr('tabindex', '-1' );
	});
	/* add class to first shuffled object */
	$( "#smallAdImages" ).html(shufImg).show();
	$( "#smallAdImages" ).children().first().addClass( "active" ).attr('aria-selected', 'true' ).attr('tabindex', '0' );

});
</script>
<?php get_footer(); ?>