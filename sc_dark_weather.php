<?php
/*
Plugin Name: SC Dark Weather
Plugin URI: https://github.com/Surfing-Chef/Dark
Description: Uses a wrapper to display a weather feed from Darksky.net
Version: 1.2
Author: Surfing-Chef
Author URI: https://github.com/Surfing-Chef
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: sc-dark-weather
*/
?>

<?php
/*
Hooks provide you with a way to insert your code directly into the Wordpress code. A hook is a PHP function call that occurs when a specific event occurs.

Action hooks execute a function when a specific event occurs. This is how you create an action hook: add_action( $actionToHookTo, $functionToCall, $priority, $howManyArguments );

A list of all the Wordpress actions can be seen here http://codex.wordpress.org/Plugin_API/Action_Reference

Here are the most common action hooks and when they occur:

* admin_head: Occur in the head for the dashboard

* admin_init: Occurs when the dashboard has loaded

* comment_post: Occurs when a new comment is created

* create_category: Occurs when a category is created

* init: Occurs when Wordpress has loaded the website

* publish_post: Occurs when a new post is published

* switch_theme: Occurs when the theme is changed

* user_register: Occurs when a new user registers

* wp_footer: Occurs in the footer

* wp_head: Occurs in the header

Filter hooks change content in Wordpress before it is either displayed on the screen or when it is saved in the database. You create filters by passing identical arguments to add_filter(). Here is an example: add_filter( $actionToHookTo, $functionToCall, $priority, $howManyArguments );

Here are the most common filter hooks:

* comment_text: Changes comments before they are displayed

* get_categories: Changes category lists

* the_content: Changes the content of a post or page

* the_content_rss: Changes content of posts in RSS feeds

* the_permalink: Changes the permalink

* the_title: Changes the title of posts and pages

* wp_title: Changes the text in the title tag

You can retrieve the location of your plugin like this
plugin_dir_path( __FILE__ );
__FILE__ is a reference to the file that is running

Here is the location of your images folder
plugins_url( 'images/YOUR_IMAGE.png' , __FILE__ );
*
*/
?>

<?php
// Sets up all of the default options for all the variables needed
function sc_dark_weather_install()
{

  $sc_defaults_array = array( 'sc_title' => 'SC Dark Weather', 'sc_api' => '', 'sc_longitude' =>'', 'sc_latitude' =>'' );

  update_option( 'sc_defaults', $sc_defaults_array );

}
// END of function: sc_dark_weather_install
?>

<?php
// Create a widget by extending the WP_Widget class
class sc_dark_weather extends WP_Widget
{

  /**
	* This constructor function initializes the widget
  *
	* This constructor function initializes the widget. It sets the class
	* name for the tag that surrounds the widget. It sets the description
	* that is found in the widget admin section of Wordpress. Calls the parent
	* class constructor for further initialization
  *
	* classname: class name added to the widgets li tag
	* description: describes the widget on the widget admin page
	* __() allows for translation of the text
  *
	*/

	// Constructor initializes the widget
	function sc_dark_weather()
  {
		$widget_options = array(
			'classname' => 'sc_dark_weather',
			'description' => __( 'Displays a Darksky weather feed' ),
		);
		parent::WP_Widget( 'sc_dark_weather', 'SC Darksky Weather Display', $widget_options );
	}
  // END of function: sc_dark_weather

	/**
	 * Outputs the content of the widget
   * arguments sent from the theme / instance of the class is sent
   *
   * Default Values for special tags found below
   * 'before_widget' => '<li id="%1$s" class="widget %2$s">',
   * 'after_widget' => "</li>n",
   * 'before_title' => '<h2 class="widgettitle">',
   * 'after_title' => "</h2>n"
   *
   * $title : Contains the title that shows up in the sidebar
   * $facebook : Contains the Facebook ID the user choose
   * $twitter: Contains the Twitter ID the user choose
   *
	 *
	 * @param array $args
	 * @param array $instance
   *
	 */

