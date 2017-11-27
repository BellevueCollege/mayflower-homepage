<?php

/**
 * Enqueue Child Theme Stylesheet
 */
add_action( 'wp_enqueue_scripts', 'mayflower_homepage_enqueue_styles' );
function mayflower_homepage_enqueue_styles() {

	// Enqueue parent theme stylesheet
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

	// Degregister default stylesheet
	wp_deregister_style( 'mayflower' );

	// Then add it again, using theme version number
	wp_register_style( 'mayflower', get_stylesheet_uri(), array( 'parent-style' ), wp_get_theme()->get( 'Version' ) );

	// enqueue it again
	wp_enqueue_style( 'mayflower' );

}

/*
 * Define Image Sizes
 */

add_image_size( 'mfhomepage-card-background', 760, 260, true );

/**
 * Override bc_footer function to add additional footer element
 */
function bc_footer() {
	global $bc_globals_html_filepath,
		$bc_globals_bfoot_filename,
		$bc_globals_legal_filename;

	$bc_footer = $bc_globals_html_filepath . $bc_globals_bfoot_filename;
	$bc_footerlegal = $bc_globals_html_filepath . $bc_globals_legal_filename;
	include_once( $bc_footer );
	get_template_part( 'part-front-page-legal' );
	include_once( $bc_footerlegal );
}
add_action( 'mayflower_footer', 'bc_footer', 50 );


/**
 * Load Small Add Custom Post Type
 *
 * Note that this uses get_stylesheet_directory()
 * instead of get_template_directory(). This is needed
 * as this is a child theme.
 *
 */
if ( current_user_can( 'manage_network' ) ) {
	if ( file_exists( get_stylesheet_directory() . '/inc/mayflower-bc-home/bc-home.php' ) ) {
		require( get_stylesheet_directory() . '/inc/mayflower-bc-home/bc-home.php' );
	}
}

/* Adds a box to the main column on the Post and Page edit screens */
function add_global_section_meta_box() {
	global $post;
	if ( ! empty( $post ) && is_a( $post, 'WP_Post' ) ) {
		if ( '0' === $post->post_parent ) {
			$screens = array( 'page' );
			foreach ( $screens as $screen ) {
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
			'mfhomepage_menus_for' => __( 'Front Page - Top Left' ),
			'mfhomepage_resources' => __( 'Front Page - Top Center' ),
			'mfhomepage_contact'   => __( 'Front Page - Top Right' ),
			'front_page_legal'     => __( 'Front Page - Legal Links' ),
		)
	);
}
add_action( 'init', 'register_mayflower_homepage_menus' );

//////////
// Front Page Menu Walker - Button Groups!
/////////
class MFHomepage_Walker extends Walker_Nav_Menu {

	// Displays start of an element. E.g '<li> Item Name'
	// @see Walker::start_el()
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$object = $item->object;
		$type = $item->type;
		$title = $item->title;
		$description = $item->description;
		$permalink = $item->url;
		//$output .= '<pre>' . print_r($item, true) . '</pre>';

		if ( ! in_array( 'menu-item-has-children', $item->classes ) && 0 == $depth ) {
			$output .= "<a class='btn btn-default " . implode( ' ', $item->classes ) . "' href='$permalink'>";
			$output .= $title;

		} elseif ( $depth > 0 ) {
			$output .= "<li><a href='$permalink'>$title";
		} else {
			$output .= '<div class="btn-group " role="group">';
			$output .= '<a class="btn btn-default dropdown-toggle ' . implode( ' ', $item->classes ) . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$output .= $title;
			$output .= ' <span class="caret"></span>';
			$output .= '</a>';
		}

	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( ! in_array( 'menu-item-has-children', $item->classes ) && 0 == $depth ) {
			$output .= '</a>';

		} elseif ( $depth > 0 ) {
			$output .= '</a></li>';
		} else {
			$output .= '</div>';
		}
	}
	function start_lvl( &$output, $depth, $args = array() ) {
		$output .= '<ul class="dropdown-menu dropdown-menu-right">';
	}
	function end_lvl( &$output, $depth, $args = array() ) {
		$output .= '</ul>';
	}

}

