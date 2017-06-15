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
> > 1.5.1 *Classifies* files:

__SC_Dark_Weather_Filter:__ Basis for Check and Compare classes   

__SC_Dark_Weather_Check:__ Extends __SC_Dark_Weather_Filter:__ and checks arguments before passing them to __Compare__  

__SC_Dark_Weather_Compare:__ Extends __SC_Dark_Weather_Filter:__ and compares options set in the options panel to the ones being called for use in __Display__  

__SC_Dark_Weather_Json_Forecast:__ creates a cache file for __Display__ to read from  

__SC_Dark_Weather_Json_Args:__ creates a cache file for *update.php* to read from   

__SC_Dark_Weather_Display:__ displays the Dark Sky weather forecast from data stored in the *forecast.json* file  

_sc_dark_weather.php:_ main plugin file  

_sc_dark_weather_functions:_ contains utility functions   

_update.php:_ file called from outside the scope of WordPress to update the forecast - ie cronjob, scheduled task  

_forecast.json_ container file for data pulled from Darksky.net  

_args.json_ container file for arguments required outside the scope of WordPress  