   // Output the content of the widget
  function widget( $args, $instance )
  {
    // Splits arguments out and makes them local variables. EXTR_SKIP
    // protects any already created local variables
		extract( $args, EXTR_SKIP );

    // Here if a title is set use it. If not use the default title
    $sc_title = ( get_option( 'sc_title' ) ) ? get_option( 'sc_title' ) : '';

		$sc_api = ( get_option( 'sc_api' ) ) ? get_option( 'sc_api' ) : '';

		$sc_longitude = ( get_option( 'sc_longitude' ) ) ? get_option( 'sc_longitude' ) : '';

    $sc_latitude = ( get_option( 'sc_latitude' ) ) ? get_option( 'sc_latitude' ) : '';


    // $before_widget, $after_widget, etc are used for theme compatibility

    ?>

<?php echo $before_widget; ?>
<?php echo $before_title . $sc_title . $after_title; ?>

<?php
      // php
      ?>

  <h3><?php echo $sc_title; ?></h3>
  <span><?php echo $sc_api; ?></span><br />
  <span><?php echo $sc_longitude; ?></span><br />
  <span><?php echo $sc_latitude; ?></span><br />

<?php echo $after_widget; ?>

<?php
	}
  // END of function widget( $args, $instance )


  /**
   * Processing widget options on save
   * Pass the new widget values contained in $new_instance and update saves
   * everything for you
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   */

   // Process widget options on save
  function update( $new_instance, $old_instance )
  {
    $instance = $old_instance;

		$instance['sc_title'] = strip_tags( $new_instance['sc_title'] );
		$instance['sc_api'] = strip_tags( $new_instance['sc_api'] );
		$instance['sc_longitude'] = strip_tags( $new_instance['sc_longitude'] );
    $instance['sc_latitude'] = strip_tags( $new_instance['sc_latitude'] );

		return $instance;
  }
  // END of function update( $new_instance, $old_instance )

	/**
	 * Displays options in the widget admin section of site
	 *
	 * @param array $instance The widget options
	*/

  // Displays options in the widget admin section
  function form($instance)
  {
    // Set all of the default values for the widget
    $defaults = array( 'sc_title' => 'SC Darksky Weather Options', 'sc_api' => '', 'sc_longitude' => '', 'sc_latitude' => '' );

    // Grab any widget values that have been saved and merge them into an
    // array with wp_parse_args
    $instance = wp_parse_args( (array) $instance, $defaults );
    $sc_title = $instance['sc_title'];
    $sc_api = $instance['sc_api'];
    $sc_longitude = $instance['sc_longitude'];
    $sc_latitude = $instance['sc_latitude'];

    ?>

    <!-- Create the form elements needed to set the widget values
    esc_attr() scrubs potentially harmful text -->
    <p>Title: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'sc_title' ); ?>" type="text" value="<?php echo esc_attr( $sc_title ); ?>" /></p>

    <p>API Token: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'sc_api' ); ?>" type="text" value="<?php echo esc_attr( $sc_api ); ?>" /></p>

    <p>Longitude: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'sc_longitude' ); ?>" type="text" value="<?php echo esc_attr( $sc_longitude ); ?>" /></p>

    <p>Latitude: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'sc_latitude' ); ?>" type="text" value="<?php echo esc_attr( $sc_latitude ); ?>" /></p>

<?php

    settings_fields( 'sc_dark_weather_vars' );

    update_option( 'sc_title', $sc_title );
    update_option( 'sc_api', $sc_api );
    update_option( 'sc_longitude', $sc_longitude );
    update_option( 'sc_latitude', $sc_latitude );

	}
  //END of function form($instance)

}
// End class sc_dark_weather creation

// Register a new widget to be used in a theme
function sc_dark_weather_init ()
{
  register_widget('sc_dark_weather');
}
// END of function sc_dark_weather_init ()

