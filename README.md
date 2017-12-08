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
    'around_campus' => 
    array (
      'labels' => 
      array (
        'name' => 'Around Campus',
        'singular_name' => 'Around Campus feature',
        'add_new_item' => 'Add New Around Campus feature',
        'edit_item' => 'Edit Around Campus feature',
        'new_item' => 'New Around Campus feature',
        'view_item' => 'View Around Campus feature',
        'search_items' => 'Search Around Campus features',
        'not_found' => 'No Around Campus feature found',
        'parent_item_colon' => 'Parent Feature:',
        'custom_fields_block' => 'Options & Configuration',
      ),
      'supports' => 
      array (
        'title' => 'title',
        'editor' => 'editor',
        'author' => 'author',
        'thumbnail' => 'thumbnail',
        'revisions' => 'revisions',
        'page_attributes' => 'page-attributes',
      ),
      'supports_reg_tax' => 
      array (
        'category' => '',
        'post_tag' => '',
      ),
      'capability_type' => 'post',
      'map_meta_cap' => true,
      'description' => 'News and events featured on the Bellevue College homepage',
      'menu_position' => 6,
      'public' => true,
      'hierarchical' => true,
      'has_archive' => false,
      'rewrite' => 
      array (
        'with_front' => false,
        'feeds' => false,
        'pages' => false,
        'ep_mask' => 1,
      ),
      'query_var' => true,
      'can_export' => true,
      'show_in_rest' => true,
      'rest_base' => 'around_campus',
      'cf_columns' => 
      array (
        'text_5a15b9e1548df' => '1',
        'text_5a15ba386625f' => '1',
      ),
      'capabilities' => 
      array (
        'create_posts' => 'create_posts',
      ),
      'menu_icon' => 'dashicons-layout',
    ),
    'content_modules' => 
    array (
      'labels' => 
      array (
        'name' => 'Content Modules',
        'singular_name' => 'Content Module',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Module',
        'edit_item' => 'Edit Module',
        'new_item' => 'New Module',
        'view_item' => 'View Module',
        'search_items' => 'Search Modules',
        'not_found' => 'No modules found',
        'not_found_in_trash' => 'No modules found in Trash',
        'parent_item_colon' => 'Parent Module:',
        'custom_fields_block' => 'Module Options & Configuration',
      ),
      'supports' => 
      array (
        'title' => 'title',
        'editor' => 'editor',
        'author' => 'author',
        'thumbnail' => 'thumbnail',
        'revisions' => 'revisions',
        'page_attributes' => 'page-attributes',
      ),
      'supports_reg_tax' => 
      array (
        'category' => '',
        'post_tag' => '',
      ),
      'capability_type' => 'post',
      'map_meta_cap' => true,
      'description' => 'Content modules that are featured on the homepage.',
      'menu_position' => 5,
      'public' => true,
      'hierarchical' => true,
      'has_archive' => false,
      'rewrite' => 
      array (
        'with_front' => false,
        'feeds' => false,
        'pages' => false,
        'ep_mask' => 1,
      ),
      'query_var' => true,
      'can_export' => true,
      'show_in_rest' => false,
      'rest_base' => 'content_modules',
      'cf_columns' => 
      array (
        'radio_5a296fd821ba3' => '1',
        'text_5a15ba386625f' => '1',
      ),
      'capabilities' => 
      array (
        'create_posts' => 'create_posts',
      ),
      'menu_icon' => 'dashicons-grid-view',
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
        0 => 'around_campus',
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
          'search_items' => 'Search',
          'popular_items' => 'Popular Feature Types',
          'all_items' => 'All Feature Types',
          'parent_item' => 'Parent Feature Type',
          'parent_item_colon' => 'Parent Feature Type:',
          'add_or_remove_items' => 'Add or remove feature types',
          'separate_items_with_commas' => 'Seperate feature types with commas',
          'choose_from_most_used' => 'Choose from most used feature types',
        ),
        'public' => true,
        'show_admin_column' => true,
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
    'radio_5a296fd821ba3' => 
    array (
      'field_title' => 'Module Type',
      'field_wp_allow' => 0,
      'field_type' => 'radio',
      'field_sort_order' => 'default',
      'field_options' => 
      array (
        1 => 'Text',
        2 => 'Image Link',
        3 => 'Image Link with Button',
      ),
      'field_date_format' => '',
      'field_message' => 'A type must be selected!',
      'field_default_option' => '1',
      'field_description' => '',
      'object_type' => 
      array (
        0 => 'content_modules',
      ),
      'hide_type' => 
      array (
        0 => 'post',
      ),
      'field_required' => 1,
      'field_id' => 'radio_5a296fd821ba3',
      'field_order' => 0,
    ),
    'selectbox_5a2999d4a9f67' => 
    array (
      'field_title' => 'Module Width',
      'field_wp_allow' => 0,
      'field_type' => 'selectbox',
      'field_sort_order' => 'default',
      'field_options' => 
      array (
        1 => 'one-third',
        2 => 'two-thirds',
        3 => 'full',
      ),
      'field_date_format' => '',
      'field_message' => '',
      'field_default_option' => '1',
      'field_description' => 'Three column grid',
      'object_type' => 
      array (
        0 => 'content_modules',
      ),
      'hide_type' => 
      array (
      ),
      'field_required' => 1,
      'field_id' => 'selectbox_5a2999d4a9f67',
      'field_order' => 1,
    ),
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
        0 => 'around_campus',
      ),
      'hide_type' => 
      array (
      ),
      'field_required' => 1,
      'field_id' => 'text_5a15b9e1548df',
      'field_order' => 2,
    ),
    'text_5a15ba386625f' => 
    array (
      'field_title' => 'Link URL',
      'field_wp_allow' => 0,
      'field_type' => 'text',
      'field_sort_order' => 'default',
      'field_date_format' => '',
      'field_regex' => '^(?:http(s)?:\\/\\/)[\\w.-]+(?:\\.[\\w\\.-]+)+[\\w\\-\\._~:/?#[\\]@!\\$&\'\\(\\)\\*\\+,;=.]+$',
      'field_regex_options' => '',
      'field_regex_message' => 'This URL does not appear to be valid! Please make sure it starts with https://.',
      'field_message' => 'Please enter a URL',
      'field_default_option' => NULL,
      'field_description' => 'Enter the URL which you would like this featured area to link to from the homepage',
      'object_type' => 
      array (
        0 => 'around_campus',
        1 => 'content_modules',
      ),
      'hide_type' => 
      array (
      ),
      'field_required' => 0,
      'field_id' => 'text_5a15ba386625f',
      'field_order' => 3,
    ),
  ),
);
```
