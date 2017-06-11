<?php
/*
Plugin Name: SC Dark Weather
Plugin URI: https://github.com/Surfing-Chef/Dark
Description: Uses a wrapper to display a weather feed from Darksky.net
Version: 1.5
Author: Surfing-Chef
Author URI: https://github.com/Surfing-Chef
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: sc-dark-weather
*/

// Exit if accessed directly
defined( 'ABSPATH' ) or die( "Error: contact admin@surfing-chef.com" );

// Sets up all of the default options for all the variables needed
function sc_dark_weather_install()
{

  // Here if a title is set use it. If not use the default title
  $sc_title = ( get_option( 'sc_title' ) ) ? get_option( 'sc_title' ) : '';

  $sc_api = ( get_option( 'sc_api' ) ) ? get_option( 'sc_api' ) : '';

  $sc_longitude = ( get_option( 'sc_longitude' ) ) ? get_option( 'sc_longitude' ) : '';

  $sc_latitude = ( get_option( 'sc_latitude' ) ) ? get_option( 'sc_latitude' ) : '';


  $sc_defaults_array = array(
    'sc_title'      => $sc_title,
    'sc_api'        => $sc_api,
    'sc_longitude'  => $sc_longitude,
    'sc_latitude'   => $sc_latitude
  );

  update_option( 'sc_defaults', $sc_defaults_array );

}
// END of function: sc_dark_weather_install

// Create a widget by extending the WP_Widget class
class sc_dark_weather extends WP_Widget
{
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

    ?>

<?php echo $before_widget; ?>
<?php echo $before_title . $sc_title . $after_title; ?>


  <h3>Title loaded: <?php echo $sc_title; ?></h3>
  <span>API loaded: <?php echo $sc_api; ?></span><br />
  <span>Longitude loaded: <?php echo $sc_longitude; ?></span><br />
  <span>Latitude loaded: <?php echo $sc_latitude; ?></span><br />

<?php echo $after_widget; ?>

<?php
	}
  // END of function widget( $args, $instance )

  // Displays options in the widget admin section
  function form($instance)
  {
    // Set all of the default values for the widget
    $sc_defaults = array( 'sc_title' => 'SC Darksky Weather Options', 'sc_api' => '', 'sc_longitude' => '', 'sc_latitude' => '' );

    // Grab any widget values that have been saved and merge them into an
    // array with wp_parse_args
    $instance = wp_parse_args( (array) $instance, $sc_defaults );
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

}
// End class sc_dark_weather creation

// Register a new widget to be used in a theme
function sc_dark_weather_init()
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
function sc_dark_weather_settings()
{
  ?>

  <div>
    <h3><?php _e( 'SC Darksky Weather Options', 'sc_dark_weather' ); ?></h3><br>

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

      <input type="submit" value="<?php _e( 'Submit', 'sc_dark_weather') ?>">
    </form>
  </div>

<?php

}
// END function sc_dark_weather_settings ()

// Create a top-level menu item in the left sidebar
function sc_dark_weather_create_menu()
{
  add_menu_page( 'SC Darksky Weather', 'Darksky Settings', 'administrator', __FILE__, 'sc_dark_weather_settings', plugins_url( 'images/sc-dark-weather-sm-logo.png', __FILE__ ) );
}
// End of function sc_dark_weather_create_menu()

// Create a shortcode capability for the plugin
function sc_dark_weather_sc( $atts )
{
  global $sc_dark_weather_vars;

  // Splits arguments out and makes them local variables.
  $atts = shortcode_atts(
    array(
      "sc_api"=>get_option('sc_api'),
      "sc_longitude"=>get_option('sc_longitude'),
      "sc_latitude"=>get_option('sc_latitude')
    ), $atts, 'scdarkweather');

    $sc_display = "<span>API loaded: " . $atts['sc_api'] . "</span><br />";
    $sc_display .=  "<span>Longitude loaded: " . $atts['sc_longitude'] . "</span><br />";
    $sc_display .=  "<span>Latitude:  loaded: " . $atts['sc_latitude'] . "</span><br />";

  return   $sc_display;

}
// End of the function sc_dark_weather_sc

// Add a display shortcode to plugin
function sc_display_weather_sc ()
{
  require 'sc_dark_weather_display.php';

  $sc_page = new SC_Dark_Weather_Display;

  echo $sc_page->sc_weather_output();
};
// End of the function sc_display_weather_sc

// Attaches a rule that tells wordpress to call my function when widgets are
// initialized
add_action('widgets_init', 'sc_dark_weather_init');

// Creates a top level menu in your dashboards left sidebar
add_action( 'admin_menu', 'sc_dark_weather_create_menu' );

// Call the function that we create all of the options for the plugin being
// title, facebook and twitter
add_action( 'admin_init', 'sc_register_options' );

// Allows this plugin to be used with a shortcode
add_shortcode( 'scdarkweather', 'sc_dark_weather_sc' );

// Trial shortcode
add_shortcode( 'sc_dark_weather', 'sc_display_weather_sc' );
