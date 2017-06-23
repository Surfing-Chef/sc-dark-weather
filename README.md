# sc-dark-weather #
A plugin for WordPress as a wrapper for Dark Sky weather service  
## changelog ##
> Current Version: 1.6 from origin

> Version: 1.2.0  
> > Based on (this)[http://www.newthinktank.com/2011/05/wordpress-plugin-howto/] tutorial by Derek Banas  
> > - sets up the basic structure using the social media links examples  

> Version: 1.3.0  
> > Based on (this)[http://www.newthinktank.com/2011/05/wordpress-plugin-howto-pt-2/] tutorial by Derek Banas  
> > Adds both an option menu and an option sub-menu linking to an options page for the plugin  
> > Use `register_setting()` function to set widget options   
> > Create install script that sets all default options for plugin usage
> > 1.3.1
> > > Use an existing widget area in sidebar to test and experiment with example
> > >   

> Version: 1.4.0  
> > Starts to tailor the plugin to Dark Sky, based on (sister repository)[https://github.com/Surfing-Chef/sc-weather]
> > Edit Dark Sky options page  
> > Adjust plugin code to reflect new variables  
> > Both Widget and shortcode ready  

> Version: 1.5.0  
> > Creates classes that build the forecast to be displayed to users  
> > 1.5.1 File descriptions:

> Version: 1.6.0  
> > Rebuilds Plugin from a more basic structure using classes developed in 1.5  
> > > References: [WPMUDEV: Code Your Own Custom WordPress Widget](https://premium.wpmudev.org/blog/create-custom-wordpress-widget/?imob=c&utm_expid=3606929-106.UePdqd0XSL687behGg-9FA.2&utm_referrer=https%3A%2F%2Fgithub.com%2FSurfing-Chef%2FBourbon-WP)  
> > > References: [WordPress.org Codex: Creating Options Pages](https://codex.wordpress.org/Creating_Options_Pages)  
> > > References: [WordPress.org Codex: Administration Menus](https://codex.wordpress.org/Adding_Administration_Menus)  
> > > References: [WordPress.org Developer: *add_menu_page* function](https://developer.wordpress.org/reference/functions/add_menu_page/)  

### NOTES TO DO: ###
- import files and classes from *new-widget* and *branch 1.5.1*  
- implement classes and files into plugin file  
- be sure to pull changes from github into bourbon-wp theme and plugin folders on other local WordPress development installs  
- new plugins are admin-style, sc-dark-weather, and new-widget
