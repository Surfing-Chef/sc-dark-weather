<?php
/**
 * Plugin Name: SC Dark Weather
 * Plugin URI: https://github.com/Surfing-Chef/sc-dark-weather
 * Description: Creates a widget to display a weather forecast from Darksky.net
 * Version: 1.6
 * Author: Surfing-Chef
 * Author URI: https://github.com/Surfing-Chef
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: sc-new-widget
*/
class SCDW extends WP_Widget {

  // Registers basic widget information
  public function __construct()
  { /**
     * Constructor creates the widget id, widget name
     * and widget options
    */
    $widget_options = array(
      'classname' => 'sc_dark_weather',
      'description' => 'This widget displays a Darksky weather forecast.',
    );
    parent::__construct( 'sc_dark_weather', 'SC Dark Weather', $widget_options );
  }

  // Generates the actual content displayed by the widget
  public function widget( $args, $instance )
  { /**
     * $args[]: this variable loads an array of arguments which can be used when building widget output.
     * The values contained in $args are set by the active theme when the sidebar region is registered.
     * $instance[]: this variable loads values associated with the current instance of the widget.
     * If a widget is added twice each $instance would hold the values specific to each instance of the widget.
     * widget_title filter: returns the title of the current widget instance
    */

    // Use of 'before_widget', 'after_widget', 'before_title', and 'after_title' arguments
    // ensures each widget is nested inside the theme-specific HTML tags.
    // The $title filter and injection is optional
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];

    // Place calls to classes and functions that will display the forecast here

    // leave this line alone too
    echo $args['after_widget'];
  }

  // Adds setting fields to the widget which will be displayed
  // in the WordPress admin area
  public function form( $instance )
  { /**
     * Check the current instance information to see if the title is empty. If it isn’t, the current title gets displayed.
    */
    $title = ! empty( $instance['scdw_title'] ) ? $instance['scdw_title'] : '';
    $token = ! empty( $instance['scdw_token'] ) ? $instance['scdw_token'] : '';
    $latitude = ! empty( $instance['scdw_latitude'] ) ? $instance['scdw_latitude'] : '';
    $longitude = ! empty( $instance['scdw_longitude'] ) ? $instance['scdw_longitude'] : ''; ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'scdw_title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'scdw_title' ); ?>" name="<?php echo $this->get_field_name( 'scdw_title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'scdw_token' ); ?>">Token:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'scdw_token' ); ?>" name="<?php echo $this->get_field_name( 'scdw_token' ); ?>" value="<?php echo esc_attr( $token ); ?>" />
    <p>
    </p>
      <label for="<?php echo $this->get_field_id( 'scdw_latitude' ); ?>">Latitude:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'scdw_latitude' ); ?>" name="<?php echo $this->get_field_name( 'scdw_latitude' ); ?>" value="<?php echo esc_attr( $latitude ); ?>" />
    <p>
    </p>
      <label for="<?php echo $this->get_field_id( 'scdw_longitude' ); ?>">Longitude:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'scdw_longitude' ); ?>" name="<?php echo $this->get_field_name( 'scdw_longitude' ); ?>" value="<?php echo esc_attr( $longitude ); ?>" />
    </p><?php
  }

  // Update the information in the WordPress database
  public function update( $new_instance, $old_instance )
  { /**
     * $new_instance contains the values added to the widget settings form
     * $old_instance contains the existing settings — if any exist
     * Grab values from the new instance,
     * strip away any HTML or PHP tags that may have added to the values,
     * assign new values to the instance,
     * return the updated instance.
    */
    $instance = $old_instance;

    $instance[ 'scdw_title' ] = strip_tags( $new_instance[ 'scdw_title' ] );
    $instance[ 'scdw_token' ] = strip_tags( $new_instance[ 'scdw_token' ] );
    $instance[ 'scdw_latitude' ] = strip_tags( $new_instance[ 'scdw_latitude' ] );
    $instance[ 'scdw_longitude' ] = strip_tags( $new_instance[ 'scdw_longitude' ] );

    return $instance;
  }
}

// Register the Widget
function sc_register_dark_weather()
{ /**
   * specify widget to register using the widget object's name
  */
  register_widget( 'SCDW' );
}

// Tie the registration funcion to WordPress using the widgets_init hook
add_action( 'widgets_init', 'sc_register_dark_weather' );
?>
