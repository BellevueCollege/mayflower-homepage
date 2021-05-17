<?php
$post_count = 1;
$pathways = get_posts( array(
	'post_type'   => 'bcgpt-pathway',
	'numberposts' => -1,
	'orderby'     => 'title',
	'order'       => 'ASC',
)); 

/**
 * Desktop - Active State
 */
?>
<div class="d-md-block d-none">
	<div id="pathways-tab-scroll-zone">
		<div id="pathways-scrolling-grid" class="nav nav-tabs" role="tablist">
			<?
			foreach ( $pathways as $key => $post ):
				setup_postdata( $post ); ?>
					<a id="pathway-tab-<?php echo $key; ?>" class="card mb-0 pathways-card-desktop pathways-card-tab" data-toggle="tab" role="tab" aria-controls="pathway-content-<?php echo $key; ?>" aria-selected="false" href="#pathway-content-<?php echo $key; ?>">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php the_post_thumbnail( 'bcgpt-card-small', ['class' => 'card-img-top'] ); ?>
						<?php } ?>
						<div class="card-header h4"><?php the_title(); ?></div>

						</a>
					
					<?php
					/* if ( $post_count % 2 === 0 ) { ?></div><div class="card-deck"> <?php } */
					$post_count++;

				wp_reset_postdata();
			endforeach; ?>
		</div>
	</div>
	<div id="pathways-tab-detail" class="tab-content bg-light p-3">
		<?
		foreach ( $pathways as $key => $post ):
			$outer_post = $post; // save post context for after the nested loop
			setup_postdata( $post ); ?>
				<div id="pathway-content-<?php echo $key; ?>" class="tab-pane" aria-labelledby="pathway-tab-<?php echo $key; ?>" role="tabpanel">
					<h3>
						<?php the_title(); ?>
					</h3>
					<div class="row">
						<div class="col-md-8">
							<?php 
							echo get_the_content('');
							$focus_areas = get_field('pathway_focus_area_connection');
							if ( $focus_areas ) : ?>
								<h4 class="card-title">Focus Areas:</h4>
								<ul>
									<?php foreach ( $focus_areas as $post ) : ?>
										<?php setup_postdata( $post ); ?>
											<li><a href="<?php the_field('associated_department_url') ?>"><?php the_title(); ?></a></li>
										<?php wp_reset_postdata(); ?>
									<?php endforeach; ?>
								</ul>
								
							<?php endif; ?>
							
						</div>
						<?php $post = $outer_post; ?>
						<div class="col-md-4">
							<a href="<?php the_permalink(); ?>" class="btn btn-block btn-info">Learn More</a>
							<a href="https://www.bellevuecollege.edu/welcome/admission-advising/" class="btn btn-block btn-success">Get Started</a>
						</div>
					</div>
					
				</div>
				
				<?php
				/* if ( $post_count % 2 === 0 ) { ?></div><div class="card-deck"> <?php } */
				$post_count++;

			wp_reset_postdata();
		endforeach; ?>
	</div>
</div>