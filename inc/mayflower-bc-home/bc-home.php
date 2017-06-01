<?php

########################################
## - Hide Page Links to in Small Ad posts
########################################

add_filter( 'page-links-to-post-types', 'remove_plt_from_small_ad' );

function remove_plt_from_small_ad( $post_types )
{
    $key = array_search( 'small_ad',  $post_types );
    if( $key !== false ) {
        unset($post_types[$key]);
    }

    return $post_types;
}


#################################
// Small Ads Custom Post Type
#################################

if ( current_user_can('manage_network') ) {

	// Register Custom Post Type
	function small_home_ad() {

		$labels = array(
			'name'                => 'Small Ads',
			'singular_name'       => 'Small Ad',
			'menu_name'           => 'Small Ads',
			'parent_item_colon'   => 'Parent Small Ad',
			'all_items'           => 'All Small Ads',
			'view_item'           => 'View Small Ad',
			'add_new_item'        => 'Add New Small Ad',
			'add_new'             => 'New Small Ad',
			'edit_item'           => 'Edit Small Ad',
			'update_item'         => 'Update Small Ad',
			'search_items'        => 'Search Small Ads',
			'not_found'           => 'No Small Ads found',
			'not_found_in_trash'  => 'No Small Ads found in trash',
		);
		$args = array(
			'label'               => 'small_ad',
			'description'         => 'Small Ads for college home page',
			'labels'              => $labels,
            'supports' 	  		  => array('title', 'editor', 'thumbnail', 'category', 'revisions'),
			'taxonomies' 		  => array(/*'category', 'post_tag',*/), // this is IMPORTANT
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			//'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'small_ad', $args );

	}

	// Hook into the 'init' action
	add_action( 'init', 'small_home_ad', 0 );

} // end current_user_can


///////////////////////////////////////
// Custom Columns for Small Ad Post type
///////////////////////////////////////

// Add to admin_init function
add_filter('manage_edit-small_ad_columns', 'add_small_ad_columns');

function add_small_ad_columns($small_ad_columns) {
		$small_ad_columns = array (
		'cb' => '<input type="checkbox" />',
		'thumbnail' => 'Featured Image',
		'title' => 'Title',
		'small_ad_link_to' => 'Link to URL',
	);
//remove unwanted default columns
		unset($small_ad_columns['author']);
		unset($small_ad_columns['comments']);

		return $small_ad_columns;
	}

// Add to admin_init function
	add_action('manage_small_ad_posts_custom_column', 'manage_small_ad_columns', 10, 2);

	function manage_small_ad_columns($column, $post_id) {
	global $post;

	switch( $column ) {

		    case 'thumbnail':
					echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
					break;

			case 'small_ad_link_to':

				/* Get the post meta. */
				$small_ad_ext_url = get_post_meta( $post->ID, '_small_ad_url', true );
					echo $small_ad_ext_url;
					break;
			default:

				} //end switch

			} //end function


/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'add_small_ad_ext_url_mb' );
add_action( 'load-post-new.php', 'add_small_ad_ext_url_mb' );


///////////////////////////////////////
// Add Meta Box for External URL
///////////////////////////////////////

// Add the Meta Box
function add_small_ad_ext_url_mb() {
    add_meta_box(
		'small_ad_external_url', // $id
		'Link to URL', // $title
		'show_small_ad_ext_url', // $callback
		'small_ad', // $post_type
		'normal', // $context
		'high') // $priority
;}
add_action('add_meta_boxes', 'add_small_ad_ext_url_mb');

// Field Array
$prefix = '_small_ad_';
$bchome_custom_meta_fields = array(
	array(
		'label'=> 'Small Ad URL',
		'desc'	=> '',
		'id'	=> $prefix.'url',
		'type'	=> 'url'
	),
);

// The Callback
function show_small_ad_ext_url() {
global $bchome_custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($bchome_custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);

        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // case items will go here
					case 'url':
					    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="' . esc_url($meta) . '" size="30" class="widefat" placeholder="http://" />
					        <br /><span class="description">'.$field['desc'].'</span>';
						echo '<p>Enter the URL associated with this ad.</p>';
					break;

                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_small_ad_custom_meta($post_id) {
    global $bchome_custom_meta_fields;

	// verify nonce
	if ( !isset( $_POST['custom_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['custom_meta_box_nonce'], basename( __FILE__ ) ) )
		return $post_id;


	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	// loop through fields and save the data
	foreach ($bchome_custom_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_small_ad_custom_meta');
