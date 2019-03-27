<?php
/**
 * Front Page Template File
 *
 * Loads Custom BC Homepage Template
 *
 */
get_header(); ?>

<h1 class="sr-only" id="content"><?php esc_html_e( 'Welcome to Bellevue College', 'mayflower-homepage' ) ?></h1>
<section id="mfhomepage-top-menus" class="container no-padding">
	<div id="mfhomepage-menus-for">
		<h2 class="top-menu-title"><?php echo esc_textarea( mfhomepage_get_menu_name( 'mfhomepage_menus_for' ) ); ?></h2>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'mfhomepage_menus_for',
			'menu_class'     => 'mfhomepage-menus-for',
			'container'      => false,
			'depth'          => 2,
			'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
			'walker'         => new MFHomepage_Walker(),
		) );
		?>
	</div>
	<div id="mfhomepage-resources">
		<h2 class="top-menu-title"><?php echo esc_textarea( mfhomepage_get_menu_name( 'mfhomepage_resources' ) ); ?></h2>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'mfhomepage_resources',
			'menu_class'     => 'mfhomepage-resources',
			'container'      => false,
			'depth'          => 2,
			'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
			'walker'         => new MFHomepage_Walker(),
		) );
		?>
	</div>
	<div id="mfhomepage-contact">
		<h2 class="top-menu-title sr-only"><?php echo esc_textarea( mfhomepage_get_menu_name( 'mfhomepage_contact' ) ); ?></h2>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'mfhomepage_contact',
			'menu_class'     => 'mfhomepage-contact',
			'container'      => false,
			'depth'          => 2,
			'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
			'walker'         => new MFHomepage_Walker(),
		) );
		?>
	</div>
</section>

	
<section id="homeslider" class="container-fluid no-padding">
	<?php get_template_part( 'parts/featured-full' ); ?>
</section><!--#homeslider-->


<?php if ( 'page' == get_option( 'show_on_front' ) && have_posts() ) :
	while ( have_posts() ) : the_post(); ?>
		<?php
		/**
		* Prevent Empty Container from loading if there is no content
		*/
		if ( '' !== $post->post_content ) : ?>
			<section id="mfhomepage-content" class="container">
				<?php the_content(); ?>
			</section>
		<?php endif; ?>
	
	<?php endwhile; ?>
<?php endif; ?>

<?php
$the_query = new WP_Query( array(
	'post_type'      => get_theme_mod( 'modules_post_type' ),
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'posts_per_page' => 6,
));

if ( $the_query->have_posts() ) : ?>
	<section class="container no-padding">
		<div id="mfhomepage-modules">
			<?php while ( $the_query->have_posts() ) :
				$the_query->the_post();

				// Load variables
				$module_type       = get_post_meta( get_the_ID(), get_theme_mod( 'module_type_field' ), true );
				$module_link       = ( get_post_meta( get_the_ID(), get_theme_mod( 'newsevents_post_type_link_field' ), true ) ?: '#' );
				$module_width      = get_post_meta( get_the_ID(), get_theme_mod( 'module_width_field' ), true );
				$module_background = get_the_post_thumbnail_url( get_the_ID(), 'mfhomepage-module-background' );

				// Build module CSS classes
				$module_classes    = 'mfhomepage-content-module ';
				switch ( $module_width ) {
					case 'one-third':
						$module_classes .= 'mfhomepage-content-module-1 ';
						break;
					case 'two-thirds':
						$module_classes .= 'mfhomepage-content-module-2 ';
						break;
					case 'full':
						$module_classes .= 'mfhomepage-content-module-3 ';
						break;
				}
				?>

				<?php if ( 'Text' === $module_type ) : ?>

					<div class="<?php echo esc_attr( $module_classes ) ?>">
						<h2><?php the_title() ?></h2>
						<div class="content-module-text">
							<?php the_content(); ?>
						</div>
					</div>

				<?php elseif ( 'Image Link' === $module_type ) : ?>

					<a href="<?php echo esc_url( $module_link ) ?>" class="responsive-bg-img <?php echo esc_attr( $module_classes ) ?>">
						<?php
						$img_id = get_post_thumbnail_id(get_the_ID());
						$img_alt = get_post_meta($img_id , '_wp_attachment_image_alt', true);
						?>
						<img srcset="<?php the_post_thumbnail_url( 'mfhomepage-module-sm' ); ?> 380w,
									<?php the_post_thumbnail_url( 'mfhomepage-module-lg' ); ?> 768w,
									<?php the_post_thumbnail_url( 'mfhomepage-module-sm' ); ?> 380w"
							sizes="(max-width: 380x) 380px,
									(max-width: 768px) 768px,
									380px"
							src="<?php the_post_thumbnail_url( 'mfhomepage-module-lg' ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">

						<div><?php the_content() ?></div>
					</a>
					
				<?php elseif ( 'Image Link with Button' === $module_type ) : ?>

					<a href="<?php echo esc_url( $module_link ) ?>" class="responsive-bg-img <?php echo esc_attr( $module_classes ) ?> mfhomepage-content-module-btn">
						<?php
						$img_id = get_post_thumbnail_id(get_the_ID());
						$img_alt = get_post_meta($img_id , '_wp_attachment_image_alt', true);
						?>
						<img srcset="<?php the_post_thumbnail_url( 'mfhomepage-module-sm' ); ?> 380w,
									<?php the_post_thumbnail_url( 'mfhomepage-module-lg' ); ?> 768w,
									<?php the_post_thumbnail_url( 'mfhomepage-module-sm' ); ?> 380w"
							sizes="(max-width: 380x) 380px,
									(max-width: 768px) 768px,
									380px"
							src="<?php the_post_thumbnail_url( 'mfhomepage-module-lg' ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">

						<div><?php the_content() ?></div>
					</a>

				<?php elseif ( 'Full Size Content (Embeds, etc)' === $module_type ) : ?>

					<div class="<?php echo esc_attr( $module_classes ) ?> mfhomepage-content-module-embed">
						<?php the_content(); ?>
					</div>

				<?php else : ?>
					<!-- Error: Missing post type! -->
				<?php endif; ?>

			<?php endwhile; ?>
		</div>
	</section>
