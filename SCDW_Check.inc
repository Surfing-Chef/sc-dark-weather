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
    return $create; // 0 : none, 1:forecast.json, 2:args.php, 3:both
  }

  function createFiles( $checked )
  {
    $toCreate = '';
    // Checked 1:forecast.json, 2:args.php, 3:both
    if( $checked == 1 || $checked == 3 )
    {
       // create forecast.json
      $toCreate .= 'Creating forecast.json<br>';
      $sc_create = new SCDW_Data( $sc_token, $sc_lat, $sc_long );
      $sc_forecast = $sc_create->forecast_cache(
          $this->sc_lat,
          $this->sc_long,
          $this->sc_token);


    }
    if ( $checked == 2 || $checked == 3 )
    {
      // create args.php
      $toCreate .= 'Creating args.php<br>';
    }

    $return = $toCreate;

    return $return;
  }

}
