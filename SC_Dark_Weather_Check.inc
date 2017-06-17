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
require_once 'args.php';

// Create the class
class SC_Dark_Weather_Check
{
  private $sc_token;
  private $sc_lat;
  private $sc_long;
  private $sc_json_f;
  private $sc_json_a;

  function SC_Dark_Weather_Check( $args )
  {
    $this->sc_token = $args[0];
    $this->sc_lat = $args[1];
    $this->sc_long = $args[2];
    $this->sc_json_f = $args[3];
    $this->sc_json_a = $args[4];
  }

  function sc_check()
  {
    $sc_token = $this->sc_token;
    $sc_lat = $this->sc_lat;
    $sc_long = $this->sc_long;
    $sc_json_f = $this->sc_json_f;
    $sc_json_a = $this->sc_json_a;

    $errors[] = '';

    // Check token
    $testUrl = 'https://api.darksky.net/forecast/' . $sc_token . '/37.8267,-122.4233';
    $response = @file_get_contents($testUrl);
    if($response)
    {
      $checkedArray[0] = $sc_token;
    } else {
      array_push( $errors,'token' );
      $checkedArray[0] = $sc_token_default;
    }

  // Check latitude
    if( !is_numeric( $sc_lat ) )
    {
      array_push( $errors, 'lat');
    } else
    {
      $checkedArray[1] = $sc_lat;
    }

    // Check Longitude
    if( !is_numeric( $sc_long ) )
    {
      array_push( $errors, 'long');
    } else
    {
      $checkedArray[2] = $sc_long;
    }

    // Check forecast.json
    if( file_exists( $sc_json_f ) )
    {
      $checkedArray[3] = $sc_json_f;
    } else
    {
      $checkedArray[3] = $sc_json_f;
      array_push( $errors, 'json_f');
    }

    // Check args.json
    if( file_exists( $sc_json_a) )
    {
      $checkedArray[4] = $sc_json_a;
    } else
    {
      $checkedArray[4] = $sc_json_a;
      array_push( $errors, 'json_a');
    }

    // Add errors
    $checkedArray[5] = array();
    foreach ( $errors as $key => $value ) {
      if( $value != '' ){
        array_push( $checkedArray[5], $value);
      }
    }

    // THIS ARRAY CONTAINS THE FILTERED, COMPARISON READY ARGUMENTS
    return $checkedArray;
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
//class SC_Dark_Weather_Check
