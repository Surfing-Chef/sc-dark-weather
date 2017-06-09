<?php
/*
Description: Get Darksky data and write to forecast.json
*/

// API
require_once 'api.php';

// Composer dependencies
require_once 'vendor/autoload.php';

// Import Forecast namespace
use Forecast\Forecast;

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

forecast_cache ( '50.296256', '-117.685750', $api );
