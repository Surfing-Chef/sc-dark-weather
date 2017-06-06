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
// To create a widget you have to extend the WP_Widget class
class sc_dark_weather extends WP_Widget {

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

	// Constructor
	function sc_dark_weather() {
		$widget_options = array(
			'classname' => 'sc_dark_weather',
			'description' => __( 'Displays a Darksky weather feed' ),
		);
		parent::WP_Widget( 'sc_dark_weather', 'Darksky Weather Display', $widget_options );
	}

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
	function widget( $args, $instance ) {
    // Splits arguments out and makes them local variables. EXTR_SKIP
    // protects any already created local variables
		extract( $args, EXTR_SKIP );

    // Here if a title is set use it. If not use the default title
    $title = ( $instance['title'] ) ? $instance['title'] : 'Follow Me';

		$facebook = ( $instance['facebook'] ) ? $instance['facebook'] : '';

		$twitter = ( $instance['twitter'] ) ? $instance['twitter'] : '';

    // $before_widget, $after_widget, etc are used for theme compatibility

    ?>

<?php echo $before_widget; ?>
<?php echo $before_title . $title . $after_title; ?>

<?php
    $sc_feed_icon = plugins_url( 'images/rss_logo.png' , __FILE__ );
    $sc_facebook_icon = plugins_url( 'images/facebook_logo.png' , __FILE__ );
    $sc_twitter_icon = plugins_url( 'images/twitter_logo.png' , __FILE__ );
    ?>

    <!-- Prints out the icons and attaches the links to the websites to them -->
    <a href="#"><img src="<?php echo $sc_feed_icon; ?>" height="50px" width="50px"></a>

		<a href="#"><img src="<?php echo $sc_twitter_icon; ?>" height="50px" width="50px"></a>

		<a href="#"><img src="<?php echo $sc_facebook_icon; ?>" height="50px" width="50px"></a>

<?php echo $after_widget; ?>

<?php
	}

  /**
   * Processing widget options on save
   * Pass the new widget values contained in $new_instance and update saves
   * everything for you
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
	 * Displays options in the widget admin section of site
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

    <!-- Create the form elements needed to set the widget values
    esc_attr() scrubs potentially harmful text -->
    <p>Title: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p>Facebook ID: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" /></p>

		<p>Twitter ID: <input class="scdarkweather" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" /></p>
  <?php
	}

}

function sc_dark_weather_init (){
  // Registers a new widget to be used in your Wordpress theme
  register_widget('sc_dark_weather');
}

// Attaches a rule that tells wordpress to call my function when widgets are
// initialized
add_action('widgets_init', 'sc_dark_weather_init');

?>
