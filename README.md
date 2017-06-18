# sc-dark-weather #
A plugin for WordPress as a wrapper for Dark Sky weather service  
## changelog ##
> Current Version: 1.5.1

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

__SCDW_Check:__ `class` - checks if both *forecast.json* and *arg.php* exist, and if *forecast.json* needs updating  

__SCDW_Data:__ `class` - gets Darksky data and writes it to forecast.json.
Also writes token, latitude and longitude data to *forecast.json* for *update.php* to read.

__SCDW_Display:__ `class` - displays the Dark Sky weather forecast from data stored in the *forecast.json* file as HTML output  

_sc_dark_weather.php:_ `php` - main plugin file  

_sc_dark_weather_functions.php:_ `php` - contains utility functions   

_update.php:_ `php` - file called from outside the scope of WordPress to update the forecast - ie cronjob, scheduled task  

_forecast.json_ `json` - container file for data pulled from Darksky.net  

_args.php_ `php` - container file for arguments required outside the scope of WordPress   

### __REMEMBER__ ###
- create a widget area in site header for shortcode  
- check user input when options being entered  
- populate *args.php* when setting options in plugin  
