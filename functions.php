<?php

/**
 * Enqueue Child Theme Stylesheet
 */
add_action( 'wp_enqueue_scripts', 'mayflower_homepage_enqueue_styles' );
function mayflower_homepage_enqueue_styles() {

	// Enqueue parent theme stylesheet
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('globals'));

	// Degregister default stylesheet
	wp_deregister_style( 'mayflower' );

	// Then add it again, using theme version number
	wp_register_style( 'mayflower', get_stylesheet_uri(), array( 'parent-style' ), wp_get_theme()->get( 'Version' ) );

	// enqueue it again
	wp_enqueue_style( 'mayflower' );
	
	if ( is_front_page() ) {

		// Script creates title array to hold carousel titles for next button
		$the_query = new WP_Query( array(
			'post_type'=>'mhcarousel',
			'orderby'=> 'menu_order',
			'order'=> 'ASC',
			'posts_per_page' => mayflower_get_option( 'slider_number_slides' ),
		));

		// Build inline script
		$carousel_posts_array = '';
		if ( $the_query->have_posts() ) {
			$carousel_posts_array .= 'var carousel_posts = [';
			while ( $the_query->have_posts() ) {
				$the_query->the_post(); 
				$carousel_posts_array .= "'" . get_the_title( get_the_ID() ) . "', ";
			}
			$carousel_posts_array .=  "];";
		}

		wp_enqueue_script( 'mhcarousel-script', get_stylesheet_directory_uri() . '/js/mhcarousel.js', array('jquery'), '3.0.1' ); //added jquery because jquery was called after the scripts
		wp_add_inline_script( 'mhcarousel-script', $carousel_posts_array, 'before' );
	}
}

/*
 * Define Image Sizes
 */


add_action( 'after_setup_theme', 'mfhomepage_theme_setup' );
function mfhomepage_theme_setup() {
	add_image_size( 'mfhomepage-card-sm', 380, 250, true );
	add_image_size( 'mfhomepage-card-lg', 768, 250, true );

	add_image_size( 'mfhomepage-module-sm', 380, 180, true );
	add_image_size( 'mfhomepage-module-lg', 768, 180, true );


	add_image_size( 'mfhomepage-carousel-lg', 1680, 350, false );
	add_image_size( 'mfhomepage-carousel-md', 992, 350, true );
	add_image_size( 'mfhomepage-carousel-sm', 475, 350, true );
}
/**
 * Override bc_footer function to add additional footer element
 */
function bc_footer() {
	$globals = new Globals();

	$globals->big_footer();
	get_template_part( 'part-front-page-legal' );
	$globals->footer_legal();
}
add_action( 'mayflower_footer', 'bc_footer', 50 );

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
			$output .= "<a class='btn btn-outline-dark " . implode( ' ', $item->classes ) . "' href='$permalink'>";
			$output .= $title;

		} elseif ( $depth > 0 ) {
			$output .= "<a class='dropdown-item' href='$permalink'>$title";
		} else {
			$output .= '<div class="btn-group " role="group">';
			$output .= '<a href="#" class="btn btn-outline-dark dropdown-toggle ' . implode( ' ', $item->classes ) . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$output .= $title;
			$output .= ' <span class="caret"></span>';
			$output .= '</a>';
		}

	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( ! in_array( 'menu-item-has-children', $item->classes ) && 0 == $depth ) {
			$output .= '</a>';

		} elseif ( $depth > 0 ) {
			$output .= '</a>';
		} else {
			$output .= '</div>';
		}
	}
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<div class="dropdown-menu dropdown-menu-right">';
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</div>';
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

	$wp_customize->add_setting( 'modules_post_type' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_setting( 'module_type_field' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_setting( 'module_width_field' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_setting( 'newsevents_post_type' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'newsevents_post_type_taxonomy' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'newsevents_post_type_date_field' , array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'newsevents_post_type_link_field' , array(
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

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'modules_post_type', array(
		'label'        => __( 'Homepage Modules', 'mayflower-homepage' ),
		'description'  => __( 'Custom Post Type from which to pull featured items', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'modules_post_type',
		'type'         => 'select',
		'choices'      => get_cpt_select(),
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'module_type_field', array(
		'label'        => __( 'Module Type Custom Field', 'mayflower-homepage' ),
		'description'  => __( 'Custom field to be used to select module type', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'module_type_field',
		'type'         => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'module_width_field', array(
		'label'        => __( 'Module Width Custom Field', 'mayflower-homepage' ),
		'description'  => __( 'Custom field to be used to select module width', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'module_width_field',
		'type'         => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'newsevents_post_type', array(
		'label'        => __( 'Around Campus Post Type', 'mayflower-homepage' ),
		'description'  => __( 'Custom Post Type from which to pull featured news/events', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'newsevents_post_type',
		'type'         => 'select',
		'choices'      => get_cpt_select(),
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'newsevents_post_type_taxonomy', array(
		'label'        => __( 'Around Campus Post Taxonomy', 'mayflower-homepage' ),
		'description'  => __( 'Taxonomy to be used to choose where things are featured', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'newsevents_post_type_taxonomy',
		'type'         => 'select',
		'choices'      => get_taxonomy_select(),
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'newsevents_post_type_date_field', array(
		'label'        => __( 'Date Field', 'mayflower-homepage' ),
		'description'  => __( 'Custom field to be used for feature dates', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'newsevents_post_type_date_field',
		'type'         => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'newsevents_post_type_link_field', array(
		'label'        => __( 'URL field', 'mayflower-homepage' ),
		'description'  => __( 'Custom field to be used for featured item URLs', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'newsevents_post_type_link_field',
		'type'         => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'news_category', array(
		'label'        => __( 'News Category', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage events. Select and save taxonomy selection first.', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'news_category',
		'type'         => 'select',
		'choices'      => get_categories_select( get_theme_mod( 'newsevents_post_type_taxonomy' ) ),
		''
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'events_category', array(
		'label'        => __( 'Events Category', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage events. Select and save taxonomy selection first.', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'events_category',
		'type'         => 'select',
		'choices'      => get_categories_select( get_theme_mod( 'newsevents_post_type_taxonomy' ) ),
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'deadlines_category', array(
		'label'        => __( 'Deadlines Category', 'mayflower-homepage' ),
		'description'  => __( 'Category from which to draw homepage upcoming deadlines. Select and save taxonomy selection first.', 'mayflower-homepage' ),
		'section'      => 'mayflower_homepage_options',
		'settings'     => 'deadlines_category',
		'type'         => 'select',
		'choices'      => get_categories_select( get_theme_mod( 'newsevents_post_type_taxonomy' ) ),
	) ) );
}
add_action( 'customize_register', 'mayflower_homepage_customize_register' );

/* Add Gutenberg Support for All Taxonomies */
function sb_add_taxes_to_api() {
	$taxonomies = get_taxonomies( '', 'objects' );

	foreach( $taxonomies as $taxonomy ) {
		$taxonomy->show_in_rest = true;
	}
}
add_action( 'init', 'sb_add_taxes_to_api', 30 );
