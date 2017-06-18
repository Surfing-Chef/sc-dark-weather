<?php
/**
 *
 * Checks if both forecast.json and arg.php exist,
 * and if forecast needs updating.
 *
 */

// Requirements
require_once 'sc_dark_weather_functions.php';
require_once 'SCDW_Data.inc';

// Create the class
class SCDW_Check
{
  public $sc_token;
  public $sc_lat;
  public $sc_long;
  public $sc_json;
  public $sc_php;

  function checkFiles()
  {
    // Check forecast.json
    if( file_exists( $this->sc_json ) )
    {
      $age = time() - filemtime( $this->sc_json );
      if ($age > 60*30)
      {
        // update forecast.json
        $create = 1;
      }
    } else
    {
      // create forecast.json
      $create = 1;
    }

    // Check args.json
    if( !file_exists( $this->sc_php) )
    {
      // and forecast.json exists
      if ($create < 1)
      {
        // create args.php only
        $create = 2;
      } else {
        // create both forecast.json and args.php
        $create = 3;
      }
    }
    // What needs creating?
    // empty:none, 1:forecast.json, 2:args.php, 3:both
    return $create;
  }
}
