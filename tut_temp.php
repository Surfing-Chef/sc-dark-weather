<?php
/*
Plugin Name: NTT Social Networks
Plugin URI: http://www.newthinktank.com/wordpress-plugin-howto/
Description: It displays links to Facebook, Twitter and RSS feeds. It was created to show how to create widgets and plugins.
Version: 2.0
Author: Derek Banas
Author URI: http://www.newthinktank.com
License: GPL3
*/
?>
<?php
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
*/
?>
<?php

// Sets up all of the default options for all the variables needed
function ntt_social_networks_install()
{

	$ntt_defaults_array = array( 'ntt_title' => 'Follow Me', 'ntt_facebook' => '', 'ntt_twitter' => '' );

	update_option ('ntt_defaults', $ntt_defaults_array);

}

// To create a widget you have to extend the WP_Widget class
class ntt_link_to_social_networks extends WP_Widget
{


	/**

	* This constructor function initializes the widget

	* This constructor function initializes the widget. It sets the class
	* name for the tag that surrounds the widget. It sets the description
	* that is found in the widget admin section of Wordpress. Calls the parent
	* class constructor for further initialization

	* classname: class name added to the widgets li tag
	* description: describes the widget on the widget admin page
	* __() allows for translation of the text

	*/

	// Constructor
	function ntt_link_to_social_networks()
	{
		$widget_options = array(
			'classname'	=> 'ntt_link_to_social_networks',
			'description' => __('Displays Links to Facebook, Twitter and RSS Feeds') );

		// Call the parent class WP_Widget
		parent::WP_Widget('ntt_link_to_social_networks', 'NTT Social Network Links', $widget_options);

	}


	/** Outputs the contents of the widget
	 * arguments sent from the theme / instance of the class is sent

	 * Default Values for special tags found below
	 * 'before_widget' => '<li id="%1$s" class="widget %2$s">',
 	 * 'after_widget' => "</li>n",
 	 * 'before_title' => '<h2 class="widgettitle">',
 	 * 'after_title' => "</h2>n"

 	 * $title : Contains the title that shows up in the sidebar
 	 * $facebook : Contains the Facebook ID the user choose
 	 * $twitter: Contains the Twitter ID the user choose

 	 **/
	function widget($args, $instance)
	{
		// Splits arguments out and makes them local variables. EXTR_SKIP
		// protects any already created local variables
		extract( $args, EXTR_SKIP );

		// Here if a title is set use it. If not use the default title
		$ntt_title = ( get_option( 'ntt_title') ) ? get_option( 'ntt_title' ) : 'Follow Me';

		$ntt_facebook = ( get_option( 'ntt_facebook') ) ? get_option( 'ntt_facebook' ) : '';

		$ntt_twitter = ( get_option( 'ntt_twitter') ) ? get_option( 'ntt_twitter' ) : '';


		// $before_widget, $after_widget, etc are used for theme compatibility

		?>

<?php echo $before_widget; ?>
<?php echo $before_title . $ntt_title . $after_title; ?>

<?php
		$ntt_feed_icon = plugins_url( 'images/rss_logo.png' , __FILE__ );
		$ntt_facebook_icon = plugins_url( 'images/facebook_logo.png' , __FILE__ );
		$ntt_twitter_icon = plugins_url( 'images/twitter_logo.png' , __FILE__ );
		?>

		<!-- Prints out the icons and attaches the links to the websites to them -->
		<a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php echo $ntt_feed_icon; ?>" height="50px" width="50px"></a>

		<a href="http://www.twitter.com/<?php echo $instance['ntt_twitter']; ?>"><img src="<?php echo $ntt_twitter_icon; ?>" height="50px" width="50px"></a>

		<a href="http://www.facebook.com/<?php echo $instance['ntt_facebook']; ?>"><img src="<?php echo $ntt_facebook_icon; ?>" height="50px" width="50px"></a>

<?php echo $after_widget; ?>

<?php

	}

	// Pass the new widget values contained in $new_instance and update saves
	// everything for you
	function update($new_instance, $old_instance)
	{

		$instance = $old_instance;

		$instance['ntt_title'] = strip_tags( $new_instance['ntt_title'] );

		$instance['ntt_facebook'] = strip_tags( $new_instance['ntt_facebook'] );
		$instance['ntt_twitter'] = strip_tags( $new_instance['ntt_twitter'] );

		return $instance;

	}

	// Displays options in the widget admin section of site
	function form($instance)
	{
		// Set all of the default values for the widget
		$ntt_defaults = array( 'ntt_title' => 'Follow Me', 'ntt_facebook' => '', 'ntt_twitter' => '' );

		// Grab any widget values that have been saved and merge them into an
		// array with wp_parse_args
		$instance = wp_parse_args( (array) $instance, $ntt_defaults );

		$ntt_title = $instance['ntt_title'];
		$ntt_facebook = $instance['ntt_facebook'];
		$ntt_twitter = $instance['ntt_twitter'];


		?>

		<!-- Create the form elements needed to set the widget values
		esc_attr() scrubs potentially harmful text -->
		<p>Title: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'ntt_title' ); ?>" type="text" value="<?php echo esc_attr( $ntt_title ); ?>" /></p>

		<p>Facebook ID: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'ntt_facebook' ); ?>" type="text" value="<?php echo esc_attr( $ntt_facebook ); ?>" /></p>

		<p>Twitter ID: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'ntt_twitter' ); ?>" type="text" value="<?php echo esc_attr( $ntt_twitter ); ?>" /></p>

