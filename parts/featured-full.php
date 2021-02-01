<?php if ( is_front_page() ) :
	$mayflower_options = mayflower_get_options();
	?>
	
		<div id="home-carousel-featured-full" class="carousel slide full" data-interval="false" tabindex="-1">
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
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
						<div class="responsive-bg-img carousel-item active" data-slide-number="<?php echo $slide_number; $slide_number++; ?>">
					<?php } else { ?>
						<div class="responsive-bg-img carousel-item" data-slide-number="<?php echo $slide_number; $slide_number++; ?>">
					<?php } ?>
						<?php // If url field has content, add the URL to the post thumbnail.
						$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
						$mayflower_options = mayflower_get_options();

						$img_id = get_post_thumbnail_id(get_the_ID());
						$img_alt = get_post_meta($img_id , '_wp_attachment_image_alt', true);
						
						if ( has_post_thumbnail( ) ) { ?>
							<img srcset="<?php the_post_thumbnail_url( 'mfhomepage-carousel-sm' ); ?> 475w,
									<?php the_post_thumbnail_url( 'mfhomepage-carousel-md' ); ?> 992w,
									<?php the_post_thumbnail_url( 'mfhomepage-carousel-lg' ); ?> 1680w,"
							sizes="(max-width: 475px) 475px,
									(max-width: 992px) 992px,
									1680px"
							src="<?php the_post_thumbnail_url( 'mfhomepage-carousel-lg' ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">

						<?php } ?>

						<div class="container caption-container p-0">
							<div class="carousel-caption">
								<?php
									// If a post class has input, sanitize it and add it to the post class array.
								$slider_ext_url = get_post_meta($post->ID, '_slider_url', true);
								if ( !empty( $slider_ext_url ) ) { ?>
									<div class="carousel-header">
										<h2><a href="<?php echo esc_url( $slider_ext_url );?>"><?php the_title(); ?></a></h2>
									</div>
								<?php } else { ?>
									<div class="carousel-header">
										<h2><?php the_title();?></h2>
									</div>
								<?php } //end else ?>
								
								<div class="carousel-excerpt">
									<p><?php echo wp_trim_words( get_the_excerpt(), 20, '...' );?></p>
									<?php if ( has_post_thumbnail() ) { ?>
										<p class="sr-only">Background Image: <?php echo esc_attr( $img_alt ); ?></p>
									<?php } ?>
								</div>
								<?php if ( !empty( $slider_ext_url ) ) { ?>
									<div class="carousel-more">
										<a href="<?php echo esc_url( $slider_ext_url );?>" class="btn btn-outline-light">More<span class="sr-only"> about <?php the_title(); ?></span></a>
									</div>
								<?php } ?>
								
							</div><!-- carousel-caption -->
						</div>
					</div><!-- item -->
				<?php endwhile; wp_reset_postdata(); ?>
			</div><!-- carousel-inner -->
			<?php if ( wp_count_posts( 'mhcarousel' )->publish > 1 ) : // Hide controls if only one post ?>
				<div class="carousel-controls d-flex justify-md-content-start flex-md-row-reverse align-items-start container px-0"> <!-- Carousel list and button -->
					<div class="btn-group" role="group">
						<button class="btn btn-lg btn-outline-light btn-carousel dropdown-toggle" id="open-slide-list-btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <!-- list group icon -->
							<i id="list-group-glyph" class="fas fa-list" aria-hidden="true" title="Other featured stories"></i>
							<span class="sr-only">Other featured stories</span>
						</button>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="open-slide-list-btn"> <!-- title list group -->
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
									<a href="#home-carousel-featured-full" class="dropdown-item active" data-slide-to="<?php echo $number++; ?>"><?php the_title(); ?></a>
								<?php } else { ?>
									<a href="#home-carousel-featured-full" class="dropdown-item" data-slide-to="<?php echo $number++; ?>"><?php the_title(); ?></a>
								<?php } ?>
							<?php endwhile; wp_reset_postdata(); ?>
						</div> <!-- end list-group-col list-group collapse -->
					</div> <!-- end list-group list-group-tree list-indicators -->
					<!-- Carousel button -->
					<a id="mhcarousel-next" class="btn btn-lg btn-outline-light btn-carousel flex-grow-1 flex-md-grow-0" href="#home-carousel-featured-full" role="button" aria-live="polite" aria-controls="home-carousel-featured-full" data-slide="next">
							Next: <span id="slide-title"></span> <i class="fas fa-chevron-right" aria-hidden="true"></i>
					</a>
				</div> <!-- end carousel-controls -->
			<?php endif; ?>
			
		</div><!-- end home-carousel-featured-full -->
<?php endif; //front page ?>
