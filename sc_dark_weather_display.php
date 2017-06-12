<?php
// WordPress check to deny direct access to the file
//defined( 'ABSPATH' ) or die( "Error: contact admin@surfing-chef.com" );

// Import Functions
require 'sc_dark_weather_functions.php';

// Create a new class
class SC_Dark_Weather_Display
{
  //
  // private $sc_token;
  // private $sc_long;
  // private $sc_lat;
  //
  // function __construct( $sc_token, $sc_long, $sc_lat )
  // {
  //   $this->sc_token = $sc_token;
  // }

  // function getToken(){ return $this->sc_token; }
  // function getLong(){ return $this->sc_long; }
  // function getLat(){ return $this->sc_lat; }

  function sc_check($sc_api, $sc_long, $sc_lat)
  {
    // check if forecast.json exists
    // check age of forecast.json
    // check if long and lat have changed
  }

  function sc_weather_output( $sc_api, $sc_long, $sc_lat )
  {

    $sc_weather_output = '<section id="sc-forecast" class="container-forecast">';

      $sc_weather_output .= '<header class="sc-weather-header">';
        $sc_weather_output .= '<span>Weather: '. $sc_long . ', ' . $sc_lat .'</span>';
        $sc_weather_output .= '<a href="https://darksky.net/forecast/50.2963,-117.6857/ca12/en" target="_blank">Powered by Dark Sky</a>';
      $sc_weather_output .= '</header>';

      $sc_weather_output .= '<div class="container-currently">';

        $sc_weather_output .= '<article class="container-icon-temp">';
          $sc_weather_output .= '<div class="icon-current">';

            $sc_weather_output .= '<img src="' . SCWEATHER_IMG_URL . output_cache('currently', 'icon') . '.png" alt="">';
          $sc_weather_output .= '</div>';

          $sc_weather_output .= '<div class="temp-current">';
            $sc_weather_output .= round(output_cache('currently', 'temperature')) . '&deg;';
          $sc_weather_output .= '</div>';
        $sc_weather_output .= '</article>';

        $sc_weather_output .= '<article class="container-summary-wind">';
          $sc_weather_output .= '<div class="summary-current">';
            $sc_weather_output .= output_cache('currently', 'summary');
          $sc_weather_output .= '</div>';

          $sc_weather_output .= '<div class="summary-wind">';
            $sc_weather_output .= 'Wind: ' . round(output_cache('currently', 'windSpeed')) . 'm/s (' . getDirection(round(output_cache('currently', 'windBearing'))) . ')';
          $sc_weather_output .= '</div>';
        $sc_weather_output .= '</article>';

      $sc_weather_output .= '</div>';
      $sc_weather_output .= '<!-- END container-currently -->';

      $sc_weather_output .= '<div class="container-daily">';

      // find height of graphical temp display
      // using max and min temps
      $max=-100;
      $min=200;
      foreach (output_cache('daily', 'data') as $key => $value) {
        $tempMax = round($value['temperatureMax']);
        if($max < $tempMax){
          $max = $tempMax;
        }

        $tempMin = round($value['temperatureMin']);
        if($min > $tempMin){
          $min = $tempMin;
        }
      }

      // display data
      $timezone = parse_cache()['timezone'];
      foreach (output_cache('daily', 'data') as $key => $value) {
        $sc_weather_output .= '<div class="daily-day">';

        // day
        if($key == 0){
          $time = "Today";
        } else {
          $time = $value['time'];
          $time = date('D', $time);
        }
        $sc_weather_output .= '<h4>' . $time . '</h4>';

        // icon
        $icon = $value['icon'];
          $sc_weather_output .= '<div class="icon-daily"><img src="' . SCWEATHER_IMG_URL . $icon . '"></div>';

        // temperatures
        $tempMax = round($value['temperatureMax']);
        $tempMin = round($value['temperatureMin']);
        $topOffset = 50 + ($max - $tempMax)*3;
        $temp_height = 4*($tempMax-$tempMin);

          $sc_weather_output .= '<div class="temp-daily-container" style="top: ' . $topOffset . 'px;"\>';

              $sc_weather_output .= '<span class="max temp-daily">' . $tempMax . '&deg;</span>';

            // chart temperature
            $sc_weather_output .= '<div class="temp-graph" style="width: 1em; height: ' . $temp_height . 'px;"></div>';

            $sc_weather_output .= '<span class="min temp-daily">' . $tempMin . '&deg;</span>';

          $sc_weather_output .= '</div>';

        $sc_weather_output .= '</div>';
      }


      $sc_weather_output .= '</div>';
      $sc_weather_output .= '<!-- END container-daily -->';


    $sc_weather_output .= '</section>';

    $sc_test = "Class Instantiated";

    //return $sc_test;
    return $sc_weather_output;

  }
  // function sc_weather_output
}
//class SC_Dark_Weather
