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
class sc_dark_weather extends WP_Widget {

	/**
	 * Contructor - sets up the widgets name etc
	 */
	function sc_dark_weather() {
		$widget_options = array(
			'classname' => 'sc_dark_weather',
			'description' => __( 'Displays a Darksky weather feed' ),
		);
		parent::WP_Widget( 'sc_dark_weather', 'Darksky Weather Display', $widget_options );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

    $title = ( $instance['title'] ) ? $instance['title'] : 'Follow Me';

		$facebook = ( $instance['facebook'] ) ? $instance['facebook'] : '';

		$twitter = ( $instance['twitter'] ) ? $instance['twitter'] : '';

    ?>

<?php echo $before_widget; ?>
<?php echo $before_title . $title . $after_title; ?>

<?php
    $sc_feed_icon = plugins_url( 'images/rss_logo.png' , __FILE__ );
    $sc_facebook_icon = plugins_url( 'images/facebook_logo.png' , __FILE__ );
    $sc_twitter_icon = plugins_url( 'images/twitter_logo.png' , __FILE__ );
    ?>

    <a href="#"><img src="<?php echo $sc_feed_icon; ?>" height="50px" width="50px"></a>

		<a href="#"><img src="<?php echo $sc_twitter_icon; ?>" height="50px" width="50px"></a>

		<a href="#"><img src="<?php echo $sc_facebook_icon; ?>" height="50px" width="50px"></a>

<?php echo $after_widget; ?>

<?php
	}

  /**
   * Processing widget options on save
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   */
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );

		return $instance;
  }


	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
   function form($instance)
   {
     // Set all of the default values for the widget
     $defaults = array( 'title' => 'Follow Me', 'facebook' => '', 'twitter' => '' );

     // Grab any widget values that have been saved and merge them into an
     // array with wp_parse_args
     $instance = wp_parse_args( (array) $instance, $defaults );
     $title = $instance['title'];
     $facebook = $instance['facebook'];
     $twitter = $instance['twitter'];

    ?>

    <p>Title: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p>Facebook ID: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" /></p>

		<p>Twitter ID: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" /></p>
  <?php
	}

}

function sc_dark_weather_init (){
  register_widget('sc_dark_weather');
}

add_action('widgets_init', 'sc_dark_weather_init');

?>
