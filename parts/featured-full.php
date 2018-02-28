<?php if ( is_front_page() ) :
	$mayflower_options = mayflower_get_options();
	?>
		<div id="carousel-featured-full" class="carousel slide full" data-interval="false">
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
						
						
						$mayflower_options = mayflower_get_options(); ?>
						<div class="container no-padding caption-container">
							<div class="carousel-caption">
								<?php
									// If a post class has input, sanitize it and add it to the post class array.
								$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
								if ( !empty( $slider_ext_url ) ) { ?>
									<div class="carousel-header">
										<h1><a href="<?php echo esc_url( $slider_ext_url );?>"><?php the_title(); ?></a></h1>
									</div>
								<?php } else { ?>
									<div class="carousel-header">
										<h1><?php the_title();?></h1>
									</div>
								<?php } //end else ?>
								
								<div class="carousel-excerpt">
									<p><?php echo wp_trim_words( get_the_excerpt(), 20, '...' );?></p>
								</div>
								<?php if ( !empty( $slider_ext_url ) ) { ?>
									<div class="carousel-more">
										<a href="<?php echo esc_url( $slider_ext_url );?>" class="btn btn-primary-outline">More<span class="sr-only"> about <?php the_title(); ?></span></a>
									</div>
								<?php } ?>
								
							</div><!-- carousel-caption -->
						</div>
					</div><!-- item -->
				<?php endwhile; wp_reset_postdata(); ?>
			</div><!-- carousel-inner -->

			<!-- Carousel Controls -->
			<!-- Script creates title array to hold carousel titles for next button -->
			<script>
				<?php 
				// the query
				$the_query = new WP_Query(array(
					'post_type'=>'mhcarousel',
					'orderby'=> 'menu_order',
					'order'=> 'ASC',
					'posts_per_page' => $mayflower_options['slider_number_slides'],
				));

				$carousel_posts_array = '';
				if ($the_query->have_posts()) :	
					echo $carousel_posts_array = "var carousel_posts = [";
					while ($the_query->have_posts()) : $the_query->the_post(); 
						echo $carousel_posts_array = "'" . get_the_title( get_the_ID() ) . "', ";
					endwhile;
					echo $carousel_posts_array =  "];";
				endif;
				?>
			</script>
			<?php wp_add_inline_script( 'mhcarousel-button-script','$carousel_posts_array', 'before' ); ?>
			<!-- end title array script -->

			<!-- Script hides carousel control interface if only 1 slide is published -->
			<script>
				<?php
				$slide_count = "";
				echo $slide_count = "var carousel_slide_count = '" . wp_count_posts('mhcarousel')->publish . "';";
				?>
			</script>
			<?php wp_add_inline_script( 'mhcarousel-interface-script','$slide-count', 'before' ); ?>
			<!-- end hide carousel interface  script -->

			<div class="container no-padding">
				<div class="carousel-controls"> <!-- Carousel list and button -->
					<div class="list-group list-group-tree list-indicators"> <!-- Carousel list -->
						<a class="list-group-icon list-group-item" data-toggle="collapse"> <!-- list group icon -->
							<i id="list-group-glyph" class="glyphicon glyphicon-list"></i>
						</a>
						<div class="list-group-col list-group collapse"> <!-- title list group -->
							<?php 
							$number = 0;
							$the_query = new WP_Query(array(
								'post_type'=>'mhcarousel',
								'orderby'=> 'menu_order',
								'order'=> 'ASC',
								'posts_per_page' => $mayflower_options['slider_number_slides']
							));
							while ( $the_query->have_posts() ) :
								$the_query->the_post(); ?>
								<?php if ( $the_query->current_post == 0 ) { ?>
									<a class="list-group-item list-item-active" data-target="#carousel-featured-full" data-slide-to="<?php echo $number++; ?>"><?php the_title(); ?></a>
								<?php } else { ?>
									<a class="list-group-item" data-target="#carousel-featured-full" data-slide-to="<?php echo $number++; ?>"><?php the_title(); ?></a>
								<?php } ?>
							<?php endwhile; wp_reset_postdata(); ?>
						</div> <!-- end list-group-col list-group collapse -->
					</div> <!-- end list-group list-group-tree list-indicators -->
					<!-- Carousel button -->
					<a class="carousel-control next-slide" href="#carousel-featured-full" role="button" data-slide="next">
							Next: <span id="slide-title"></span> >
					</a>
				</div> <!-- end carousel-controls -->
			</div><!-- end container no-padding -->
			
		</div><!-- end carousel-featured-full -->
<?php endif; //front page ?>
