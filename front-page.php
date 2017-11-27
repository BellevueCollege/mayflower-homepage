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

	
<section id="homeslider" class="containe-fluid no-padding">
	<?php get_template_part( 'parts/featured-full' ); ?>
</section><!--#homeslider-->


<?php if ( 'page' == get_option( 'show_on_front' ) && have_posts() ) :
	while ( have_posts() ) : the_post(); ?>
		<?php
		/**
		* Prevent Empty Container from loading if there is no content
		*/
		if ( $post->post_content != '' ) : ?>
			<section id="mfhomepage-content" class="container no-padding">
				<?php the_content(); ?>
			</section>
		<?php endif; ?>
	
	<?php endwhile; ?>
<?php endif; ?>


<section id="mfhomepage-news-events-container">
	<div id="mfhomepage-news-events" class="container no-padding">
		<?php $the_query = new WP_Query( array(
			'post_type'      => get_theme_mod( 'featured_post_type' ),
			'tax_query' => array(
				array(
					'taxonomy' => get_theme_mod( 'featured_post_type_taxonomy' ),
					'field'    => 'slug',
					'terms'    => get_theme_mod( 'news_category' ),
				),
			),
			'orderby'        => 'date',
			'order'          => 'DES',
			'posts_per_page' => 1,
		) ); ?>
		<section id="mfhomepage-news">
			<h2>In the news</h2>
			
			<?php while ( $the_query->have_posts() ) :
				$the_query->the_post();

				if ( has_post_thumbnail() ) : ?>
					<a href="<?php echo esc_url(
							get_post_meta( get_the_ID(), get_theme_mod( 'featured_post_type_link_field' ), true )
							); ?>" class="news-card mfhomepage-card">
						<div class="card-heading" style="background-image: url('<?php the_post_thumbnail_url( 'featured-full' ) ?>')">
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
										get_post_meta( get_the_ID(), get_theme_mod( 'featured_post_type_date_field' ), true )
									); ?>&ndash;
									<?php echo esc_textarea( $mfhomepage_content_trimmed ); ?>
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
				'post_type'      => get_theme_mod( 'featured_post_type' ),
				'tax_query' => array(
					array(
						'taxonomy' => get_theme_mod( 'featured_post_type_taxonomy' ),
						'field'    => 'slug',
						'terms'    => get_theme_mod( 'deadlines_category' ),
					),
				),
				'orderby'        => 'date',
				'order'          => 'ASC',
				'posts_per_page' => 3,
			));

			if ( $the_query->have_posts() ) : ?>
				<div id="mfhomepage-deadlines">
					<?php while ( $the_query->have_posts() ) :
						$the_query->the_post(); ?>
						<a href="<?php echo esc_url(
							get_post_meta( get_the_ID(), get_theme_mod( 'featured_post_type_link_field' ), true )
							); ?>" class="deadlines-card mfhomepage-card">
							<div class="card-heading">
								<div class="card-icon"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span></div>
								<div class="card-title">
									<h3><?php echo esc_textarea(
										get_post_meta( get_the_ID(), get_theme_mod( 'featured_post_type_date_field' ), true )
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
			
			<?php
			$the_query = new WP_Query( array(
				'tax_query' => array(
					array(
						'taxonomy' => get_theme_mod( 'featured_post_type_taxonomy' ),
						'field'    => 'slug',
						'terms'    => get_theme_mod( 'events_category' ),
					),
				),
				'orderby'        => 'date',
				'order'          => 'ASC',
				'posts_per_page' => 3,
			));

			if ( $the_query->have_posts() ) : ?>
				<div id="mfhomepage-events">
					<?php while ( $the_query->have_posts() ) :
						$the_query->the_post(); ?>
						<a href="<?php echo esc_url(
							get_post_meta( get_the_ID(), get_theme_mod( 'featured_post_type_link_field' ), true )
							); ?>" class="events-card mfhomepage-card">
							<div class="card-heading">
								<div class="card-icon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
								<div class="card-title">
									<h3><?php echo esc_textarea(
										get_post_meta( get_the_ID(), get_theme_mod( 'featured_post_type_date_field' ), true )
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
				<a class="btn btn-default" href="https://www.bellevuecollege.edu/events/">All Campus Events</a>
			</div>
		</section>
	</div>
</section>

<?php get_footer(); ?>
