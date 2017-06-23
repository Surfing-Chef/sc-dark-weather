<?php
/**
 *
 * Contains various utility functions
 *
*/

// Constants
define( 'SCWEATHER_PLUGIN_URL', plugins_url()."/sc-dark-weather/" );

define( 'SCWEATHER_IMG_URL', plugins_url()."/sc-dark-weather/images/" );

define( 'API_ENDPOINT', 'https://api.darksky.net/forecast/' );

// check if given properties return appropriate data
function check_url( $sc_api, $sc_lat, $sc_long )
{
  $testUrl = API_ENDPOINT . $sc_api . '/' . $sc_lat . ',' . $sc_long;

  $response = @file_get_contents($testUrl);

  if ($response){
    $returned = 1;
  } else {
    $returned = 0;
  }
  return $returned;
}

// Pre-parse forecast cache file.
function parse_cache($timeFrame='')
{
  // Get json string
  $string = file_get_contents(SCWEATHER_PLUGIN_URL."forecast.json");

  // Convert to array
  $array = json_decode($string, true);

  // If $timeFrame is specified
  if ($timeFrame != ''){
    $array = $array[$timeFrame];
  } else {
    $array = $array;
  }

  return $array;
}

// Output cache data
function output_cache($timeFrame, $key)
{

  if($timeFrame == "currently"){
    $timeFrame = parse_cache( 'currently' );
  } else if ($timeFrame == "hourly"){
    $timeFrame = parse_cache( 'hourly' );
  } else if ($timeFrame == "daily"){
    $timeFrame = parse_cache( 'daily' );
  } else if ($timeFrame == ""){
    $timeFrame = parse_cache( '' );
  }

  return $timeFrame[$key];
}

// Convert bearing to direction
function getDirection($bearing)
{
 $cardinalDirections = array(
  'N' => array(337.5, 22.5),
  'NE' => array(22.5, 67.5),
  'E' => array(67.5, 112.5),
  'SE' => array(112.5, 157.5),
  'S' => array(157.5, 202.5),
  'SW' => array(202.5, 247.5),
  'W' => array(247.5, 292.5),
  'NW' => array(292.5, 337.5)
 );

 foreach ($cardinalDirections as $dir => $angles)
 {
  if ($bearing >= $angles[0] && $bearing < $angles[1])
  {
   $direction = $dir;
   break;
  }
 }
 return $direction;
}

// Get address
function google_apis_address( $lat, $long )
{
  $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_ENCODING, "");
  $curlData = curl_exec($curl);
  curl_close($curl);

  $address = json_decode($curlData);

  $obj = $address->results;
  $obj = $obj[0]->address_components;
  $locale = $obj[1];
  $locale = $locale->long_name;
  $region = $obj[3];
  $region = $region->short_name;
  $country = $obj[4];
  $country = $country->long_name;

  $address = $locale . ', ' . $region . ', ' . $country;

  return $address;
}

// Default display
function display_default()
{
  // Test url
 $echo = '<br><h3>';
 $echo .= 'Check your secret key entered in the plugin settings';
 $echo .= '</h3>';
 $echo .= '<h3>';
 $echo .= '<a ';
 $echo .= 'href = "https://darksky.net/forecast/50.2963,-117.6857/ca12/en" ';
 $echo .= 'target = "_blank">Or get a secret key from Checkout Darksky.net';
 $echo .= '</a></h3><br>';
 $echo .= '<h3>Other useful weather sites: </h3><br>';
 $echo .= '<ul style = "padding-left: 0; ">';
 $echo .= '<li><a ';
 $echo .= 'href = "https://www.theweathernetwork.com/ca/weather/british-columbia/nakusp" ';
 $echo .= 'target = "_blank">The Weather Network';
 $echo .= '</a></li>';
 $echo .= '<li><a ';
 $echo .= 'href = "http://www.accuweather.com/en/ca/nakusp/v0g/weather-forecast/52854" ';
 $echo .= 'target = "_blank">Accuweather';
 $echo .= '</a></li>';
 $echo .= '<li><a ';
 $echo .= 'href = "https://www.wunderground.com/q/zmw:00000.1.71216" ';
 $echo .= 'target = "_blank">Wunderground';
 $echo .= '</a></li>';
 $echo .= '<li><a ';
 $echo .= 'href = "https://weather.gc.ca/city/pages/bc-38_metric_e.html" ';
 $echo .= 'target = "_blank">Environment Canada';
 $echo .= '</a></li>';
 $echo .= '</ul>';

 return $echo;
}
