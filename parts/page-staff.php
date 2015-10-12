<?php  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php if($post->post_content=="") : ?>
			<!-- Don't display empty the_content or surround divs -->
				<div class="page-content">
					<div class="content-padding">
						<?php if ( intval($post->post_parent) > 0 ) { ?>
							<h1><?php the_title(); ?></h1>
						<?php } ?>
					</div><!-- content-padding -->
				</div><!-- page-content -->
			<?php else : ?>
			<!-- Do stuff when the_content has content -->
				<div class="page-content">
					<div class="content-padding">
						<?php if ( intval($post->post_parent) > 0 ) { ?>
							<h1><?php the_title(); ?></h1>
						<?php } ?>
					<?php the_content(); ?>
					</div><!-- content-padding -->
				</div><!-- page-content -->

			<?php endif; ?>

			<?php endwhile; else: ?>
			<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
			<?php endif; ?>

<?php
	$mayflower_options = mayflower_get_options();
	if( $mayflower_options['staff_layout'] == 'list-view' ) { ?>

      <div class="content-padding top-spacing15">
				<?php
					// Start showing staff list
					$loop = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC') );

					while ( $loop->have_posts() ) : $loop->the_post();
				?>


			    <div class="media">
			    <a class="pull-left" href="<?php the_permalink(); ?>">
				<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail('thumbnail', array('class' => 'media-object img-responsive img-thumbnail'));
					}
					else {
						echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/img/thumbnail-default.png" />';
					}
				?>

				    </a>

				<div class="media-body">
					<div class="caption staff-details content-padding">
						<?php $post_meta_data = get_post_custom($post->ID); ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

							<?php if (isset($post_meta_data['_staff_position'][0])) { ?>
								<h3>
									<?php echo $post_meta_data['_staff_position'][0]; ?>
								</h3>
							<?php } ?>

							<ul>

								<?php if (isset($post_meta_data['_staff_email'][0])) { ?>
									<li>
										<strong>Email: </strong>
										<a href="mailto:<?php echo $post_meta_data['_staff_email'][0];  ?>"><?php echo $post_meta_data['_staff_email'][0]; ?></a>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['_staff_phone'][0])) { ?>
									<li>
										<strong>Phone: </strong>
										<?php echo $post_meta_data['_staff_phone'][0];  ?>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['_staff_office_location'][0])) { ?>
									<li>
										<strong>Office Location: </strong>
										<?php echo $post_meta_data['_staff_office_location'][0];  ?>
									</li>
								<?php } ?>

								<?php if (isset($post_meta_data['_staff_office_hours'][0])) { ?>
									<li>
										<strong>Office Hours: </strong><?php echo $post_meta_data['_staff_office_hours'][0];  ?>
									</li>
								<?php } ?>

							</ul>
							<?php if(empty($post->post_content)) {  } else { ?>
										<h3 class="staff-biography">Biography:</h3>
										<?php the_excerpt();  ?>
								<?php } ?>
						</div><!-- caption -->

				   </div><!-- media-body -->
			    </div><!-- media -->

				<hr />
				<?php endwhile; wp_reset_postdata(); ?>
			</div><!-- content-padding -->
	<?php } elseif( $mayflower_options['staff_layout'] == 'grid-view' ) {  ?>
	<?php
		// ########################
		// Start showing staff grid
		// ########################
	?>
	<?php
		$loop = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC') );
    $columnNum = 3;
    $count = 0;
		while ( $loop->have_posts() ) : $loop->the_post();
                $count++;
                if ($count == 1) {
                    echo '<div class="row top-spacing15">';
                }
	?>

		<div class="col-md-4">
			<div class="content-padding">
					<?php if(has_post_thumbnail()) { ?>
					<a href="<?php the_permalink(); ?>">
						<?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');  ?>
					</a>
					<?php } else { }?>

					<div class="caption staff-details">
						<?php $post_meta_data = get_post_custom($post->ID); ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php if (isset($post_meta_data['_staff_position'][0])) { ?>
								<p>
									<?php echo $post_meta_data['_staff_position'][0]; ?>
								</p>
							<?php } ?>

					</div><!-- caption staff-details -->
			</div><!-- content-padding -->
		</div> <!-- end of col-md-4 -->
				<?php if ($count == $columnNum) {
                        echo '</div> <!-- .row -->';
                        $count = 0;
                    }
                endwhile; wp_reset_postdata();
        if ($count > 0 ) {
            echo '</div> <!-- .row -->';
        }
        ?>

<?php } // end elseif  ?>
