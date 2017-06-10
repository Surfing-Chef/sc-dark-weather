<?php
/*
Plugin Name: SC Dark Weather
Plugin URI: https://github.com/Surfing-Chef/Dark
Description: Uses a wrapper to display a weather feed from Darksky.net
Version: 1.6
Author: Surfing-Chef
Author URI: https://github.com/Surfing-Chef
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: sc-dark-weather
*/

// Exit if accessed directly
defined( 'ABSPATH' ) or die( "Error: contact admin@surfing-chef.com" );

/**
* Adds SC_Dark_Weather widget
* by extending the WP_Widget class
*/
class SC_Dark_Weather extends WP_Widget {

  /**
  * Register widget with WordPress.
  * Sets up the widgets name etc
  */
	function __construct()
  {
		$widget_ops = array(
			'classname' => 'sc_dark_weather',
			'description' => esc_html__( 'Displays a Dark Sky weather feed', 'sc-dark-weather' ),
		);
		parent::__construct(
      'sc_dark_weather', // Base ID
      esc_html__( 'SC Dark Weather', 'sc-dark-weather' ), // Name
      $widget_ops ); // Args
	}
  // END :: function __construct()

  /**
  * Front-end display of widget.
  * Outputs the content of the widget
  *
  * @see WP_Widget::widget()
  *
  * @param array $args     Widget arguments.
  * @param array $instance Saved values from database.
  */
  public function widget( $args, $instance )
  {
    echo $args['before_widget'];

    if ( ! empty( $instance['title'] ) )
    {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }

    echo esc_html__( 'Hello, World!', 'text_domain' );
    echo $args['after_widget'];
  }
  // END :: public function widget( $args, $instance )

  /**
  * Back-end widget form.
  * Outputs the options form on admin
  *
  * @see WP_Widget::form()
  *
  * @param array $instance Previously saved values from database.
  */
	public function form( $instance )
  {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );

		?>

		<p>
  		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>

  		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<?php
	}
  // END :: public function form( $instance )

  /**
  * Sanitize widget form values as they are saved.
  * Processing widget options on save
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance Values just sent to be saved.
  * @param array $old_instance Previously saved values from database.
  *
  * @return array Updated safe values to be saved.
  */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
//  END :: class SC_Dark_Weather extends WP_Widget

/**
* Register widget when hook is called.
*
* @see register_widget()
*
* @param string $widget_class The name of a class that extends.
*/
// Register a new widget to be used in a theme
function sc_dark_weather_init()
{
  register_widget('sc_dark_weather');
}
// END of function sc_dark_weather_init ()

// register SC_Dark_Weather widget
add_action( 'widgets_init', 'sc_dark_weather_init' );
