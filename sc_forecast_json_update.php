<?php
/*
  Description: Get Darksky data and write to forecast.json if called outside of WordPress
*/

// Requirements
require_once 'args.php';

// Composer dependencies
require_once 'vendor/autoload.php';

// Import Forecast namespace
use Forecast\Forecast;

// Retrieve values from args.php
$token = $token;
$lat = $lat;
$long = $long;

// Create a forecast cache file.
function forecast_cache ( $lat, $long, $token ){
   // Instantiate a new Forecast object
   $forecast = new Forecast( $token );

   // Get forecast object as json string
   $options = json_encode( $forecast->get(
     $lat,
     $long,
     null,
     array(
       'units' => 'si',
       'exclude' => 'flags'
     )
   ));

   // Store json string to file
  $fp = fopen( 'forecast.json', 'w' );
  fwrite( $fp, $options );
  fclose( $fp );
}

forecast_cache ( $lat, $long, $token );

/* FILEPATHS

/usr/bin/php

/usr/local/bin/php

/usr/local/lib/php

/usr/local/php

File directory is: /home/webmullet01/public_html

/usr/local/bin/php -q /home/webmullet01/public_html/wp-content/plugins/sc-dark-weather/sc_forecast_json_update.php

/usr/bin/php -f /home/webmullet01/public_html/wp-content/plugins/sc-dark-weather/sc_forecast_json_update.php
/usr/local/bin/php -f /home/webmullet01/public_html/wp-content/plugins/sc-dark-weather/sc_forecast_json_update.php

*/
