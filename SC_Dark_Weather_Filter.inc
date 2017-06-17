<?php
/**
 *
 * Checks arguments before passing them to SC_Dark_Weather_Compare
 *
 * @param    $args      =   array(  string api,
 *                                  string lat,
 *                                  string long,
 *                                  string json_forecast,
 *                                  string json_args,
 *                                )
 * @return   $checked   =   array(  string  api,
 *                                  string lat,
 *                                  string long,
 *                                  string json_forecast,
 *                                  string json_args,
 *                                  array  update ( boolean,
 *                                                  string   item to update
 *                                                )
 *                                )
 */

// Requirements
require_once 'sc_dark_weather_functions.php';

// Create the class
class SC_Dark_Weather_Filter
{
  private $sc_token;
  private $sc_lat;
  private $sc_long;
  private $sc_json_f;
  private $sc_json_a;

  function __construct( $args )
  {
    $this->sc_token = $args[0];
    $this->sc_lat = $args[1];
    $this->sc_long = $args[2];
    $this->sc_json_f = $args[3];
    $this->sc_json_a = $args[4];
  }


    // public function sc_test()
    // {
    //   // array to contain file, token, long, lat, update bool
    //   $sc_checked = array();
    //
    //   $file = $this->sc_json;
    //   $sc_token = $this->sc_token;
    //   $sc_lat = $this->lat;
    //   $sc_long = $this->long;
    //
    //   // check if forecast.json exists
    //   // check age of forecast.json (<> 30 mins)
    //   if (file_exists($file))
    //   {
    //     $age = time() - filemtime( $file );
    //     if ($age > 60*30)
    //     {
    //       // update
    //       $sc_checked[0] = $file;
    //       $sc_checked[4] = true;
    //       // exit and update
    //     }
    //     else
    //     {
    //         // all is good
    //       $sc_checked[0] = $file;
    //       $sc_checked[4] = false;
    //     }
    //   }
    //   else
    //   {
    //     $sc_checked[0] = 'forecast.json';
    //     $sc_checked[4] = true;
    //   }
    // }
    // END file test

    // check if token has changed
    // public function sc_test_token()
    // {
    //   //if token is the same
    //   return $this->sc_token;
    // }

    // Check if latitude or longitude has changed
    // public function sc_test_lat_long()
    // {
    //   // If options are set...
    //   $lat = output_cache('', 'latitude');
    //   $long = output_cache('', 'longitude');
    //   // compare construct attributes with plugin values if set
    //   if ( $lat != $this->sc_lat || $long != $this->sc_long )
    //   {
    //     return $lat . ' or ' . $long .' have changed.<br>'; // for testing
    //     $update = true;
    //     // exit and update if changed or not set
    //   }
    //   else
    //   {
    //     return $lat . ', ' . $long .' have not changed.<br>'; // for testing
    //     $update = false;
    //   }
    // }
    // END function sc_test_lat_long()
  
}
// class SC_Dark_Weather_Filter
