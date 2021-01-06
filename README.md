# Mayflower 'Homepage' Child Theme
Mayflower Child Theme to display custom Bellevue College homesite homepage.

## Dependancies 

* The companion plugin to this theme is [bc-homepage-functionality](https://github.com/BellevueCollege/bc-homepage-functionality). This plugin provides several custom post types, as well as configurations for the Advanced Custom Fields (ACF) plugin.
* Advanced Custom Fields (ACF)

## Migration from v1.x to v2
Migrating from version 1.x to version 2 requires some large configuration changes to avoid
undue downtime of the BC homepage.

1. Copy existing Mayflower Homepage theme
2. Rename to something like mayflower-homepage-v1x
3. Modify theme name in style.css
4. Activate theme in Network Settings
5. In Customizer, switch to copy, and RECONFIGURE SETTINGS!
   * Reconfiguring these is critical, as the settings are linked to the theme, and will not come over to the new theme due to the different name
6. Activate CustomPress and import post types
7. Create empty page to serve as homepage
8. Create News, Events, and Deadlines Feature Types under Around Campus post type
9. Create initial events, news, and deadlines posts
10. Create initial content modules
11. Customizer
    1. Preview new homepage theme
    2. Set homepage as homepage
    3. Create menus and set them to appropriate theme locations
    4. On mayflower homepage, set everything except categories (not possible to set)
    5. Publish, refresh, return to same screen, and set categories.
       This should be the only period the homepage is partially broken.


