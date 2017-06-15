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
class SC_Dark_Weather_Check extends SC_Dark_Weather_Filter
{
  function sc_test()
  {
    $update = array(0, 'OK');

    $testArray = array( $this->sc_token, $this->sc_lat, $this->sc_long, $this->sc_json_f, $this->sc_json_a, $update );

    // THIS ARRAY CONTAINS THE FILTERED, COMPARISON READY ARGUMENTS
    // IT WILL ALSO CONTAIN AN UPDATE ARRAY:
    // TRUE AND A FILENAME OR FALSE and 'OK'
    return $testArray;
  }
}
//class SC_Dark_Weather_Check