function mfhomepage_get_menu_name( $location ) {
	$menu_name = $location;
	$locations = get_nav_menu_locations();
	$menu_id = $locations[ $menu_name ] ;
	$menu_object = wp_get_nav_menu_object( $menu_id );
	return $menu_object->name;
}









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
	 * Inspired by http://josephfitzsimmons.com/adding-a-select-box-with-categories-into-wordpress-theme-customizer/
	 * but modified to use foreach loop for simplicity
	 */
	function get_categories_select( $taxonomy = 'category' ) {
		$results;
		$categories;
		if ( '' == $taxonomy ) {
			$categories = get_categories();
		} else {
			$categories = get_categories( array(
				'taxonomy' => $taxonomy,
			) );
		}
		foreach ( $categories as $cat ) {
			$results[ $cat->slug ] = $cat->name;
		}
		return $results;
	}

	function get_taxonomy_select() {
		$results;
		$taxonomies = get_taxonomies();

		foreach ( $taxonomies as $taxonomy ) {
			$results[ $taxonomy ] = $taxonomy;
		}
		return $results;
	}

	function get_cpt_select() {
		$results;
		$cpts = get_post_types();

		foreach ( $cpts as $cpt ) {
			$results[ $cpt ] = $cpt;
		}
		return $results;
	}

	/**
	 * Data Validation
	 *
	 */
	function sanitize_int( $input ) {
		return (int) $input;
	}

	$wp_customize->add_section( 'mayflower_homepage_options' , array(
		'title'      => __( 'Mayflower Homepage ', 'mayflower-homepage' ),
		'priority'   => 300,
	) );

	$wp_customize->add_setting( 'featured_post_type' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'featured_post_type_taxonomy' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'featured_post_type_date_field' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'featured_post_type_link_field' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_setting( 'news_category' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'events_category' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'deadlines_category' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_post_type', array(
		'label'        => __( 'Featured Post Type', 'mayflower-homepage' ),
		'description'  => __( 'Custom Post Type from which to pull featured items', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'featured_post_type',
		'type'         => 'select',
		'choices'      => get_cpt_select(),
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_post_type_taxonomy', array(
		'label'        => __( 'Featured Post Taxonomy', 'mayflower-homepage' ),
		'description'  => __( 'Taxonomy to be used to choose where things are featured', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'featured_post_type_taxonomy',
		'type'         => 'select',
		'choices'      => get_taxonomy_select(),
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_post_type_date_field', array(
		'label'        => __( 'Date Field', 'mayflower-homepage' ),
		'description'  => __( 'Custom field to be used for feature dates', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'featured_post_type_date_field',
		'type'         => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_post_type_link_field', array(
		'label'        => __( 'URL field', 'mayflower-homepage' ),
		'description'  => __( 'Custom field to be used for featured item URLs', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'featured_post_type_link_field',
		'type'         => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'news_category', array(
		'label'        => __( 'News Category', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage events. Select and save taxonomy selection first.', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'news_category',
		'type'         => 'select',
		'choices'      => get_categories_select( get_theme_mod( 'featured_post_type_taxonomy' ) ),
		''
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'events_category', array(
		'label'        => __( 'Events Category', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage events. Select and save taxonomy selection first.', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'events_category',
		'type'         => 'select',
		'choices'      => get_categories_select( get_theme_mod( 'featured_post_type_taxonomy' ) ),
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'deadlines_category', array(
		'label'        => __( 'Deadlines Category', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage upcoming deadlines. Select and save taxonomy selection first.', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'deadlines_category',
		'type'         => 'select',
		'choices'      => get_categories_select( get_theme_mod( 'featured_post_type_taxonomy' ) ),
	) ) );
}
add_action( 'customize_register', 'mayflower_homepage_customize_register' );



/* Shortcodes for boxes on homepage */
function mfhomepage_content_module_shortcode( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'link_url'       => '#',
		'background_img' => 'none',
		'button'         => false,

	), $atts );
	return '<a href="' . esc_url( $a['link_url'] ) .
		   '" class="mfhomepage-content-module ' .
		   ( $a['button'] ? 'mfhomepage-button' : '' ) . '" style="background-image: url(' .
		   esc_url( $a['background_img'] ) . ')"><div>' . $content . '</div></a>';
}
add_shortcode( 'mfhomepage-content-module', 'mfhomepage_content_module_shortcode' );
