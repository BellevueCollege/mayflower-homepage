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
<div id="pathways-desktop-module" class="d-none">
	<button id="pathways-grid-view" class="btn btn-primary"><i class="fas fa-grip-vertical" aria-hidden="true"></i><span class="sr-only">Return to Grid View</span></button>
	<button id="pathways-scroll-back" class="btn btn-primary"><i class="fas fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Move to Previous Tab</span></button>
	<div id="pathways-tab-scroll-zone">
		<div id="pathways-scrolling-grid" class="nav nav-tabs" role="tablist">
			<?
			foreach ( $pathways as $key => $post ):
				setup_postdata( $post ); ?>
					<a id="pathway-tab-<?php echo $key; ?>" 
					   class="mb-0 pathways-card-desktop pathways-card-tab"
					   data-toggle="tab"
					   role="tab"
					   aria-controls="pathway-content-<?php echo $key; ?>" 
					   aria-selected="false" 
					   href="#pathway-content-<?php echo $key; ?>">
						<?php the_post_thumbnail( 'bcgpt-card-small', ['aria-hidden' => 'true'] ); ?>
						<div>
							<p><?php the_title(); ?></p>
						</div>

					</a>
					
					<?php

				wp_reset_postdata();
			endforeach; ?>
		</div>
		
	</div>
	<button id="pathways-scroll-forward" class="btn btn-primary"><i class="fas fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Move to Next Tab</span></button>
	<div id="pathways-tab-detail" class="tab-content bg-light p-3">
		<?php
		foreach ( $pathways as $key => $post ):
			$outer_post = $post; // save post context for after the nested loop
			setup_postdata( $post ); ?>
				<div id="pathway-content-<?php echo $key; ?>" class="tab-pane" aria-labelledby="pathway-tab-<?php echo $key; ?>" role="tabpanel">
					<h3>
						<?php the_title(); ?>
					</h3>
					<div class="row">
						<div class="col-md-12">
							<?php the_excerpt(); ?>
						</div>
						<?php $post = $outer_post; ?>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-4">
							<a href="<?php the_permalink(); ?>" class="btn btn-block btn-info">Learn More<br><small>About This Pathway</small></a>
						</div>
						<div class="col-md-4">
							<a class="btn btn-block btn-primary" href="https://www.bellevuecollege.edu/advising/pathways-workshops/">Sign Up Now<br><small>BC Pathways Workshop</small></a>
						</div>
					</div>
				</div>
				
				<?php

			wp_reset_postdata();
		endforeach; ?>
	</div>
</div>