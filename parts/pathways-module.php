<div class="container px-0 mt-5 bg-primary p-3">

	<div id="pathways-module">
		<div id="pathways-module-about" class="card">
			<h2 class="card-header h5">About Pathways</h2>
			<div class="card-body">
				<p class="card-text">Here is some info about Pathways!</p>
			</div>
		</div>
		<div id="pathways-card-zone">
			<?php 
			$site_id = get_theme_mod( 'pathways_source_site' );
			if ( $site_id ) : ?>
				<?php if ( ! is_null( get_site( $site_id ) ) ) : ?>
					<div class="pathways-card-grid d-md-none">
						<?php
						switch_to_blog( $site_id );
							get_template_part( 'parts/pathway-card-mobile' );
						restore_current_blog(); ?>
					</div>
					<?php
					switch_to_blog( $site_id );
						get_template_part( 'parts/pathway-card-desktop' );
					restore_current_blog(); ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>