<?php
endif;
wp_reset_postdata();
?>

<section id="mfhomepage-news-events-container">
	<div id="mfhomepage-news-events" class="container no-padding">
		<?php $the_query = new WP_Query( array(
			'post_type'      => get_theme_mod( 'newsevents_post_type' ),
			'tax_query' => array(
				array(
					'taxonomy' => get_theme_mod( 'newsevents_post_type_taxonomy' ),
					'field'    => 'slug',
					'terms'    => get_theme_mod( 'news_category' ),
				),
			),
			'orderby'        => 'menu_order',
			'order'          => 'DSC',
			'posts_per_page' => 1,
		) ); ?>
		<section id="mfhomepage-news">
			<h2>In the news</h2>
			
			<?php while ( $the_query->have_posts() ) :
				$the_query->the_post();

				if ( has_post_thumbnail() ) : ?>
					<a href="<?php echo esc_url(
						get_post_meta( get_the_ID(), get_theme_mod( 'newsevents_post_type_link_field' ), true )
					); ?>" class="news-card mfhomepage-card">
						<div class="responsive-bg-img card-heading">
							<?php
							$img_id = get_post_thumbnail_id(get_the_ID());
							$img_alt = get_post_meta($img_id , '_wp_attachment_image_alt', true);
							?>
							<img srcset="<?php the_post_thumbnail_url( 'mfhomepage-card-sm' ); ?> 380w,
										<?php the_post_thumbnail_url( 'mfhomepage-card-lg' ); ?> 768w,
										<?php the_post_thumbnail_url( 'mfhomepage-card-sm' ); ?> 380w"
								sizes="(max-width: 380x) 380px,
										(max-width: 991px) 768px,
										380px"
								src="<?php the_post_thumbnail_url( 'mfhomepage-module-lg' ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">

							<div class="card-title">
								<h3><?php the_title(); ?></h3>
							</div>
						</div>
						<div class="card-content">
							<?php
							$mfhomepage_post_content        = get_the_content( '' );
							$mfhomepage_remove_content_tags = wp_strip_all_tags( $mfhomepage_post_content, true );
							$mfhomepage_content_trimmed     = wp_trim_words( $mfhomepage_remove_content_tags, 25, '...' );

							if ( ! empty( $mfhomepage_post_content ) ) { ?>
								<p>
									<?php echo esc_textarea(
										get_post_meta( get_the_ID(), get_theme_mod( 'newsevents_post_type_date_field' ), true )
									); ?>&ndash;
									<?php echo $mfhomepage_content_trimmed; ?>
								</p>
							<?php } ?>
						</div>
					</a>
				<?php endif; ?>
			<?php endwhile; ?>
			<div class="mfhomepage-more-btn-group text-right">
				<a class="btn btn-default" href="https://www.bellevuecollege.edu/news/">More on BC Today</a>
			</div>
		</section>
		<section id="mfhomepage-events-deadlines">
			<h2>Happening around campus</h2>
			<?php
			$the_query = new WP_Query( array(
				'post_type'      => get_theme_mod( 'newsevents_post_type' ),
				'tax_query' => array(
					array(
						'taxonomy' => get_theme_mod( 'newsevents_post_type_taxonomy' ),
						'field'    => 'slug',
						'terms'    => get_theme_mod( 'deadlines_category' ),
					),
				),
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'posts_per_page' => 3,
			));

			if ( $the_query->have_posts() ) : ?>
				<div id="mfhomepage-deadlines">
					<?php while ( $the_query->have_posts() ) :
						$the_query->the_post(); ?>
						<a href="<?php echo esc_url(
							get_post_meta( get_the_ID(), get_theme_mod( 'newsevents_post_type_link_field' ), true )
						); ?>" class="deadlines-card mfhomepage-card">
							<div class="card-heading">
								<div class="card-icon"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span></div>
								<div class="card-title">
									<h3><?php echo esc_textarea(
										get_post_meta( get_the_ID(), get_theme_mod( 'newsevents_post_type_date_field' ), true )
									); ?></h3>
								</div>
							</div>
							<div class="card-content">
								<h4><?php the_title(); ?></h4>
								<?php
								$mfhomepage_post_content        = get_the_content( '' );
								$mfhomepage_remove_content_tags = wp_strip_all_tags( $mfhomepage_post_content, true );
								$mfhomepage_content_trimmed     = wp_trim_words( $mfhomepage_remove_content_tags, 25, '...' );

								if ( ! empty( $mfhomepage_post_content ) ) { ?>
									<p>
										<?php echo $mfhomepage_content_trimmed; ?>
									</p>
								<?php } ?>
							</div>
						</a>
						<!-- end event listing -->
					<?php
					endwhile; ?>
				</div>
			<?php
			endif;
			wp_reset_postdata();
			?>
			
			<?php
			$the_query = new WP_Query( array(
				'tax_query' => array(
					array(
						'taxonomy' => get_theme_mod( 'newsevents_post_type_taxonomy' ),
						'field'    => 'slug',
						'terms'    => get_theme_mod( 'events_category' ),
					),
				),
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'posts_per_page' => 3,
			));

			if ( $the_query->have_posts() ) : ?>
				<div id="mfhomepage-events">
					<?php while ( $the_query->have_posts() ) :
						$the_query->the_post(); ?>
						<a href="<?php echo esc_url(
							get_post_meta( get_the_ID(), get_theme_mod( 'newsevents_post_type_link_field' ), true )
						); ?>" class="events-card mfhomepage-card">
							<div class="card-heading">
								<div class="card-icon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
								<div class="card-title">
									<h3><?php echo esc_textarea(
										get_post_meta( get_the_ID(), get_theme_mod( 'newsevents_post_type_date_field' ), true )
									); ?></h3>
								</div>
							</div>
							<div class="card-content">
								<h4><?php the_title(); ?></h4>
								<?php
								$mfhomepage_post_content        = get_the_content( '' );
								$mfhomepage_remove_content_tags = wp_strip_all_tags( $mfhomepage_post_content, true );
								$mfhomepage_content_trimmed     = wp_trim_words( $mfhomepage_remove_content_tags, 25, '...' );

								if ( ! empty( $mfhomepage_post_content ) ) { ?>
									<p>
										<?php echo esc_textarea( $mfhomepage_content_trimmed ); ?>
									</p>
								<?php } ?>
							</div>
						</a>
						<!-- end event listing -->
					<?php
					endwhile; ?>
				</div>
			<?php
			endif;
			wp_reset_postdata();
			?>

			<div class="mfhomepage-more-btn-group text-right">
				<a class="btn btn-default" href="https://www.bellevuecollege.edu/studentcentral/calendar/">Academic Calendar</a> 
				<a class="btn btn-default" href="https://www.bellevuecollege.edu/events/">Events Calendar</a>
			</div>
		</section>
	</div>
</section>

<?php get_footer(); ?>
