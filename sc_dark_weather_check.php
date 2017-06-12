<?php
// Import Functions
require_once 'sc_dark_weather_functions.php';
// Create a new class
class SC_Dark_Weather_Check
{
  private $sc_token;
  private $sc_long;
  private $sc_lat;
  private $sc_json;
  function __construct( $sc_token, $sc_long, $sc_lat, $sc_json )
  {
    $this->sc_token = $sc_token;
    $this->sc_long = $sc_long;
    $this->sc_lat = $sc_lat;
    $this->sc_json = $sc_json;
  }
  // check if forecast.json exists
  // check age of forecast.json (<> 30 mins)
  public function sc_test_json()
  {
    $file = $this->sc_json;
    if (file_exists($file))
    {
      $age = time() - filemtime( $file );
      if ($age > 60*30)
      {
        return "Need to update forecast.<br>";  // for testing
        $update = true;
        // exit and update
      }
      else
      {
        return "No need to update forecast.<br>"; // for testing
        $update = false;
      }
    }
    else
    {
      return $file . ' is not available. Check the plugin settings.';
    }
  }
  // END function sc_test_json()
  // check if token has changed
  public function sc_test_token()
  {
    return $this->sc_token;
  }
  // Check if latitude or longitude has changed
  public function sc_test_lat_long()
  {
    // If options are set...
    $lat = output_cache('', 'latitude');
    $long = output_cache('', 'longitude');
    // compare construct attributes with plugin values if set
    if ( $lat != $this->sc_lat || $long != $this->sc_long )
    {
      return $lat . ' or ' . $long .' have changed.<br>'; // for testing
      $update = true;
      // exit and update if changed or not set
    }
    else
    {
      return $lat . ', ' . $long .' have not changed.<br>'; // for testing
      $update = false;
    }
  }
  // END function sc_test_lat_long()
}
//class SC_Dark_Weather_Check
