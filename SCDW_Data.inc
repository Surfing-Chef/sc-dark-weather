<?php
/**
 *
 * Get Darksky data and write to forecast.json
 * Write data to forecast.json
 *
*/

// Composer dependencies
require_once 'vendor/autoload.php';

// Import Forecast namespace
use Forecast\Forecast;

class SCDW_Data
{

  private $sc_token;
  private $sc_long;
  private $sc_lat;
  private $sc_json;
  private $sc_php;

  function SCDW_Data( $sc_token, $sc_lat, $sc_long, $sc_json, $sc_php  )
  {
    $this->sc_token = $sc_token;
    $this->sc_lat = $sc_lat;
    $this->sc_long = $sc_long;
    $this->sc_json = $sc_json;
    $this->sc_php = $sc_php;
  }

  // Create a forecast cache file.
  private function forecast_cache ( $lat, $long, $token )
  {
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

     return $options;
  }

  public function build_forecast_json()
  {
    $options = $this->forecast_cache( $this->sc_lat, $this->sc_long, $this->sc_token );

    // Store json string to file
    $fp = fopen( $this->sc_json, 'w' );
    fwrite( $fp, $options );
    fclose( $fp );
  }

  private function args_cache ( $lat, $long, $token )
  {
    $options = '<?php '
                . '$token = \'' . $token . '\'; '
                . '$lat = \'' . $lat . '\'; '
                . '$long = \'' . $long . '\'; '
                . '?>';

     return $options;
  }

  public function build_args_php()
  {
    $options = $this->args_cache( $this->sc_lat, $this->sc_long, $this->sc_token );

    // Store json string to file
    $fp = fopen( $this->sc_php, 'w' );
    fwrite( $fp, $options );
    fclose( $fp );
  }

}

// END class SC_Dark_Weather_Get
