# Mayflower 'Homepage' Child Theme
Mayflower Child Theme to display custom Bellevue College homesite homepage.

## Custom Post Type
The new design is set up to use a CustomPress custom post type to support featured news and events on the homepage.

The following import files allow this to be created automatically- just make sure you have `define( 'CT_ALLOW_IMPORT', true );` in your `wp-config.php`.

### Post Type
```json
// Post Types Export code for CustomPress
global $CustomPress_Core;
$CustomPress_Core->import=array (
  'post_types' => 
  array (
    'featured' => 
    array (
      'labels' => 
      array (
        'name' => 'Featured News & Events',
        'singular_name' => 'Feature',
        'add_new_item' => 'Add New Feature',
        'edit_item' => 'Edit Feature',
        'new_item' => 'New Feature',
        'view_item' => 'Vew Feature',
        'search_items' => 'Search Featured News & Events',
        'not_found' => 'No Featured News & Events found',
        'not_found_in_trash' => 'No Featured News & Events found in Trash',
        'parent_item_colon' => 'Parent Feature: ',
      ),
      'supports' => 
      array (
        'title' => 'title',
        'editor' => 'editor',
        'author' => 'author',
        'thumbnail' => 'thumbnail',
        'revisions' => 'revisions',
      ),
      'supports_reg_tax' => 
      array (
        'category' => '',
        'post_tag' => '',
      ),
      'capability_type' => 'post',
      'map_meta_cap' => true,
      'description' => 'News and events featured on the Bellevue College homepage',
      'menu_position' => 5,
      'public' => true,
      'hierarchical' => false,
      'has_archive' => false,
      'rewrite' => 
      array (
        'with_front' => true,
        'feeds' => false,
        'pages' => true,
        'ep_mask' => 4668,
      ),
      'query_var' => true,
      'can_export' => true,
      'show_in_rest' => true,
      'rest_base' => 'featured',
      'cf_columns' => '',
      'capabilities' => 
      array (
        'create_posts' => 'create_posts',
      ),
      'menu_icon' => 'dashicons-layout',
    ),
  ),
);
```

### Taxonomy
```json
// Taxonomies Export code for CustomPress
global $CustomPress_Core;
$CustomPress_Core->import=array (
  'taxonomies' => 
  array (
    'feature_type' => 
    array (
      'object_type' => 
      array (
        0 => 'featured',
      ),
      'args' => 
      array (
        'labels' => 
        array (
          'name' => 'Feature Type',
          'add_new_item' => 'Add New Feature Type',
          'new_item_name' => 'New Feature Type',
          'edit_item' => 'Edit Feature Type',
          'update_item' => 'Update Feature Type',
          'search_items' => 'Search Feature Types',
          'popular_items' => 'Popular Feature Types',
          'all_items' => 'All Feature Types',
          'parent_item' => 'Parent Feature Type',
          'parent_item_colon' => 'Parent Feature Type:',
          'add_or_remove_items' => 'Add or remove feature types',
          'separate_items_with_commas' => 'Seperate feature types with commas',
          'choose_from_most_used' => 'Choose from most used feature types',
        ),
        'public' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'rewrite' => 
        array (
          'with_front' => true,
          'hierarchical' => false,
          'ep_mask' => 0,
        ),
        'query_var' => true,
        'capabilities' => 
        array (
          'manage_terms' => 'manage_categories',
          'edit_terms' => 'manage_categories',
          'delete_terms' => 'manage_categories',
          'assign_terms' => 'edit_posts',
        ),
      ),
    ),
  ),
);
```

### Custom Fields
```json
// Custom Fields Export code for CustomPress
global $CustomPress_Core;
$CustomPress_Core->import=array (
  'custom_fields' => 
  array (
    'text_5a15b9e1548df' => 
    array (
      'field_title' => 'Date or Date/Time',
      'field_wp_allow' => 0,
      'field_type' => 'text',
      'field_sort_order' => 'default',
      'field_date_format' => 'M d',
      'field_regex' => '',
      'field_regex_options' => '',
      'field_regex_message' => '',
      'field_message' => 'Date must be provided',
      'field_default_option' => NULL,
      'field_description' => 'Publish date for articles, or date/time or date/time range for events. This is an open text field- type dates using AP style.',
      'object_type' => 
      array (
        0 => 'featured',
      ),
      'hide_type' => 
      array (
      ),
      'field_required' => 1,
      'field_id' => 'text_5a15b9e1548df',
      'field_order' => 0,
    ),
    'text_5a15ba386625f' => 
    array (
      'field_title' => 'Link URL',
      'field_wp_allow' => 0,
      'field_type' => 'text',
      'field_sort_order' => 'default',
      'field_date_format' => '',
      'field_regex' => '',
      'field_regex_options' => '',
      'field_regex_message' => '',
      'field_message' => '',
      'field_default_option' => NULL,
      'field_description' => 'Enter the URL which you would like this featured area to link to from the homepage',
      'object_type' => 
      array (
        0 => 'featured',
      ),
      'hide_type' => 
      array (
      ),
      'field_required' => 0,
      'field_id' => 'text_5a15ba386625f',
      'field_order' => 1,
    ),
  ),
);
```
