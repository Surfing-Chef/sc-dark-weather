<?php
/*
  Description: Get Darksky data and write to forecast.json
*/

// API
//require_once 'api.php';

// Composer dependencies
require_once 'vendor/autoload.php';

// Import Forecast namespace
use Forecast\Forecast;

class SCDW_Data
{

  private $sc_token;
  private $sc_long;
  private $sc_lat;

  function SCDW_Data( $sc_token, $sc_lat, $sc_long )
  {
    $this->sc_token = $sc_token;
    $this->sc_lat = $sc_lat;
    $this->sc_long = $sc_long;
  }

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
  // 
  // forecast_cache(
  //   $this->sc_lat,
  //   $this->sc_long,
  //   $this->sc_token);
}
// END class SC_Dark_Weather_Get
