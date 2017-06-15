<?php
/**
 *
 * Compares options set in the options panel to the ones being called
 * for use in Display SC_Dark_Weather_Compare
 *
 * @param    $checked      =  array (  string  api
 *                                  string lat
 *                                  string long
 *                                  string json_forecast
 *                                  string json_args
 *                                )
 * @return   $ready   =  array (  string  api
 *                                  string lat
 *                                  string long
 *                                  string json_forecast
 *                                  array  update ( boolean,
 *                                                  string   item to update
 *                                                )
 *                                )
 */

// Requirements
require_once 'sc_dark_weather_functions.php';

// Create the class
class SC_Dark_Weather_Compare extends SC_Dark_Weather_Filter
  {
  function sc_test()
  {
    $update = array(0, 'OK');

    $testArray = array( $this->sc_token, $this->sc_lat, $this->sc_long, $this->sc_json_f, $this->sc_json_a, $update );

    // IT WILL ALSO CONTAIN AN UPDATE ARRAY:
    // TRUE AND A FILENAME OR FALSE and 'OK'
    return $testArray;
  }
}
