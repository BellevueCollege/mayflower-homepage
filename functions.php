<?php
/**
 * Enqueue Child Theme Stylesheet
 */
add_action( 'wp_enqueue_scripts', 'mayflower_homepage_enqueue_styles' );
function mayflower_homepage_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/**
 * Override bc_footer function to add additional footer element
 */
function bc_footer() {
	global $bc_globals_html_filepath,
		$bc_globals_bfoot_filename,
		$bc_globals_legal_filename;

	$bc_footer =  $bc_globals_html_filepath . $bc_globals_bfoot_filename;
	$bc_footerlegal =  $bc_globals_html_filepath . $bc_globals_legal_filename;
	include_once($bc_footer);
	get_template_part( 'part-front-page-legal' );
	include_once($bc_footerlegal);
}
add_action('mayflower_footer', 'bc_footer', 50);


/**
 * Load Small Add Custom Post Type
 *
 * Note that this uses get_stylesheet_directory()
 * instead of get_template_directory(). This is needed
 * as this is a child theme.
 *
 */
if ( current_user_can('manage_network') ) {
	if( file_exists( get_stylesheet_directory() . '/inc/mayflower-bc-home/bc-home.php') ) {
		require( get_stylesheet_directory() . '/inc/mayflower-bc-home/bc-home.php');
	}
}

/* Adds a box to the main column on the Post and Page edit screens */
function add_global_section_meta_box() {
	global $post;
	if ( ! empty($post) && is_a($post, 'WP_Post') ) {
		if ("0" == $post->post_parent){
			$screens = array('page');
			foreach ($screens as $screen) {
				add_meta_box(
					'global_section_meta_box',
					'College Navigation Area',
					'global_section_meta_box',
					$screen,
					'normal',
					'low'
				);
			}
		}
	}

}

/**
 * Prevent Class from being added to body
 *
 * Overrides this function within Mayflower
 *
 */

function mayflower_body_class_ia( $classes ) {
	return $classes;
}
add_filter( 'body_class','mayflower_body_class_ia' );


/**
 * Register Menu Locations on Homepage
 *
 */
function register_mayflower_homepage_menus() {
	register_nav_menus(
		array(
			'front_page_legal' => __( 'Front Page Legal Links' )
		)
	);
}
add_action( 'init', 'register_mayflower_homepage_menus' );

/**
 * Register our sidebars and widgetized areas on Homepage
 *
 */
function mayflower_homepage_widgets_init() {

	register_sidebar( array(
		'name'          => 'Homepage Menus Area',
		'id'            => 'home_menus_area',
		'before_widget' => '<section class="col-xs-12 box-shadow">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mayflower_homepage_widgets_init' );


/**
 * Theme Settings area
 *
 * Configuration for Mayflower Homepage settings area
 * in the customizer
 */
function mayflower_homepage_customize_register( $wp_customize ) {

	/**
	 * Load all categories into array
	 *
	 * From http://josephfitzsimmons.com/adding-a-select-box-with-categories-into-wordpress-theme-customizer/
	 */
	function get_categories_select() {
		$teh_cats = get_categories();
		$results;
		$count = count($teh_cats);
		for ( $i=0; $i < $count; $i++ ) {
			if (isset($teh_cats[$i]))
				$results[$teh_cats[$i]->slug] = $teh_cats[$i]->name;
			else
				$count++;
		}
		return $results;
	}

	/**
	 * Data Validation
	 *
	 */
	function sanitize_int( $input ) {
		return (int)$input;
	}

	$wp_customize->add_section( 'mayflower_homepage_options' , array(
		'title'      => __( 'Mayflower Homepage ', 'mayflower-homepage' ),
		'priority'   => 300,
	) );
	$wp_customize->add_setting( 'news_site_id' , array(
		'default'           => '63',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_int',
	) );
	$wp_customize->add_setting( 'news_category_name' , array(
		'default'           => 'BC Homepage',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'events_category' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'apply_btn_html' , array(
		'default'           => '<a href="//www.bellevuecollege.edu/admissions/?utm_source=bchomepage&utm_medium=button&utm_campaign=applybtn" class="btn btn-block btn-success"><strong>Apply</strong>for admission</a>',
		'transport'         => 'refresh',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'news_site_id', array(
		'label'        => __( 'News Site ID', 'mayflower-homepage' ),
		'description'  => __( 'ID of site from which to draw homepage news section' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'news_site_id',
		'type'         => 'number',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'news_category_name', array(
		'label'        => __( 'News Category Name', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage news section' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'news_category_name',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'events_category', array(
		'label'        => __( 'Events Category', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage events' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'events_category',
		'type'         => 'select',
		'choices'  => get_categories_select( ),
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'apply_btn_html', array(
		'label'        => __( 'Apply Button HTML', 'mayflower-homepage' ),
		'description'  => __( 'HTML for Homepage Apply Button' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'apply_btn_html',
		'type'         => 'textarea',
	) ) );
}
add_action( 'customize_register', 'mayflower_homepage_customize_register' );
