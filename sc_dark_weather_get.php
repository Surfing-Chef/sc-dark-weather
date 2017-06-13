<?php
/*
Description: Get Darksky data and write to forecast.json
*/

// default api
require_once 'api.php';

// Required Classes
require_once 'SC_Dark_Weather_Check.php';
require_once 'SC_Dark_Weather_Data.php';
require_once 'SC_Dark_Weather_Display.php';

// Set up Forecast properties
$sc_check_data = array();

// token
if( is_null(get_option( 'sc_api' ) ) {
  $sc_token = $api;  // from api.php
} else {
  $sc_token = get_option( 'sc_api' );  // from plugin/widget options
}

// latitude
if( is_null(get_option( 'sc_latitude' ) ) {
  $sc_lat = '50.296256';
} else {
  $sc_lat = get_option( 'sc_latitude' ); // from plugin/widget options
}

// longitude
if( is_null(get_option( 'sc_longitude' ) ) {
  $sc_long = '-117.68575';
} else {
  $sc_long = get_option( 'sc_longitude' ); // from plugin/widget options
}

// file
$sc_json = $_SERVER['DOCUMENT_ROOT'] .'/Bourbon-WP/wp-content/plugins/sc-dark-weather/forecast.json';

// Instantiate new Check class
$sc_dark_weather_check = new SC_Dark_Weather_Check( $sc_token, $sc_long, $sc_lat, $sc_json );

// check Forecast properties
// returns $sc_checked[ file, token, long, lat, update bool ]
$sc_checked = $sc_dark_weather_check->sc_test();

// Update( SC_Dark_Weather_Data ) if necessary? or display ( SC_Dark_Weather_Display )

// Instantiate new forecast class
$sc_dark_weather_forecast = new SC_Dark_Weather_Data; // add constructor properties($lat, $long, $token from check class)

// pull
$sc_array = $sc_dark_weather_forecast->sc_dark_weather_array();

$lat = $sc_array[0];
$long = $sc_array[1];
$token = $sc_array[2];

$sc_dark_weather_forecast->forecast_cache( $lat='50.296256', $long='-117.685750', $token='b72b69aa7e2f57d2d8c24ec1594a79b0' )
//forecast_cache ( '50.296256', '-117.685750', $api );
