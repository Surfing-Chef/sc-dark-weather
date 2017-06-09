<?php
// Functions
function display_weather (){
  require_once 'sc-weather-page.php';
};
add_shortcode( 'sc_weather', 'display_weather' );
