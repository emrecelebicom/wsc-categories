<?php
/**
 * Plugin Name: Wordpress Sidebar Categories
 * Plugin URI: https://turkeymediaworks.com/wordpress-sidebar-categories/
 * Description: Multiple instances can be installed with different Wordpress categories showing in each widget installation.
 * Version: 0.0.1
 * Developer: Turkey Media Works
 * Developer URI: https://turkeymediaworks.com/
 * 
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/*
* Load the all defines.
*/

define( 'WSC_VERSION', '0.0.1' );

/*
* Load the plugin's functions.
*/

require_once plugin_dir_path( __FILE__ ) . 'includes/wsc-header.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/wsc-widget.php';


 /* Shortcode */
 function sidebar_categories_function()
 {
    return "Hello World!";
 }

 add_shortcode('sidebar_categories', 'sidebar_categories_function');

 /* Menu */
 function wsc_admin_menu_option()
 {
   add_menu_page('WSC Categories', 'WSC Categories', 'manage_options', 'wsc-categories', 'wsc_scripts_page', 'dashicons-shortcode', 200);
 }

 add_action('admin_menu', 'wsc_admin_menu_option');

 /* Content */
 function wsc_scripts_page()
{
   echo '<div class="wrapper">';
   wsc_header_menu();
   echo "</div>";

   echo '<div class="wrapper">';
   echo "<h1>İÇERİK</h1>";
   echo "</div>";
}

/* Content Print */
function wsc_display_content()
{
  print get_option('wsc_header', 'none');
}

//add_action('wp_head', 'wsc_display_content');

wp_enqueue_style( 'styles', plugin_dir_url( __FILE__ ) . 'assets/css/app.css', [], wp_get_theme()->get( 'Version' ), 'all' );


/* Widget */
function register_wsc_widget()
{
    register_widget("WSC_Widget");
}

add_action("widgets_init", "register_wsc_widget");
