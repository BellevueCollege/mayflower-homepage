<?php 
$site_id = get_theme_mod( 'pathways_source_site' );
if ( $site_id ) : ?>
	<?php if ( ! is_null( get_site( $site_id ) ) ) : ?>
		<?php switch_to_blog( $site_id ); ?>
			<div class="container px-0 mt-3 bg-primary p-3">

				<div id="pathways-module">
					<div id="pathways-module-about" class="card">
						<h2 class="card-header h5">About BC Pathways</h2>
						<div class="card-body">
							<?php
								$front_page_id = (int)get_option( 'page_on_front' );
								$front_page = get_post( $front_page_id ); 
								$excerpt = get_the_excerpt( $front_page );
								echo $excerpt;
							?>
						</div>
					</div>
					<div id="pathways-card-zone">
						<div class="pathways-card-grid d-md-none">
							<?php get_template_part( 'parts/pathway-card-mobile' ); ?>
						</div>
						<?php get_template_part( 'parts/pathway-card-desktop' ); ?>
					</div>
				</div>
			</div>
		<?php restore_current_blog(); ?>
	<?php endif; ?>
<?php endif;