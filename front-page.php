<?php
/**
 * Front Page Template File
 *
 * Loads Custom BC Homepage Template
 *
 */
get_header(); ?>

<?php
define('NEWS_WEBSITE_ID', 63);
define('NEW_CATEGORY_NAME', "BC Homepage");
?>

<div class="content-row transparent" id="content">
    <ul id="mobilelinks" class="clearfix">
        <li><a href="//www.bellevuecollege.edu/location/maps/" class="btn btn-info">Maps</a></li>
        <li><a href="//www.bellevuecollege.edu/location/directions/" class="btn btn-info">Directions</a></li>
        <li><a href="//www.bellevuecollege.edu/contacts/" class="btn btn-info">Contact Us</a></li>
    </ul><!--#mobilelinks -->

    <section class="box-shadow" id="menusfor">
        <div class="content-padding">
            <h2>Menus for:</h2>
            <ul>
                <li><a href="//www.bellevuecollege.edu/students/">Students</a></li>
                <li><a href="//www.bellevuecollege.edu/future/">Future Students</a></li>
                <li><a href="//www.bellevuecollege.edu/oiegi/">International Students</a></li>
                <li><a href="//www.bellevuecollege.edu/employees/">Faculty &amp; Staff</a></li>
                <li><a href="//www.bellevuecollege.edu/businesses/">Businesses</a></li>
                <li><a href="//www.bellevuecollege.edu/visitors/">Visitors &amp; Community</a></li>
            </ul>
        </div>
	</section><!--#menusfor-->

	<section id="homeslider">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php
		//display featured slider
		get_template_part('parts/featured-full');
		?>
    </section><!--#homeslider-->
</div><!--#content .row-->

<div class="content-row">
    <section id="home-news">
        <header class="content-padding">
			<h2>News &amp; Announcements</h2>
        </header>
        <div class="content-padding">
            <ul>
                <?php
                if ( is_multisite() )
                {
                global $switched;
                switch_to_blog(NEWS_WEBSITE_ID); //switched to the news site
                    $the_query = new WP_Query(array(
                        'post_type'=>'post',
                        'category_name' => NEW_CATEGORY_NAME,
                        'orderby'=> 'date',
                        'order'=> 'DESC',
                        'posts_per_page' => 3,
                    ));
                    while ( $the_query->have_posts() ) :
                    $the_query->the_post(); ?>
									<li><a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
									<?php endwhile;
									// wp_reset_postdata();
									restore_current_blog(); }
									?>
									<li><a class="more" href="//www.bellevuecollege.edu/news/"><strong>More news...</strong><span class="arrow"></span></a></li>
									</ul>
        </div><!--.content-padding-->
	</section>
	<section id="home-events">
        <header class="content-padding">
                  <h2>Events</h2>
        </header>
    	<div class="content-padding">
			<ul>
				<?php
                    $the_query = new WP_Query(array(
                        'post_type'=>'post',
                        'category_name' => 'events',
                        'orderby'=> 'date',
                        'order'=> 'ASC',
                    ));

                    while ( $the_query->have_posts() ) :
                    $the_query->the_post();
                ?>
                <!-- begin event listing -->
                <li><a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                <!-- end event listing -->
                <?php
                    endwhile;
                        wp_reset_postdata();
                ?>

                <li><a class="more" href="//www.bellevuecollege.edu/events"><strong>More events...</strong></a></li>
                <li><a id="calendar" href="//www.bellevuecollege.edu/enrollment/calendar/"><strong>Academic Calendar</strong></a> </li>
        	</ul>
    	</div><!--.content-padding-->
	</section><!--#home-events-->
	<div id="home-sidelinks">
		<p id="apply" ><a href="//www.bellevuecollege.edu/admissions/?utm_source=bchomepage&utm_medium=button&utm_campaign=applybtn" class="btn btn-success"><strong>Apply</strong>for admission</a></p>
		<?php
			$the_query = new WP_Query(array(
				'post_type'=>'small_ad',
				'orderby'=> 'rand',
				'order'=> 'ASC',
				'posts_per_page' => 1,
			));

			while ( $the_query->have_posts() ) :
			$the_query->the_post();

	        // If url field has content, add the URL to the post thumbnail.
				$small_ad_ext_url = get_post_meta( $post->ID, '_small_ad_url', true );

		        if ( !empty( $small_ad_ext_url ) ){ ?>
                    <p id="homead">
                        <a href="<?php echo esc_url($small_ad_ext_url);?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('home-small-ad', array('class' => 'box-shadow img-responsive'));?></a>
                    </p>
			<?php }  //end if ?>

		<?php
			endwhile;
				wp_reset_postdata();
		?>
	</div><!--#home-sidelinks-->
</div><!-- .content-row -->

<?php endwhile; else: ?>
<p><?php _e('Sorry, these aren\'t the bytes you are looking for.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