<?php

		settings_fields( 'ntt_social_network_vars' );

		update_option('ntt_title', $ntt_title);
		update_option('ntt_facebook', $ntt_facebook);
		update_option('ntt_twitter', $ntt_twitter);

	}
}

function ntt_link_to_social_networks_init()
{
	// Registers a new widget to be used in your Wordpress theme
	register_widget('ntt_link_to_social_networks');
}

// Creates the variable options needed for the plugin and settings page
// Allows me to access widget options from any other function
function ntt_register_options()
{

	register_setting( 'ntt_social_network_vars', 'ntt_title' );
	register_setting( 'ntt_social_network_vars', 'ntt_twitter' );
	register_setting( 'ntt_social_network_vars', 'ntt_facebook' );

}

// Creates the settings page for the plugin
function ntt_social_networks_settings()
{

?>

<div>
<h3><?php _e( 'NTT Social Network Widget Options', 'ntt_link_to_social_networks') ?></h3><br />


<form method="post" action="options.php">
	<?php settings_fields( 'ntt_social_network_vars' ); ?>

	<?php _e('Title', 'ntt_link_to_social_networks') ?>
	<input type="text" name="ntt_title" value="<?php echo get_option('ntt_title'); ?>" /><br />

	<?php _e('Twitter ID', 'ntt_link_to_social_networks') ?>
	<input type="text" name="ntt_twitter" value="<?php echo get_option('ntt_twitter'); ?>" /><br />

	<?php _e('Facebook ID', 'ntt_link_to_social_networks') ?>
	<input type="text" name="ntt_facebook" value="<?php echo get_option('ntt_facebook'); ?>" /><br />

	<input type="submit" value="<?php _e('Submit', 'ntt_link_to_social_networks'); ?>" />

	</form>
	</div>

	<?php

}

function ntt_social_networks_create_menu()
{
	// add_menu_page creates a top level menu in the left sidebar
	// add_menu_page(titleOfPage, titleInSidebar, whoCanUseThis, __FILE__,
	// functionThisCalls, logo)
	// whoCanUseThis : manage_options means only admins can use this

	add_menu_page( 'NTT Social Networks', 'NTT Settings', 'administrator', __FILE__, 'ntt_social_networks_settings' );

} // End of the function ntt_social_networks_create_menu


function ntt_social_networks_create_submenu()
{

	// Add a submenu to settings in the left sidebar
	// add_options_page( titleOfPage, titleInSidebar, whoCanUseThis, __FILE__,
	// functionThisCalls )
	// whoCanUseThis : manage_options means only admins can use this

	add_options_page( 'NTT Social Networks', 'NTT Settings', 'administrator', __FILE__, 'ntt_social_networks_settings', plugins_url( 'images/ntt-sm-logo.png', __FILE__) );

} // End of the function ntt_social_networks_create_submenu

/* You can also add submenus to the other menus. add_dashboard_page, add_posts_page, add_media_page, add_links_page, add_pages_page, add_comments_page, add_theme_page, add_plugins_page, add_users_page
*/

// Creates a shortcode capability for the plugin

function ntt_social_network_sc($args, $content = null)
{
		// Splits arguments out and makes them local variables.
		extract(shortcode_atts(array(
			"ntt_twitter" => 'newthinktank',
    		"ntt_facebook" => 'dbanas2',
    		), $atts));

 		// Assigns the location of the social network logos
 		// They are located in the plugins folder in an images folder
		$ntt_feed_icon = plugins_url( 'images/rss_logo.png' , __FILE__ );
		$ntt_facebook_icon = plugins_url( 'images/facebook_logo.png' , __FILE__ );
		$ntt_twitter_icon = plugins_url( 'images/twitter_logo.png' , __FILE__ );

		/* Saves the location of the icons and attaches the links to the websites to them. */

		$ntt_soc_net_content = '<a href="';
		$ntt_soc_net_content .= get_bloginfo('rss2_url');
		$ntt_soc_net_content .= '"><img src="';
		$ntt_soc_net_content .= $ntt_feed_icon;
		$ntt_soc_net_content .= '" height="50px" width="50px"></a>';

		$ntt_soc_net_content .= '<a href="http://www.facebook.com/';
		$ntt_soc_net_content .= $ntt_facebook;
		$ntt_soc_net_content .= '"><img src="';
		$ntt_soc_net_content .= $ntt_facebook_icon;
		$ntt_soc_net_content .= '" height="50px" width="50px"></a>';

		$ntt_soc_net_content .= '<a href="http://www.twitter.com/';
		$ntt_soc_net_content .= $ntt_twitter;
		$ntt_soc_net_content .= '"><img src="';
		$ntt_soc_net_content .= $ntt_twitter_icon;
		$ntt_soc_net_content .= '" height="50px" width="50px"></a>';

		// Return all of the above for printing in the browser
		return $ntt_soc_net_content;

} // End of function ntt_social_network_sc

// Attaches a rule that tells wordpress to call my function when widgets are
// initialized
add_action('widgets_init', 'ntt_link_to_social_networks_init');

// Creates a top level menu in your dashboards left sidebar
add_action( 'admin_menu', 'ntt_social_networks_create_menu' );

// Create a submenu item under settings
add_action( 'admin_menu', 'ntt_social_networks_create_submenu' );

// Call the function that we create all of the options for the plugin being
// title, facebook and twitter
add_action( 'admin_init', 'ntt_register_options' );

// Allows this plugin to be used with a shortcode
add_shortcode( 'nttsocnet', 'ntt_social_network_sc' );

?>
