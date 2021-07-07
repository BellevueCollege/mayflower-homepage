<?php
$post_count = 1;
$pathways = get_posts( array(
	'post_type'   => 'bcgpt-pathway',
	'numberposts' => -1,
	'orderby'     => 'title',
	'order'       => 'ASC',
)); 

/**
 * Mobile format (fully functional)
 */
foreach ( $pathways as $key => $post ):
	setup_postdata( $post ); ?>
		<div id="pathway-card-<?php echo $key; ?>" class="card mb-3 pathways-card">
			<?php if ( has_post_thumbnail() ) { ?>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'bcgpt-card-small', ['class' => 'card-img-top'] ); ?>
				</a>
			<?php } ?>
			<div class="card-header">
				<h3 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<button class="btn btn-info btn-sm float-right my-0 ml-0" type="button" data-toggle="collapse" data-target="#card-collapse-body-<?php echo $key; ?>" aria-expanded="false" aria-controls="card-collapse-body-<?php echo $key; ?>"><i class="fas fa-chevron-down"></i><span class="sr-only">More about the <?php the_title(); ?> pathway</span></button>
			</div>
			<div class="card-body collapse" id="card-collapse-body-<?php echo $key; ?>">
				<?php the_excerpt(); ?>
				
				<?php
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
				<hr>
				<a href="<?php the_permalink(); ?>" class="btn btn-block btn-info">Learn More</a>
				<a href="https://www.bellevuecollege.edu/welcome/admission-advising/" class="btn btn-block btn-primary">Get Started</a>
				
			</div>

		</div>
		
		<?php
		/* if ( $post_count % 2 === 0 ) { ?></div><div class="card-deck"> <?php } */
		$post_count++;

	wp_reset_postdata();
endforeach;
