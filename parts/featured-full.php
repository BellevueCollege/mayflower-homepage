<?php if ( is_front_page() ) :
	$mayflower_options = mayflower_get_options();
	?>
		<div id="carousel-featured-full" class="carousel slide full" data-ride="carousel">
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<?php $the_query = new WP_Query(array(
					'post_type'=>'mhcarousel',
					'orderby'=> 'menu_order',
					'order'=> 'ASC',
					'posts_per_page' => $mayflower_options['slider_number_slides'],
				));
				$slide_number = 0;
				while ( $the_query->have_posts() ) :
					$the_query->the_post(); ?>
					<?php if ( $the_query->current_post == 0 ) { ?>
						<div class="item active" data-slide-number="<?php echo $slide_number; $slide_number++; ?>" style="background-image: url('<?php the_post_thumbnail_url('mhcarousel-featured-size');?>');">
					<?php } else { ?>
						<div class="item" data-slide-number="<?php echo $slide_number; $slide_number++; ?>" style="background-image: url('<?php the_post_thumbnail_url('mhcarousel-featured-size');?>');">
					<?php } ?>

						<?php // If url field has content, add the URL to the post thumbnail.
						$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
						if ( !empty( $slider_ext_url ) ) { ?>
							<a href="<?php echo esc_url($slider_ext_url);?>"><!-- <?php the_post_thumbnail('featured-full'); ?> --></a>
						<?php } else { ?>
							<a href="<?php echo the_permalink(); ?>"><!-- <?php the_post_thumbnail('featured-full'); ?> --></a>
						<?php } //end else ?>
						<?php //should we show title & excerpt?
						$mayflower_options = mayflower_get_options();
                        if ($mayflower_options['slider_title'] == 'true' || $mayflower_options['slider_excerpt'] == 'true' ) { ?>
							<div class="carousel-caption">
								<?php if ($mayflower_options['slider_title'] == 'true') {
									// If a post class has input, sanitize it and add it to the post class array.
									$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
									if ( !empty( $slider_ext_url ) ) { ?>
									<div class="carousel-header" data-title="<?php the_title(); ?>">
										<h1><a href="<?php echo esc_url($slider_ext_url);?>"><?php the_title(); ?></a></h1>
									</div>
									<?php } else { ?>
										<div class="carousel-header" data-title="<?php the_title(); ?>">
											<h1><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h1>
										</div>
									<?php } //end else ?>
								<?php } else {
									echo '<!-- No Title -->';
								} ?>
								<?php if ($mayflower_options['slider_excerpt'] == 'true' ) { ?>
									<div class="carousel-excerpt">
										<p><?php echo wp_trim_words( get_the_excerpt(), 20, '...' );?></p>
									</div>
									<div class="carousel-more">
										<a href="<?php echo esc_url($slider_ext_url);?>"><button class="btn btn-lg btn-primary-outline">More</button></a>
									</div>
								<?php } else {
									echo '<!-- No Excerpt -->';
								} ?>
							</div><!-- carousel-caption -->
						<?php } else  { } ?>

					</div><!-- item -->

				<?php endwhile; wp_reset_postdata(); ?>

			</div><!-- carousel-inner -->

			<!-- Carousel Controls -->

			<!-- Script for toggling the indicator list -->
			<script>
			jQuery(function() {
				jQuery(".list-group-tree").on('click', "[data-toggle=collapse]", function(){
					jQuery(this).toggleClass('in')
					jQuery(this).next(".list-group.collapse").collapse('toggle');
					return false;
				})
			});
			</script>
			<!-- end script for toggling -->

			<!-- Script creates arrays to hold carousel titles for next button -->
			<script>
			<?php 

			// the query
			$the_query = new WP_Query(array(
				'post_type'=>'mhcarousel',
				'orderby'=> 'menu_order',
				'order'=> 'ASC',
				'posts_per_page' => $mayflower_options['slider_number_slides'],
			));

			if ($the_query->have_posts()) :	
				echo 'var carousel_posts = [';
				while ($the_query->have_posts()) : $the_query->the_post(); 
					echo '"' . get_the_title( get_the_ID() ) . '", ';
				endwhile;
				echo '];';
			endif;
			?>
			
			jQuery( document ).ready(function( $ ) {
				$( '#slide-title' ).html( carousel_posts[1] );
				$('#carousel-featured-full').on('slide.bs.carousel', function ( e ) {
					var next_slide_number = parseInt( e.relatedTarget.getAttribute( 'data-slide-number' ) ) + 1;
					$( '#slide-title' ).html( carousel_posts[next_slide_number] );
			
					// last slide shows first slide button title
					$( '#slide-title' ).html( carousel_posts[next_slide_number - carousel_posts.length] );
				});
			});
			</script>
			<!-- end title array script -->

			<div class="container no-padding">
				<!-- Carousel list and button -->
				<div class="carousel-controls">
					<!-- Carousel list -->
					<div class="list-container list-group list-group-tree list-indicators">
						<!-- list group icon -->
						<a class="list-group-icon list-group-item" data-toggle="collapse">
							<i class="glyphicon glyphicon-th-list"></i>
						</a>
						<!-- title list group -->
						<div class="list-group-col list-group collapse">
							<?php $number = 0;
							$the_query = new WP_Query(array(
								'post_type'=>'mhcarousel',
								'orderby'=> 'menu_order',
								'order'=> 'ASC',
								'posts_per_page' => $mayflower_options['slider_number_slides']
							));
							while ( $the_query->have_posts() ) :
								$the_query->the_post(); ?>
									<?php if ( $the_query->current_post == 0 ) { ?>
										<a class="list-group-item" data-target="#carousel-featured-full" data-slide-to="<?php echo $number++; ?>" class="active"><?php the_title(); ?></a>
									<?php } else { ?>
										<a class="list-group-item" data-target="#carousel-featured-full" data-slide-to="<?php echo $number++; ?>"><?php the_title(); ?></a>
									<?php } ?>
							<?php endwhile; wp_reset_postdata(); ?>
						</div> <!-- end list-group-col list-group collapse -->
					</div> <!-- end list-container list-group list-group-tree list-indicators -->

					<!-- Carousel button -->
					<a class="carousel-control next-slide" href="#carousel-featured-full" role="button" data-slide="next">
							Next: <span id="slide-title"></span> >
					</a>
				</div> <!-- end carousel-controls -->
			</div><!-- end container no-padding -->

		</div><!-- end carousel-featured-full -->
<?php endif; //front page ?>