// Create the variable optionss needed for the plugin and settings page
function sc_register_options()
{
  // Allows access to widget options from any other function
  register_setting( 'sc_dark_weather_vars', 'sc_title' );
  register_setting( 'sc_dark_weather_vars', 'sc_api' );
  register_setting( 'sc_dark_weather_vars', 'sc_longitude' );
  register_setting( 'sc_dark_weather_vars', 'sc_latitude' );
}
// END of function sc_register_options()

// Create the settings page for the plugin
function sc_dark_weather_settings ()
{
  ?>

  <div>
    <h1><?php _e( 'SC Darksky Weather Options', 'sc_dark_weather' ); ?></h1>

    <form method="post" action="options.php">

      <?php settings_fields( 'sc_dark_weather_vars' ); ?>

      <span><?php _e('Title:', 'sc_dark_weather'); ?></span>
      <input type="text" name="sc_title" value="<?php echo get_option('sc_title') ?>" /><br />

      <span><?php _e('API Token:', 'sc_dark_weather'); ?></span>
      <input type="text" name="sc_api" value="<?php echo get_option('sc_api') ?>" /><br />

      <span><?php _e('Longitude:', 'sc_dark_weather'); ?></span>
      <input type="text" name="sc_longitude" value="<?php echo get_option('sc_longitude') ?>" /><br />

      <span><?php _e('Latitude:', 'sc_dark_weather'); ?></span>
      <input type="text" name="sc_latitude" value="<?php echo get_option('sc_latitude') ?>" /><br />

      <input type="submit" value="<?php  _e( 'Submit', sc_dark_weather) ?>">
    </form>
  </div>

  <?php

}
// END function sc_dark_weather_settings ()

// Create a top-level menu item in the left sidebar
function sc_dark_weather_create_menu ()
{
  // add_menu_page creates a top level menu in the left sidebar
  // add_menu_page(titleOfPage, titleInSidebar, whoCanUseThis, __FILE__,
  // functionThisCalls, logo)
  // whoCanUseThis : manage_options means only admins can use this
  add_menu_page( 'SC Darksky Weather', 'Darksky Settings', 'administrator', __FILE__, 'sc_dark_weather_settings', plugins_url( 'images/sc-dark-weather-sm-logo.png', __FILE__ ) );
}
// End of function sc_dark_weather_create_menu()

// Creates a submenu in the left sidebar under Settings
// function sc_dark_weather_create_submenu ()
// {
//   // add_options_page creates a submenu in the left sidebar under Settings
//   // where options specifies desired location of settings button
//   // see comments directly following function
//   add_options_page( 'SC Darksky Weather', 'Darksky Settings', 'administrator', __FILE__, 'sc_dark_weather_settings' );
// }
// End of function sc_dark_weather_create_submenu()

/* You can also add submenus to the other menus. add_dashboard_page, add_posts_page, add_media_page, add_links_page, add_pages_page, add_comments_page, add_theme_page, add_plugins_page, add_users_page
*/

// Create a shortcode capability for the plugin
// function sc_dark_weather_sc ( $atts )
// {
//   // Splits arguments out and makes them local variables.
//   $atts = shortcode_atts(
//     array(
//       "sc_api"=>get_option('sc_api'),
//       "sc_longitude"=>get_option('sc_longitude'),
//       "sc_latitude"=>get_option('sc_latitude')
//     ), $atts, 'scdarkweather');
//
//   return get_option('sc_api');
//
// }
// End of the function sc_dark_weather_sc

// Attaches a rule that tells wordpress to call my function when widgets are
// initialized
add_action('widgets_init', 'sc_dark_weather_init');

// Creates a top level menu in your dashboards left sidebar
add_action( 'admin_menu', 'sc_dark_weather_create_menu' );

// Create a submenu item under settings
// add_action( 'admin_menu', 'sc_dark_weather_create_submenu' );

// Call the function that we create all of the options for the plugin being
// title, facebook and twitter
add_action( 'admin_init', 'sc_register_options' );

// Allows this plugin to be used with a shortcode
//add_shortcode( 'scdarkweather', 'sc_dark_weather_sc' );
?>
