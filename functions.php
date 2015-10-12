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
