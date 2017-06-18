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
