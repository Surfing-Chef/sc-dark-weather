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
    if( file_exists( $this->sc_json_f ) )
    {
      $age = time() - filemtime( $this->sc_json_f );
      if ($age > 60*30)
      {
        echo 'Forecast.json exists but needs updating.<br><br>';
      }
      else
      {
        // all is good
        echo 'Forecast.json exists and is recent.<br><br>';
      }
    } else
    {
      echo 'Forecast.json does not exist and needs creating.<br><br>';
      $create = 1;
    }

    // Check args.json
    if( file_exists( $this->sc_json_a) )
    {
      echo 'Args.php exists.<br><br>';
    } else
    {
      echo 'Args.php does not exist and needs creating.<br><br>';
      if ($create < 1)
      {
        $create = 2;
      } else {
        $create = 3;
      }
    }
    // What needs creating?
    // empty:none, 1:forecast.json, 2:args.php, 3:both
    return $create;
  }
}
